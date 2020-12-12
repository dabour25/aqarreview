<?php

namespace App\Http\Controllers\User;


use App\DTOs\Users\ContactUsDTO;
use App\Http\Controllers\Controller;
use App\Models\Fav;
use App\Models\Link;
use App\Models\Message;
use App\RequestsWeb\User\ContactUsValidator;
use App\Services\Ads\AdService;
use App\Services\Ads\SearchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }

    public function index(AdService $adService){
        $search=trans("strings.ALL");
        $ads=$adService->getAds();
        $page='SEARCH : '.$search;
        $pagear='بحث عن : '.$search;
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav','search'));
    }

    public function byCategory($category,AdService $adService,SearchService $searchService){
        $ads=$adService->getAdsByCategory($category,true);
        $pageName=$searchService->getCategoryName($category);
        $page=$pageName[0];
        $pagear=$pageName[1];
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }

    public function rentCategory($category,AdService $adService,SearchService $searchService){
        $ads=$adService->getTypeAdsByCategory($category,'rent',true);
        $pageName=$searchService->getCategoryName($category);
        $page=$pageName[0];
        $pagear=$pageName[1];
        if($page!="Error In URL"){
            $page.=' FOR RENT';
            $pagear.=' للإيجار';
        }
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }

    public function sellCategory($category,AdService $adService,SearchService $searchService){
        $ads=$adService->getTypeAdsByCategory($category,'sell',true);
        $pageName=$searchService->getCategoryName($category);
        $page=$pageName[0];
        $pagear=$pageName[1];
        if($page!="Error In URL"){
            $page.=' FOR SELL';
            $pagear.=' للبيع';
        }
        $fav=[];
        if(Auth::user()){
            $fav=Fav::where('user',Auth::user()->id)->get();
        }
        return view('ads',compact('page','ads','pagear','fav'));
    }
}
