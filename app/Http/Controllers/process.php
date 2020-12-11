<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Support\Str;
use Session;
use View;
//DB Connect
use App\Models\Message;
use App\Models\User;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Fav;

class process extends Controller
{
	public function __construct(){
	}

	public function edituser(Request $req){
  		$valarr=[
	       'name'=>'required|max:50|min:3',
	       'role'=>'required'
	    ];
	    $this->validate($req,$valarr);
	    $name=$req->input('name');
	    $phone=$req->input('phone');
		if($req->input('password')!=''){
			$valarr=[
		       'password'=>'required|max:60|min:8|regex:/[A-z]*[0-9]+[A-z]*/|confirmed'
		    ];
		    $this->validate($req,$valarr);
		    $password=Hash::make($req->input('password'));
		}else{
			$password=Auth::user()->password;
		}
		$role=$req->input('role');
		if($role=='admin'){
			$role='user';
		}
		Users::where('id',Auth::user()->id)->update(['name'=>$name,'phone'=>$phone,'password'=>$password,'role'=>$role]);
		session()->push('m','success');
		if(Session::has('lang'))
	    	session()->push('m','Your Data Updated');
	    else
	    	session()->push('m','تم تحديث بياناتك');
		return back();
	  }
	  public function removead($id){
      	$ad=Ad::where('id',$id)->where('user',Auth::user()->id)->first();
      	if(empty($ad)){
      		session()->push('m','danger');
	    	session()->push('m','Advertise Not Found - Un Authorized!');
      		return redirect('/search');
      	}
      	$images=explode('|', $ad->images);
      	foreach ($images as $k => $img) {
      		@unlink('img/ads/'.$img);
      	}
      	@unlink('img/ads/'.$ad->image);
      	Adspro::where('ad',$id)->delete();
      	Ad::where('id',$id)->delete();
      	session()->push('m','success');
	    session()->push('m','Advertise Removed!');
  		return redirect('/search');
    }
    public function fav($id){
		if(!Auth::user()){
			return response()->json(array('msg'=> 'Error : You Must Login first','type'=>0), 200);
		}
		$chk=Fav::where('user_id',Auth::user()->id)->where('ad_id',$id)->first();
		if(empty($chk)){
			Fav::insert(['user_id'=>Auth::user()->id,'ad_id'=>$id]);
			return response()->json(array('msg'=> 'Added To Favourites','type'=>1), 200);
		}else{
			Fav::where('id',$chk->id)->delete();
			return response()->json(array('msg'=> 'Removed From Favourites','type'=>2), 200);
		}
	}
}
