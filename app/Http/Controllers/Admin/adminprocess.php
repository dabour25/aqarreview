<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
//DB Connect
use App\Models\User;
use App\Models\Message;
use App\Models\Ad;
use App\Models\Adspro;
use App\Models\Link;

class adminprocess extends Controller
{
	public function __construct(){
	}
	
	public function links(Request $req){
	    $phone=$req->input('phone');
		$email=$req->input('email');
		$face=$req->input('face');
		$twit=$req->input('twit');
		$inst=$req->input('inst');
		Link::where('id',1)->update(['value'=>$phone]); Link::where('id',2)->update(['value'=>$email]);
		Link::where('id',3)->update(['value'=>$face]); Link::where('id',4)->update(['value'=>$twit]);
		Link::where('id',5)->update(['value'=>$inst]);
		session()->push('m','success');
	    session()->push('m','Data Updates Saved');
		return back();
	}
    public function adsdefault(Request $req){
        $valarr=[
            'default'=>'required|max:8192|mimes:jpg,jpeg,gif,png',
        ];
        $this->validate($req,$valarr);
        $image=$req->file('default');
        $old=Link::where('id',6)->first();
        @unlink('img/ads/'.$old->value);
        $photosPath = public_path('/img/ads');
        $photoName='default';
        $photoName.='.'.$image->getClientOriginalExtension();
        $image->move($photosPath,$photoName);
        Link::where('id',6)->update(['value'=>$photoName]);
        session()->push('m','success');
        session()->push('m','Image Updated Saved');
        return back();
    }
    public function profile_default(Request $req){
        $valarr=[
            'default'=>'required|max:8192|mimes:jpg,jpeg,gif,png',
        ];
        $this->validate($req,$valarr);
        $image=$req->file('default');
        $old=Link::where('id',7)->first();
        @unlink('img/profiles/'.$old->value);
        $photosPath = public_path('/img/profiles');
        $photoName='default';
        $photoName.='.'.$image->getClientOriginalExtension();
        $image->move($photosPath,$photoName);
        Link::where('id',7)->update(['value'=>$photoName]);
        session()->push('m','success');
        session()->push('m','Image Updated Saved');
        return back();
    }
}
