<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\Link;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }
    public function profile(){
        if(!Auth::user()){
            return redirect('/');
        }elseif(Auth::user()->role=='admin'){
            return redirect('/admindb');
        }
        $page=Auth::user()->name." PROFILE";
        $user=Auth::user();
        return view('profile',compact('page','user'));
    }
    public function globalProfile($slug){
        $page=Auth::user()->name." PROFILE";
        $user=User::where('slug',$slug)->first();
        $isFollow=Follower::where('follower',Auth::user()->id??'')->where('followed',$user->id)->first();
        if(!$user){
            return redirect('/');
        }
        return view('profile',compact('page','user','isFollow'));
    }
    public function follow($slug){
        if(!Auth::user()){
            return back();
        }
        $follower=Auth::user()->id;
        $followed=User::where('slug',$slug)->first();
        if(!$followed){
            return back();
        }else{
            if($follower==$followed->id){
                return back();
            }
            $followed=$followed->id;
        }
        Follower::deleteOrCreate($follower,$followed);
        return back();
    }
}