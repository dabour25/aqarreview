<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\Users;
use App\Models\Messages;
use App\Models\Ads;

class AdsController extends Controller
{
    public function __construct(){
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

    public function destroy($id){
        Users::remove($id);
        return back();
    }
}