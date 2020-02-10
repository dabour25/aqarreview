<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\Link;
use App\Models\Image;
use App\Models\Ad;

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
    public function store(Request $req){
        $type=$req->input('type');
        if($type!='land'){
            $valarr=[
                'title'=>'required|max:60|min:3',
                'price'=>'required|numeric',
                'description'=>'required|max:1000',
                'size'=>'required|numeric',
                'general_type'=>'required|in:sell,rent',
                'type'=>'required',
                'floor'=>'required|numeric',
                'rooms'=>'required|numeric',
                'pathrooms'=>'required|numeric',
                'kitchens'=>'required|numeric',
                'finish'=>'required',
                'furniture'=>'required|in:yes,no',
                'parking'=>'required|in:yes,no',
                'address'=>'required|min:1|max:1000'
            ];
        }else{
            $valarr=[
                'title'=>'required|max:60|min:3',
                'price'=>'required|numeric',
                'description'=>'required|max:1000',
                'size'=>'required|numeric',
                'general_type'=>'required|in:sell,rent',
                'type'=>'required',
                'address'=>'required|max:1000'
            ];
        }
        $this->validate($req,$valarr);

        $images=$req->file('images');
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

        if(Auth::user()){
            $user=Auth::user()->id;
        }else{
            $user=null;
        }
        $data=$req->except('_token','images');
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
        return redirect('/adpro/'.$ad->id);
    }
}