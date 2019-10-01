<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Messages;
use App\Users;
use App\Ads;
use App\Adspro;
use App\Fav;

class process extends Controller
{
	public function __construct(){
	}
	public function sendmes(Request $req){
		$valarr=[
	       'name'=>'required|max:50|min:5',
	       'email'=>'required|max:50|min:5|email',
	       'subject'=>'required|max:80|min:5',
	       'message'=>'required|max:1000',
	    ];
	    $this->validate($req,$valarr);
	    $name=$req->input('name');
		$email=$req->input('email');
		$subject=$req->input('subject');
		$message=$req->input('message');
		Messages::insert(['name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message]);
		session()->push('m','success');
	    session()->push('m','Message Sent To Admin Successfully');
		return back();
	}
	public function reg(Request $req){
  		$valarr=[
	       'name'=>'required|max:50|min:3',
	       'phone'=>'max:30',
	       'email'=>'required|max:50|min:5|email|unique:users,email',
	       'password'=>'required|max:60|min:8|regex:/[A-z]*[0-9]+[A-z]*/|confirmed',
	       'role'=>'required'
	    ];
	    $this->validate($req,$valarr);
	    $name=$req->input('name');
	    $phone=$req->input('phone');
		$email=$req->input('email');
		$password=Hash::make($req->input('password'));
		$role=$req->input('role');
		if($role=='admin'){
			$role='user';
		}
		Users::insert(['name'=>$name,'phone'=>$phone,'email'=>$email,'password'=>$password,'role'=>$role]);	
		session()->push('m','success');
		if(Session::has('lang'))
	    	session()->push('m','Registered Successfully , you can login now');
	    else
	    	session()->push('m','تم التسجيل بنجاح يمكنك تسجيل دخول الان');
		return redirect('/log');
	  }
	  public function addnew(Request $req){
	  	$type=$req->input('type');
	  	if($type!=3){
			$valarr=[
		       'title'=>'required|max:60|min:3',
		       'price'=>'required|numeric',
		       'desc'=>'required|max:1000',
		       'area'=>'required|numeric',
		       'gentype'=>'required',
		       'type'=>'required',
		       'floor'=>'required|numeric',
		       'rooms'=>'required|numeric',
		       'pathroom'=>'required|numeric',
		       'kitchens'=>'required|numeric',
		       'finish'=>'required|numeric',
		       'furniture'=>'required|numeric',
		       'parking'=>'required|numeric',
		       'address'=>'required|min:1|max:1000'
		    ];
		}else{
			$valarr=[
		       'title'=>'required|max:60|min:3',
		       'price'=>'required|numeric',
		       'desc'=>'required|max:1000',
		       'area'=>'required|numeric',
		       'gentype'=>'required',
		       'type'=>'required',
		       'address'=>'required|max:1000'
		    ];
		}
	    $this->validate($req,$valarr);
	    $title=$req->input('title');
		$price=$req->input('price');
		$desc=$req->input('desc');
		$area=$req->input('area');
		$gentype=$req->input('gentype');
		
		$floor=$req->input('floor');
		$rooms=$req->input('rooms');
		$pathroom=$req->input('pathroom');
		$kitchens=$req->input('kitchens');
		$finish=$req->input('finish');
		$furniture=$req->input('furniture');
		$parking=$req->input('parking');
		$images=$req->file('images');
		$address=$req->input('address');
		if(!empty($images)){
			if(count($images)>20){
				if(Session::has('lang')){
					$error = \Illuminate\Validation\ValidationException::withMessages([
					   'images' => ['Images Count Must Be Less than 20'],
					]);
					throw $error;
				}else{
					$error = \Illuminate\Validation\ValidationException::withMessages([
					   'images' => ['عدد الصور لا يجب ان يتعدى 20'],
					]);
					throw $error;
				}
				
			}
		}else{
			$photoName='';
		}
	    if(!empty($images)){
	    	$photosPath = public_path('/img/ads');
	        foreach ($images as $k => $v) {
	        	if($k==0){
			    	$photoName=str_random(32);
			        $photoName.='.'.$v->getClientOriginalExtension();
			        $v->move($photosPath,$photoName);
	        	}else{
		        	$ph[$k-1]=str_random(32);
			        $ph[$k-1].='.'.$v->getClientOriginalExtension();
			        $v->move($photosPath,$ph[$k-1]);
			    }
	        }
	        if(count($images)>1){
	        	$phs=implode('|', $ph);
	        }else{
	        	$phs='';
	        }
	    }else{
	    	$phs='';
	    }
        if(Auth::user()){
        	$user=Auth::user()->id;
        }else{
        	$user=0;
        }
		Ads::insert(['title'=>$title,'price'=>$price,
			'description'=>$desc,'size'=>$area,
			'gen_type'=>$gentype,'type'=>$type,
			'floor'=>$floor,'rooms'=>$rooms,
			'pathroom'=>$pathroom,'kitchen'=>$kitchens,
			'finish'=>$finish,'furniture'=>$furniture,
			'parking'=>$parking,'address'=>$address,
			'image'=>$photoName,'images'=>$phs,
			'user'=>$user
		]);
		$ad=Ads::orderBy('id','desc')->first();
		session()->push('m','success');
		if(Session::has('lang'))
	    	session()->push('m','Advertise Sent But You must add this data to brodcast Advertise');
	    else
	    	session()->push('m','تم إرسال إعلانك لكن عليك ملئ هذة البيانات والتأكيد لنشر إعلانك');
		return redirect('/adpro/'.$ad->id);
	}
	public function adpro($id,Request $req){
		$chk=Adspro::where('ad',$id)->first();
		if(!empty($chk)){
			$error = \Illuminate\Validation\ValidationException::withMessages([
			   'redirect' => ['This Advertise Has Profile before'],
			]);
			throw $error;
		}
  		$valarr=[
	       'name'=>'required|max:50|min:3',
	       'phone'=>'required|max:30|min:10',
	    ];
	    $this->validate($req,$valarr);
	    $name=$req->input('name');
	    $phone=$req->input('phone');
		$email=$req->input('email');
		$showemail=$req->input('showemail');
		$show=0;
		if($showemail){
			$show=1;
			$valarr=[
		       'email'=>'required|max:50|min:5|email',
		    ];
		    $this->validate($req,$valarr);
		}
		Adspro::insert(['name'=>$name,'phone'=>$phone,'email'=>$email,'email_show'=>$show,'ad'=>$id]);	
		session()->push('m','success');
		if(Session::has('lang'))
	    	session()->push('m','Advertise is now fully ready, Waiting Admin Approval');
	    else
	    	session()->push('m','إعلانك الان جاهز بالكامل , ينتظر موافقة المشرف');
		return redirect('/addnew');
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
      	$ad=Ads::where('id',$id)->where('user',Auth::user()->id)->first();
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
      	Ads::where('id',$id)->delete();
      	session()->push('m','success');
	    session()->push('m','Advertise Removed!');
  		return redirect('/search');
    }
    public function fav($id){
		if(!Auth::user()){
			return response()->json(array('msg'=> 'Error : You Must Login first','type'=>0), 200);
		}
		$chk=Fav::where('user',Auth::user()->id)->where('ad',$id)->first();
		if(empty($chk)){
			Fav::insert(['user'=>Auth::user()->id,'ad'=>$id]);
			return response()->json(array('msg'=> 'Added To Favourites','type'=>1), 200);
		}else{
			Fav::where('id',$chk->id)->delete();
			return response()->json(array('msg'=> 'Removed From Favourites','type'=>2), 200);
		}	
	}
}