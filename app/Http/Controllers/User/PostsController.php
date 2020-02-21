<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
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
        $this->middleware('auth',['except' => ['index']]);
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
        $posts=Post::with('users','images','likes','comments')->latest()->take(10)->get();
        return view('posts',compact('page','posts'));
    }
    public function like($slug){
        $post=Post::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        if($post){
            if($post->likes[0]->type==0){
                Like::where('id',$post->likes[0]->id)->update(['type'=>true]);
            }else{
                Like::where('id',$post->likes[0]->id)->delete();
            }
        }else{
            $post=Post::where('slug',$slug)->first();
            $like=new Like(['user_id'=>Auth::user()->id,'type'=>true]);
            $post->likes()->save($like);
        }
        return back();
    }
    public function dislike($slug){
        $post=Post::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        if($post){
            if($post->likes[0]->type==1){
                Like::where('id',$post->likes[0]->id)->update(['type'=>false]);
            }else{
                Like::where('id',$post->likes[0]->id)->delete();
            }
        }else{
            $post=Post::where('slug',$slug)->first();
            $like=new Like(['user_id'=>Auth::user()->id,'type'=>false]);
            $post->likes()->save($like);
        }
        return back();
    }
    public function comment(Request $request,$slug){
        $post=Post::where('slug',$slug)->first();
        if(!$post){
            return back();
        }
        $valarr=[
            'comment'=>'required|max:500|min:1',
        ];
        $this->validate($request,$valarr);
        $comment=new Comment(['comment'=>$request->comment,'user_id'=>Auth::user()->id]);
        $post->comments()->save($comment);
        return back();
    }
}