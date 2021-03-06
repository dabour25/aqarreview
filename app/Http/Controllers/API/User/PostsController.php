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
use Validator;
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
    public function likeComment(Request $request){
        $commet=Comment::whereHas('likes', function (Builder $query)use($request) {
            $query->where('user_id', $request->user_id);
        })->where('id',$request->id)->first();
        $response=SocialService::like_maker($commet,$request->user_id,$request->id,Comment::class,1);
        return response()->json(['liked'=>$response],200);
    }
    public function likeReply(Request $request){
        $reply=Reply::whereHas('likes', function (Builder $query)use($request) {
            $query->where('user_id', $request->user_id);
        })->where('id',$request->id)->first();
        SocialService::like_maker($reply,$request->user_id,$request->id,Reply::class,1);
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
    public function dislikeComment(Request $request){
        $post=Comment::whereHas('likes', function (Builder $query)use($request) {
            $query->where('user_id', $request->user_id);
        })->where('id',$request->id)->first();
        $response=SocialService::like_maker($post,$request->user_id,$request->id,Comment::class,0);
        return response()->json(['liked'=>$response],200);
    }
    public function dislikeReply(Request $request){
        $reply=Reply::whereHas('likes', function (Builder $query)use($request) {
            $query->where('user_id', $request->user_id);
        })->where('id',$request->id)->first();
        SocialService::like_maker($reply,$request->user_id,$request->id,Reply::class,0);
        return back();
    }
    public function commentBlog(Request $request){
        $valarr=[
            'comment'=>'required|max:500|min:1',
        ];
        $validator = Validator::make($request->all(), $valarr);
        if ($validator->fails()) {
            $error=$validator->errors()->toArray();
            return response()->json($error,406);

        }
        $post=Post::where('slug',$request->slug)->first();
        if(!$post){
            return response()->json(['comment'=>'Blog Not Found'],406);
        }
        SocialService::comment_maker($request->request(),$request->user_id,$post);
        return response()->json([$request->comment]);
    }
    public function reply(Request $request){
        $comment=Comment::findOrFail($request->id);
        $valarr=[
            'reply'=>'required|max:500|min:1',
        ];
        $this->validate($request,$valarr);
        $reply=new Reply(['reply'=>$request->reply,'user_id'=>$request->user_id]);
        $comment->replies()->save($reply);
        return response()->json([$request->reply]);
    }
}