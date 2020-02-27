<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Post;
use App\Models\Report;
use App\RequestForms\User\CreateUserValidator;
use App\RequestForms\User\UpdateUserValidator;
use App\Services\SocialService;
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
        $result=SocialService::getPosts($user->id);
        $posts=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('profile',compact('page','user','isFollow','followers','posts','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
    }
    public function globalProfile($slug){
        $user=User::where('slug',$slug)->withCount('followers')->first();
        if(!$user){
            return redirect('/');
        }
        $page=$user->name." PROFILE";
        $isFollow=Follower::where('follower',Auth::user()->id??'')->where('followed',$user->id)->first();
        $result=SocialService::getPosts($user->id);
        $posts=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('profile',compact('page','user','isFollow','posts','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
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
    public function index(){
        if(!Auth::user()){
            $page=trans('strings.register');
            return view('reg',compact('page'));
        }else{
            return redirect('/');
        }
    }
    public function create(CreateUserValidator $req){
        $data=$req->request()->except('_token','password_confirmation');
        $data['slug']=Str::slug($data["name"]).'-'.Str::random(4).rand(10,99);
        $data['password']=Hash::make($data["password"]);
        User::create($data);
        session()->push('m','success');
        session()->push('m',trans('strings.success_register'));
        return redirect('/log');
    }
    public function update(UpdateUserValidator $req,$slug){
        $data=$req->request()->except('_token','_method','password_confirmation');
        $user=User::where('slug',$slug);
        if($data['old_password']){
            if(!Hash::check($data['old_password'],$user->first()->password)){
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'old_password' => ['Wrong old password'],
                ]);
                throw $error;
            }
            $data['password']=Hash::make($data["password"]);
        }else{
            $data['password']=$user->first()->password;
        }
        unset($data['old_password']);
        $user->update($data);
        session()->push('m','success');
        session()->push('m',trans('strings.success_update'));
        return back();
    }
}