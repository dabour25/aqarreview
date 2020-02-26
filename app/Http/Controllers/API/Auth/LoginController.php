<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Link;
use View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:web')->except('logout');
        $links = Link::all();
        View::share('links',$links);
        $this->middleware('guest')->except('logout');
    }
    public function showAdminLoginForm()
    {
        $page=trans('strings.login');
        return view('auth.login',compact('page'))->withKey('my-Admin925');
    }
    public function showUserLoginForm()
    {
        $page=trans('strings.login');
        return view('auth.login',compact('page'));
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admindb');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        $chkBlock=User::where('email',$request->email)->first();
        if($chkBlock&&$chkBlock->role=="blocked"){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'account' => [trans('strings.blocked_account_message')],
            ]);
            throw $error;
        }
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
}
