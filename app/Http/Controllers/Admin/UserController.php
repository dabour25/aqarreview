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
use App\Models\Adspro;
use App\Models\Links;

class UserController extends Controller
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
	public function index(Request $request){
        $users=Users::filter($request)->orderBy('id','desc')->paginate(10);
        return view('admin/users',compact('users'))->withFilter($request->filter??'');
    }
    public function update(Request $req,$id){
        $name=$req->input('name');
        $phone=$req->input('phone');
        $email=$req->input('email');
        $password=$req->input('password');
        $role=$req->input('role');
        $users=Users::all();
        foreach ($users as $u) {
            if (array_key_exists($u->id,$password)){
                if($password[$u->id]!=null){
                    $pass=Hash::make($password[$u->id]);
                }else{
                    $pass=$u->password;
                }
                if($u->id==1){
                    $role[1]='admin';
                }
                Users::where('id',$u->id)->update(['name'=>$name[$u->id],'phone'=>$phone[$u->id],'email'=>$email[$u->id],'password'=>$pass,'role'=>$role[$u->id]]);
            }
        }
        session()->push('m','success');
        session()->push('m','All Users Updates Saved');
        return back();
    }

    public function destroy($id){
        Users::remove($id);
        return back();
    }
}