<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use View;
use Auth;
use Socialite;
use Session;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Link;

class adminrouter extends Controller
{

    public function __construct(){
        $messagescount = Message::where('seen',0)->count();
        View::share('messagescount',$messagescount);
        $newads = Ad::where('seen',0)->count();
        View::share('newads',$newads);
    }
    public function index(){
      $usercount=User::count();
    	return view('admin/index',compact('usercount'));
    }

    public function messages(){
      $newmes=Message::where('seen',0)->orderBy('id','desc')->get();
      $oldmes=Message::where('seen',1)->orderBy('id','desc')->get();
      Message::where('seen',0)->update(['seen'=>1]);
      return view('admin/messages',compact('newmes','oldmes'));
     }

     public function approve(){
      $ads=Ad::where('seen',0)->orderBy('id','desc')->paginate(10);
      $oldads=Ad::where('seen',1)->where('show',0)->orderBy('id','desc')->paginate(10);
      Ad::where('seen',0)->orderBy('id','desc')->limit(10)->update(['seen'=>1]);
      return view('admin/approve',compact('ads','oldads'));
     }
    public function review($id){
         $adpro = Adspro::where('ad', $id)->first();
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

     public function adscontrol(){
      $ads=Ad::join('ads_profile','ads_profile.ad','=','ads.id')
      ->where('seen',1)->orderBy('ads.id','desc')
      ->select('ads.id as adid','ads.title','ads_profile.*')->paginate(20);
      return view('admin/adscontrol',compact('ads'));
     }

     public function links(){
      $data=Link::all();
      return view('admin/links',compact('data'));
     }
}