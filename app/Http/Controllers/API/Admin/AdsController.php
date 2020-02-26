<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
	
	public function update($slug){
		$ad=Ad::where('slug',$slug)->first();
	    $adpro=Adspro::where('ad',$ad->id)->first();
	    if(empty($adpro)){
	        $error = \Illuminate\Validation\ValidationException::withMessages([
	           'redirect' => ['This Advertise Still Haven\'t communication data'],
	        ]);
	        throw $error;
	    }
      	Ad::where('slug',$slug)->update(['show'=>1]);
      	session()->push('m','success');
	    session()->push('m','Advertise Approved!');
  		return back();
    }
	
    public function destroy($slug){
		Ad::where('slug',$slug)->update(["deleted_by"=>Auth::guard('admin')->user()->id]);
        Ad::remove($slug);
		session()->push('m','success');
	    session()->push('m','Advertise Removed!');
        return back();
    }
}