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
	public function sendmes(Request $req){
		$valarr=[
	       'name'=>'required|max:50|min:5',
	       'email'=>'required|max:50|min:5|email',
	       'subject'=>'required|max:80|min:5',
	       'message'=>'required|max:1000',
	    ];
	    $this->validate($req,$valarr);
		Message::create($req->all());
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
	    $data=$req->except('_token','password_confirmation');
	    $data['slug']=Str::slug($data["name"]).'-'.Str::random(4).rand(10,99);
	    $data['password']=Hash::make($data["password"]);
		User::create($data);
		session()->push('m','success');
		if(Session::has('lang'))
	    	session()->push('m','Registered Successfully , you can login now');
	    else
	    	session()->push('m','تم التسجيل بنجاح يمكنك تسجيل دخول الان');
		return redirect('/log');
	  }
	  public function addnew(Request $req){
	  	$type=$req->input('type');
	  	if($type!='land'){
			$valarr=[
		       'title'=>'required|max:60|min:3',
		       'price'=>'required|numeric',
		       'description'=>'required|max:1000',
		       'size'=>'required|numeric',
		       'general_type'=>'required|in:sell,rent',
		       'type'=>'required',
		       'floor'=>'required|numeric',
		       'rooms'=>'required|numeric',
		       'pathroom'=>'required|numeric',
		       'kitchens'=>'required|numeric',
		       'finish'=>'required',
		       'furniture'=>'required|in:yes,no',
		       'parking'=>'required|in:yes,no',
		       'address'=>'required|min:1|max:1000'
		    ];
		}else{
			$valarr=[
		       'title'=>'required|max:60|min:3',
		       'price'=>'required|numeric',
		       'description'=>'required|max:1000',
		       'size'=>'required|numeric',
		       'general_type'=>'required|in:sell,rent',
		       'type'=>'required',
		       'address'=>'required|max:1000'
		    ];
		}
	    $this->validate($req,$valarr);

		$images=$req->file('images');

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
        $data=$req->except('_token');
		$data["user_id"]=$user;
		$data["image"]=$photoName;
		$data["images"]=$phs;
		Ad::create($data);
		$ad=Ad::latest()->first();
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
		$showemail=$req->input('showemail');
		if($showemail){
			$valarr=[
		       'email'=>'required|max:50|min:5|email',
		    ];
		    $this->validate($req,$valarr);
		}
		$data=$req->except("_token");
		$data["ad"]=$id;
		Adspro::create($data);
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