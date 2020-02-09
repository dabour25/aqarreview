<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Link;

class adminprocess extends Controller
{
	public function __construct(){
	}
	public function approve($id){
	    $adpro=Adspro::where('ad',$id)->first();
	    if(empty($adpro)){
	        $error = \Illuminate\Validation\ValidationException::withMessages([
	           'redirect' => ['This Advertise Still Haven\'t communication data'],
	        ]);
	        throw $error;
	    }
      	Ad::where('id',$id)->update(['show'=>1]);
      	session()->push('m','success');
	    session()->push('m','Advertise Approved!');
  		return back();
    }
    public function removead($id){
      	$ad=Ad::where('id',$id)->first();
      	$images=explode('|', $ad->images);
      	foreach ($images as $k => $img) {
      		@unlink('img/ads/'.$img);
      	}
      	@unlink('img/ads/'.$ad->image);
      	Adspro::where('ad',$id)->delete();
      	Ad::where('id',$id)->delete();
      	session()->push('m','success');
	    session()->push('m','Advertise Removed!');
  		return back();
    }
	public function links(Request $req){
	    $phone=$req->input('phone');
		$email=$req->input('email');
		$face=$req->input('face');
		$twit=$req->input('twit');
		$inst=$req->input('inst');
		Links::where('id',1)->update(['value'=>$phone]); Links::where('id',2)->update(['value'=>$email]);
		Links::where('id',3)->update(['value'=>$face]); Links::where('id',4)->update(['value'=>$twit]);
		Links::where('id',5)->update(['value'=>$inst]);
		session()->push('m','success');
	    session()->push('m','Data Updates Saved');
		return back();
	}
	public function adsdefault(Request $req){
	    $valarr=[
	       'default'=>'required|max:8192|mimes:jpg,jpeg,gif,png',
	    ];
	    $this->validate($req,$valarr);
	    $image=$req->file('default');
	    $old=Link::where('id',6)->first();
	    @unlink('img/ads/'.$old->value);
	    $photosPath = public_path('/img/ads');
	    $photoName='default';
		$photoName.='.'.$image->getClientOriginalExtension();
		$image->move($photosPath,$photoName);
		Link::where('id',6)->update(['value'=>$photoName]);
		session()->push('m','success');
	    session()->push('m','Image Updated Saved');
		return back();
	}
	public function removeuser($id){
		$ads=Ad::where('user',$id)->get();
		foreach ($ads as $v) {
			Ad::where('id',$id)->update(['user'=>0]);
		}
		User::where('id',$id)->delete();
		session()->push('m','success');
	    session()->push('m','User Removed Successfully');
		return back();
	}
}