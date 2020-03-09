<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Str;
use Session;
use View;
//DB Connect
use App\Models\Message;

class process extends Controller
{
	public function __construct(){
	}
	public function fastUpload(Request $request){
	    $file=$request->file('upload');
	    $path=public_path('/img/blog');
	    $name=Str::random(16);
        $name.='.'.$file->getClientOriginalExtension();
        $file->move($path,$name);
        $final_url=$request->root().'/img/blog/'.$name;
        return response()->json(['uploaded'=>1,'fileName'=>$name,'url'=>$final_url]);
    }
}