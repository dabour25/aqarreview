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

    public function destroy($id){
        User::remove($id);
        return back();
    }
}