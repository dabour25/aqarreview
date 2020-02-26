<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Reply;
use App\Models\Report;
use App\RequestForms\Social\CommentValidator;
use App\Services\SocialService;
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
        $result=Post::latest()->paginate(10);
        return response(['page'=>$page,'posts'=>$result])->json();
    }
    public function like($slug){
        $post=Post::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        $pure=Post::where('slug',$slug)->first();
        SocialService::like_maker($post,Auth::user()->id,$pure->id,Post::class,1);
        return back();
    }
    public function likeComment($id){
        $commet=Comment::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('id',$id)->first();
        SocialService::like_maker($commet,Auth::user()->id,$id,Comment::class,1);
        return back();
    }
    public function likeReply($id){
        $reply=Reply::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('id',$id)->first();
        SocialService::like_maker($reply,Auth::user()->id,$id,Reply::class,1);
        return back();
    }
    public function dislike($slug){
        $post=Post::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        $pure=Post::where('slug',$slug)->first();
        SocialService::like_maker($post,Auth::user()->id,$pure->id,Post::class,0);
        return back();
    }
    public function dislikeComment($id){
        $post=Comment::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('id',$id)->first();
        SocialService::like_maker($post,Auth::user()->id,$id,Comment::class,0);
        return back();
    }
    public function dislikeReply($id){
        $reply=Reply::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('id',$id)->first();
        SocialService::like_maker($reply,Auth::user()->id,$id,Reply::class,0);
        return back();
    }
    public function comment(CommentValidator $request,$slug){
        $post=Post::where('slug',$slug)->first();
        if(!$post){
            return back();
        }
        SocialService::comment_maker($request->request(),Auth::user()->id,$post);
        return back();
    }
    public function reply(Request $request,$id){
        $comment=Comment::findOrFail($id);
        $valarr=[
            'reply'=>'required|max:500|min:1',
        ];
        $this->validate($request,$valarr);
        $reply=new Reply(['reply'=>$request->reply,'user_id'=>Auth::user()->id]);
        $comment->replies()->save($reply);
        return back();
    }
}