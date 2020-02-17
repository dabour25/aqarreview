<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use View;
use Illuminate\Support\Str;
//DB Connect
use App\Models\Link;
use App\Models\Follower;
use App\Models\Image;
use App\Models\Post;

class PostsController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }
    public function store(Request $request){
        $valarr=[
            'post'=>'required|max:1000|min:1',
            'images.*'=>'max:4096',
            'images' => 'max:5',
        ];
        $this->validate($request,$valarr);
        $images=$request->file('images');
        $photosPath = public_path('/img/posts');
        if($images) {
            foreach ($images as $k => $v) {
                $ph[$k] = Str::random(32);
                $ph[$k] .= '.' . $v->getClientOriginalExtension();
                $v->move($photosPath, $ph[$k]);
            }
        }else{
            $ph=[];
        }
        $data["content"]=$request->post;
        $data["privacy"]='all';
        $data["user_id"]=Auth::user()->id;
        $data["slug"]=Str::random(6).rand(100,999);
        $post=Post::create($data);
        foreach ($ph as $p) {
            $photo = new Image(['url' => $p]);
            $post->images()->save($photo);
        }
        return back();
    }
    public function index(){
        $page=trans('strings.community').' | '.trans('strings.posts');
        $posts=Post::with('users','images')->latest()->get();
        return view('posts',compact('page','posts'));
    }
}