<?php
namespace App\Services\Ads;

use App\DTOs\Users\AdDataDTO;
use App\DTOs\Users\AdDTO;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdService{

    /**
     * @param int $count
     * @return mixed
     */
    public function getNewAds(int $count=3){
        $newads=Ad::where('show',1)->orderBy('id','desc')->take($count)->get();
        return $newads;
    }

    /**
     * @param string $slug
     * @param bool $show
     * @return mixed
     */
    public function getAdBySlug(string $slug,bool $show=false){
        if($show){
            $ad=Ad::where('slug',$slug)->where('show',1)->with('profile','images')->first();
            return $ad;
        }
        $ad=Ad::where('slug',$slug)->with('profile','images')->first();
        return $ad;
    }

    /**
     * @param AdDTO $adDTO
     * @return mixed
     */
    public function createAd(AdDTO $adDTO){
        $images=$adDTO->images;
        $ph=[];
        if(!empty($images)){
            if(count($images)>20){
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'images' => [trans('strings.image_count_error')],
                ]);
                throw $error;

            }
            $photosPath = public_path('/img/ads');
            foreach ($images as $k => $v) {
                $ph[$k]=Str::random(32);
                $ph[$k].='.'.$v->getClientOriginalExtension();
                $v->move($photosPath,$ph[$k]);
            }
        }

        $user=null;
        if(Auth::user()) {
            $user = Auth::user()->id;
        }
        $data=$adDTO->toArray();
        unset($data['images']);
        unset($data['_token']);
        $data["user_id"]=$user;
        $data["slug"]=Str::slug($data['title']).Str::random(3).rand(100,999);
        Ad::create($data);
        $ad=Ad::latest()->first();
        $advertise=Ad::find($ad->id);
        foreach ($ph as $p){
            $photo = new Image(['url' => $p]);
            $advertise->images()->save($photo);
        }
        session()->push('m','success');
        if(Session::has('lang'))
            session()->push('m','Advertise Sent But You must add this data to brodcast Advertise');
        else
            session()->push('m','تم إرسال إعلانك لكن عليك ملئ هذة البيانات والتأكيد لنشر إعلانك');
        return $ad;
    }

    /**
     * @param AdDataDTO $adDataDTO
     * @param string $slug
     */
    public function attachAdvertisorData(AdDataDTO $adDataDTO,string $slug):void{
        $chk=$this->getAdBySlug($slug);
        if(!empty($chk->profile)){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'redirect' => [trans('strings.This Advertise Has Profile before')],
            ]);
            throw $error;
        }
        $data=$adDataDTO->toArray();
        $data["ad_id"]=$chk->id;
        $data["email_show"]=$data['showemail'];
        Adspro::create($data);
        session()->push('m','success');
        if(Session::has('lang'))
            session()->push('m','Advertise is now fully ready, Waiting Admin Approval');
        else
            session()->push('m','إعلانك الان جاهز بالكامل , ينتظر موافقة الإدارة');
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return array
     */
    public function reviewAd(string $slug,Request $request):array{
        $ad['ad']=$this->getAdBySlug($slug);
        $ad['name']=$request["name"];
        $ad['phone']=$request["phone"];
        $ad['email']=$request["email"];
        return $ad;
    }
}
