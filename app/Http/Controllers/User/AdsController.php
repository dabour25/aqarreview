<?php

namespace App\Http\Controllers\User;

use App\DTOs\Users\AdDataDTO;
use App\DTOs\Users\AdDTO;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Fav;
use App\Models\Link;
use App\RequestsWeb\User\AdDataValidator;
use App\RequestsWeb\User\CreateAdValidator;
use App\Services\Ads\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class AdsController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }
    public function create(){
        $page=trans('strings.add_advertise');
        return view('addnew',compact('page'));
    }
    public function store(CreateAdValidator $adValidator,AdService $adService){
        $request=$adValidator->request()->all();
        $request['images']=$request['images']??[];
        $adDTO=AdDTO::fromArray($request);
        $ad=$adService->createAd($adDTO);
        return redirect('/adpro/'.$ad->slug);
    }

    public function show($slug,AdService $adService){
        $ad['ad']=$adService->getAdBySlug($slug,true);
        if(empty($ad)){
            return redirect('/');
        }
        $data=$ad['ad']->profile;
        if(empty($data)){
            return redirect('/');
        }
        $ad['name']=$data->name;$ad['phone']=$data->phone;
        if($data->email_show==1){
            $ad['email']=$data->email;
        }else{
            $ad['email']='';
        }
        $page='ADVERTISE:'.$ad['ad']->title;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user_id',Auth::user()->id)->where('ad_id',$ad['ad']->id)->first();
        }
        return view('single',compact('page','ad','fav'));
    }

    public function adpro($slug){
        $page=trans('strings.ADVERTISE_DATA');
        return view('adpro',compact('page','slug'));
    }

    public function adproProcess($slug,AdDataValidator $adDataValidator,AdService $adService){
        $request=$adDataValidator->request()->all();
        if(isset($request['showemail'])){
            $request['showemail']=1;
        }else{
            $request['showemail']=0;
        }
        $adDataDto=AdDataDTO::fromArray($request);
        $adService->attachAdvertisorData($adDataDto,$slug);
        return redirect('/ads/create');
    }

    public function review($slug,Request $request,AdService $adService){
        $page=trans('strings.REVIEW ADVERTISE');
        $ad=$adService->reviewAd($slug,$request);
        if(empty($ad['ad'])){
            return redirect('/');
        }
        return view('single',compact('page','ad'));
    }
}
