<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adspro;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;

class AdsController extends Controller
{
    public function __construct(){
        $messagescount = Message::where('seen',0)->count();
        View::share('messagescount',$messagescount);
        $newads = Ad::where('seen',0)->count();
        View::share('newads',$newads);
    }

    public function approve(){
        $ads=Ad::where('seen',0)->orderBy('id','desc')->paginate(10);
        $oldads=Ad::where('seen',1)->where('show',0)->orderBy('id','desc')->paginate(10);
        Ad::where('seen',0)->orderBy('id','desc')->limit(10)->update(['seen'=>1]);
        return view('admin/approve',compact('ads','oldads'));
    }

    public function show($id){
        $adpro = Adspro::where('ad_id', $id)->first();
        if (empty($adpro)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'redirect' => ['This Advertise Still Haven\'t communication data'],
            ]);
            throw $error;
        }
        $name = $adpro->name;
        $phone = $adpro->phone;
        $email = $adpro->email;

        return redirect('/review/' . $id . '?name=' . $name . '&phone=' . $phone . '&email=' . $email);
    }

    public function index(){
        $ads=Ad::with('profile')->where('seen',1)->whereHas('profile')->latest()->paginate(20);
        return view('admin/adscontrol',compact('ads'));
    }
	
	public function update($id){
		$ad=Ad::findOrFail($id);
	    $adpro=Adspro::where('ad_id',$ad->id)->first();
	    if(empty($adpro)){
	        $error = \Illuminate\Validation\ValidationException::withMessages([
	           'redirect' => ['This Advertise Still Haven\'t communication data'],
	        ]);
	        throw $error;
	    }
      	$ad->show=1;
	    $ad->save();
      	session()->push('m','success');
	    session()->push('m','Advertise Approved!');
  		return back();
    }
	
    public function destroy($id){
        $ad=Ad::findOrFail($id);
		$ad->update(["updated_by"=>Auth::guard('admin')->user()->id]);
        $ad->delete();
		session()->push('m','success');
	    session()->push('m','Advertise Removed!');
        return back();
    }
}