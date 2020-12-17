<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Illuminate\Support\Facades\View;
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
        $reports=Report::where('seen',0)->count();
        View::share('reports',$reports);
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

     public function links(){
      $data=Link::all();
      return view('admin/links',compact('data'));
     }
}
