<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Report;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Support\Facades\View;
use Session;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;
use App\Models\Link;

class UserController extends Controller
{
    public function __construct(){
        $messagescount = Message::where('seen',0)->count();
        View::share('messagescount',$messagescount);
        $newads = Ad::where('seen',0)->count();
        View::share('newads',$newads);
        $reports=Report::where('seen',0)->count();
        View::share('reports',$reports);
    }
	public function index(Request $request){
        if($request->filter=="admin"){
            $users=Admin::latest()->paginate(10);
        }else{
            $users=User::filter($request)->orderBy('id','desc')->paginate(10);
        }
        return view('admin/users',compact('users'))->withFilter($request->filter??'');
    }
    public function update(Request $req,$id){
        $name=$req->input('name');
        $phone=$req->input('phone');
        $email=$req->input('email');
        $password=$req->input('password');
        $role=$req->input('role');
        $users=User::all();
        foreach ($users as $u) {
            if (array_key_exists($u->id,$password)){
                if($password[$u->id]!=null){
                    $pass=Hash::make($password[$u->id]);
                }else{
                    $pass=$u->password;
                }
                User::where('id',$u->id)->update(['name'=>$name[$u->id],'phone'=>$phone[$u->id],'email'=>$email[$u->id],'password'=>$pass,'role'=>$role[$u->id]]);
            }
        }
        session()->push('m','success');
        session()->push('m','All Users Updates Saved');
        return back();
    }

    public function destroy($slug){
        $user=User::where('slug',$slug)->first();
        if($user){
            $user->update(["deleted_by"=>Auth::guard('admin')->user()->id]);
            $user->remove($slug);
            session()->push('m','success');
            session()->push('m','User Removed');
        }else{
            $user=User::where('slug',$slug)->withTrashed()->first();
            $user->update(["deleted_by"=>null]);
            $user->restore($slug);
            session()->push('m','success');
            session()->push('m','User Restored');
        }
        return back();
    }

    public function blockUser(Request $request,UserService $userService){
        $slug=$request->slug??'';
        $userService->blockUser($slug);
        return back();
    }
}
