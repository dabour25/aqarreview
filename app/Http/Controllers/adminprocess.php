<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Users;
use App\Messages;
use App\Ads;
use App\Adspro;
use App\Links;

class adminprocess extends Controller
{
	public function __construct(){
		$this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $role = Auth::user()->role;
            if($role!='admin'){
                return redirect('/');
            }else{
                return $next($request);
            }
        });
	}
	public function approve($id){
	    $adpro=Adspro::where('ad',$id)->first();
	    if(empty($adpro)){
	        $error = \Illuminate\Validation\ValidationException::withMessages([
	           'redirect' => ['This Advertise Still Haven\'t communication data'],
	        ]);
	        throw $error;
	    }
      	Ads::where('id',$id)->update(['show'=>1]);
      	session()->push('m','success');
	    session()->push('m','Advertise Approved!');
  		return back();
    }
    public function removead($id){
      	$ad=Ads::where('id',$id)->first();
      	$images=explode('|', $ad->images);
      	foreach ($images as $k => $img) {
      		@unlink('img/ads/'.$img);
      	}
      	@unlink('img/ads/'.$ad->image);
      	Adspro::where('ad',$id)->delete();
      	Ads::where('id',$id)->delete();
      	session()->push('m','success');
	    session()->push('m','Advertise Removed!');
  		return back();
    }
    public function editusers(Request $req){
	    $name=$req->input('name');
	    $phone=$req->input('phone');
		$email=$req->input('email');
		$password=$req->input('password');
		$role=$req->input('role');
		$users=Users::all();
		foreach ($users as $u) {
			if (array_key_exists($u->id,$password)){
				if($password[$u->id]!=null){
					$pass=Hash::make($password[$u->id]);
				}else{
					$pass=$u->password;
				}
				if($u->id==1){
					$role[1]='admin';
				}
				Users::where('id',$u->id)->update(['name'=>$name[$u->id],'phone'=>$phone[$u->id],'email'=>$email[$u->id],'password'=>$pass,'role'=>$role[$u->id]]);	
			}
		}
		session()->push('m','success');
	    session()->push('m','All Users Updates Saved');
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
	    $old=Links::where('id',6)->first();
	    @unlink('img/ads/'.$old->value);
	    $photosPath = public_path('/img/ads');
	    $photoName='default';
		$photoName.='.'.$image->getClientOriginalExtension();
		$image->move($photosPath,$photoName);
		Links::where('id',6)->update(['value'=>$photoName]);
		session()->push('m','success');
	    session()->push('m','Image Updated Saved');
		return back();
	}
}