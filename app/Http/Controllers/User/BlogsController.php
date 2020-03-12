<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Reply;
use App\Models\Report;
use App\RequestForms\Social\CommentValidator;
use App\Services\BlogsService;
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

class BlogsController extends Controller
{
    public function __construct(){
        $links = Link::all();
        $this->middleware('auth',['except' => ['index']]);
        View::share('links',$links);
    }
    public function store(Request $request){
        $valarr=[
            'blog'=>'required|min:1',
            'image'=>'required|max:8192',
            'title'=>'required|min:5|max:191'
        ];
        $this->validate($request,$valarr);
        $image=$request->file('image');
        $photosPath = public_path('/img/blog');

        $ph = Str::random(16);
        $ph .= '.' . $image->getClientOriginalExtension();
        $image->move($photosPath, $ph);
        $data["content"]=$request->blog;
        $data["title"]=$request->title;
        $data["privacy"]='all';
        $data["user_id"]=Auth::user()->id;
        $data["slug"]=Str::random(6).rand(100,999);
        $blog=Blog::create($data);
        $photo = new Image(['url' => $ph]);
        $blog->images()->save($photo);
        return back();
    }
    public function index(){
        $page=trans('strings.community').' | '.trans('strings.blogs');
        $result=BlogsService::getBlogs();
        $blogs=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('blogs',compact('page','blogs','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
    }
    public function show($slug){
        $page=trans('strings.community').' | '.trans('strings.blogs');
        $result=BlogsService::getBlog($slug);
        $blog=$result[0];
        $likes=$result[1];
        $dislikes=$result[2];
        $commentlikes=$result[3];
        $commentdislikes=$result[4];
        $replieslikes=$result[5];
        $repliesdislikes=$result[6];
        return view('blog',compact('page','blog','likes','dislikes','commentlikes','commentdislikes','replieslikes','repliesdislikes'));
    }
    public function like($slug){
        $blog=Blog::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        $pure=Blog::where('slug',$slug)->first();
        SocialService::like_maker($blog,Auth::user()->id,$pure->id,Blog::class,1);
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
        $blog=Blog::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('slug',$slug)->first();
        $pure=Blog::where('slug',$slug)->first();
        SocialService::like_maker($blog,Auth::user()->id,$pure->id,Blog::class,0);
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
        $blog=Blog::where('slug',$slug)->first();
        if(!$blog){
            return back();
        }
        SocialService::comment_maker($request->request(),Auth::user()->id,$blog);
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