<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adspro;
use App\Models\Report;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Support\Facades\View;
use Session;
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
        $reports=Report::where('seen',0)->count();
        View::share('reports',$reports);
    }

    public function approve(){
        $ads=Ad::where('seen',0)->orderBy('id','desc')->paginate(10);
        $oldads=Ad::where('seen',1)->where('show',0)->orderBy('id','desc')->paginate(10);
        Ad::where('seen',0)->orderBy('id','desc')->limit(10)->update(['seen'=>1]);
        return view('admin/approve',compact('ads','oldads'));
    }

    public function show($slug){
        $ad = Ad::where('slug', $slug)->with('profile')->first();
        if (empty($ad->profile)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'redirect' => ['This Advertise Still Haven\'t communication data'],
            ]);
            throw $error;
        }
        $name = $ad->profile->name;
        $phone = $ad->profile->phone;
        $email='';
        if($ad->profile->email_show==1){
            $email = $ad->profile->email;
        }

        return redirect('/review/' . $slug . '?name=' . $name . '&phone=' . $phone . '&email=' . $email);
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
