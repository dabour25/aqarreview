<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use View;
use Auth;
use Socialite;
use Session;
//DB Connect
use App\Users;
use App\Messages;
use App\Ads;
use App\Adspro;
use App\Links;

class adminrouter extends Controller
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
        $messagescount = Messages::where('seen',0)->count();
        View::share('messagescount',$messagescount);
        $newads = Ads::where('seen',0)->count();
        View::share('newads',$newads);
    }

    public function index(){
      $usercount=Users::count();
    	return view('admin/index',compact('usercount'));
    }

    public function messages(){
      $newmes=Messages::where('seen',0)->orderBy('id','desc')->get();
      $oldmes=Messages::where('seen',1)->orderBy('id','desc')->get();
      Messages::where('seen',0)->update(['seen'=>1]);
      return view('admin/messages',compact('newmes','oldmes'));
     }

     public function approve(){
      $ads=Ads::where('seen',0)->orderBy('id','desc')->get();
      $oldads=Ads::where('seen',1)->where('show',0)->orderBy('id','desc')->get();
      Ads::where('seen',0)->update(['seen'=>1]);
      return view('admin/approve',compact('ads','oldads'));
     }

     public function review($id){
      $adpro=Adspro::where('ad',$id)->first();
      if(empty($adpro)){
        $error = \Illuminate\Validation\ValidationException::withMessages([
           'redirect' => ['This Advertise Still Haven\'t communication data'],
        ]);
        throw $error;
      }
      $name=$adpro->name;
      $phone=$adpro->phone;
      $email=$adpro->email;
      if($email!='')
        return redirect('/review/'.$id.'/'.$name.'/'.$phone.'/'.$email);
      else
        return redirect('/review/'.$id.'/'.$name.'/'.$phone);
     }
     public function adscontrol(){
      $ads=Ads::join('ads_profile','ads_profile.ad','=','ads.id')
      ->where('seen',1)->orderBy('ads.id','desc')
      ->select('ads.id as adid','ads.title','ads_profile.*')->paginate(20);
      return view('admin/adscontrol',compact('ads'));
     }
     public function users(){
      $users=Users::orderBy('id','desc')->paginate(10);
      return view('admin/users',compact('users'));
     }
     public function usersf($filter){
      $users=Users::where('role',$filter)->orderBy('id','desc')->paginate(10);
      return view('admin/users',compact('users','filter'));
     }
     public function links(){
      $data=Links::all();
      return view('admin/links',compact('data'));
     }
}