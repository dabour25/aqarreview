<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Report;
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
        $followers=Follower::where('followed',$user->id)->get();
        $isFollow=false;
        return view('profile',compact('page','user','isFollow','followers'));
    }
    public function globalProfile($slug){
        $user=User::where('slug',$slug)->withCount('followers')->first();
        $page=$user->name." PROFILE";
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
    public function reportShow($slug){
        $page=trans('strings.report');
        return view('report',compact('page','slug'));
    }
    public function report(Request $request,$slug){
        $valarr=[
            'report'=>'required|max:1000|min:2',
        ];
        $this->validate($request,$valarr);
        $toUser=User::where('slug',$slug)->first()->id;
        if(!$toUser){
            return back();
        }
        $fromUser=Auth::user()->id;
        if($toUser==$fromUser){
            return back();
        }
        Report::create(['report'=>$request->report,'to_user'=>$toUser,'reporter'=>$fromUser]);
        session()->push('m','success');
        session()->push('m',trans('strings.report_success'));
        return back();
    }
}