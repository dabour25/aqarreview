<?php

namespace App\Http\Controllers\User;

use App\DTOs\Users\UserDTO;
use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Image;
use App\Models\Post;
use App\Models\Report;
use App\RequestsWeb\User\CreateUserValidator;
use App\RequestForms\User\UpdateUserValidator;
use App\Services\SocialService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Str;
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
    public function index(){
        if(!Auth::user()){
            $page=trans('strings.register');
            return view('reg',compact('page'));
        }else{
            return redirect('/');
        }
    }
    public function profile(){
        if(!Auth::user()){
            return redirect('/');
        }elseif(Auth::user()->role=='admin'){
            return redirect('/admindb');
        }
        $page=Auth::user()->name.' '.trans('strings.profile');
        $user=User::where('id',Auth::user()->id)->with('images')->withCount('followers')->first();
        $followers=Follower::with('followerData')->where('followed',$user->id)->get();
        $following=Follower::with('followingData')->where('follower',$user->id)->get();
        $isFollow=false;
        $result=SocialService::getPosts($user->id);
        $posts=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('profile',compact('page','user','isFollow','followers','following','posts','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
    }
    public function globalProfile($slug){
        $user=User::where('slug',$slug)->withCount('followers')->first();
        if(!$user){
            return redirect('/');
        }
        $page=$user->name.' '.trans('strings.profile');
        $isFollow=Follower::where('follower',Auth::user()->id??'')->where('followed',$user->id)->first();
        $followers=Follower::with('followerData')->where('followed',$user->id)->get();
        $following=Follower::with('followingData')->where('follower',$user->id)->get();
        $result=SocialService::getPosts($user->id);
        $posts=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('profile',compact('page','user','isFollow','followers','following','posts','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
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
    public function store(CreateUserValidator $req,UserService $userService){

        $data=$req->request()->except('_token','password_confirmation');
        $data['slug']=Str::slug($data["name"]).'-'.Str::random(4).rand(10,99);
        $userDTO=UserDTO::fromArray($data);
        $response=$userService->create_user($userDTO);
        if($response){
            session()->push('m','success');
            session()->push('m',trans('strings.success_register'));
            return redirect('/log');
        }
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
    public function changeImage(Request $request){
        $image=$request->file('profile');
        $photosPath = public_path('/img/profiles');
        if($image) {
            $ph = Str::random(32);
            $ph .= '.' . $image->getClientOriginalExtension();
            $image->move($photosPath, $ph);
            $user=User::find(Auth::user()->id);
            $image = new Image(['url' => $ph]);
            $user->images()->save($image);
        }
        return back();
    }
}
