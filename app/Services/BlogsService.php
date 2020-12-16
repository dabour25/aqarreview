<?php

namespace App\Services;

use App\DTOs\Users\BlogDTO;
use App\Models\Blog;
use App\Models\Image;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogsService{

    public static function getBlogs($user_id=null):array{
        $likes=$dislikes=$commentlikes=$commentdislikes=$replieslikes=$repliesdislikes=[];
        $posts=Blog::with('users','images','likes','comments');
        if($user_id){
            $posts=$posts->where('user_id',$user_id);
        }
        $posts=$posts->latest()->take(10)->get();
        foreach ($posts as $post){
            $likes[$post->id]=0;
            $dislikes[$post->id]=0;
            foreach ($post->likes as $like){
                if($like->type==1){
                    $likes[$post->id]++;
                }elseif ($like->type==0){
                    $dislikes[$post->id]++;
                }
            }
            $commentlikes[$post->id]=[];
            $commentdislikes[$post->id]=[];
            foreach ($post->comments as $comment){
                $commentlikes[$post->id][$comment->id]=0;
                $commentdislikes[$post->id][$comment->id]=0;
                foreach ($comment->likes as $like) {
                    if($like->type==1){
                        $commentlikes[$post->id][$comment->id]++;
                    }elseif ($like->type==0){
                        $commentdislikes[$post->id][$comment->id]++;
                    }
                }
                $replieslikes[$post->id][$comment->id]=[];
                $repliesdislikes[$post->id][$comment->id]=[];
                foreach ($comment->replies as $reply){
                    $replieslikes[$post->id][$comment->id][$reply->id]=0;
                    $repliesdislikes[$post->id][$comment->id][$reply->id]=0;
                    foreach ($reply->likes as $like){
                        if($like->type==1){
                            $replieslikes[$post->id][$comment->id][$reply->id]++;
                        }elseif ($like->type==0){
                            $repliesdislikes[$post->id][$comment->id][$reply->id]++;
                        }
                    }
                }
            }
        }
        return [$posts,$likes,$dislikes,$commentlikes,$commentdislikes,$replieslikes,$repliesdislikes];
    }
    public static function getblog(string $slug):array{
        $blog=Blog::with('users','images','likes','comments')->where('slug',$slug)->first();
        $likes=0;
        $dislikes=0;
        foreach ($blog->likes as $like){
            if($like->type==1){
                $likes++;
            }elseif ($like->type==0){
                $dislikes++;
            }
        }
        $commentlikes=[];
        $commentdislikes=$replieslikes=$repliesdislikes=[];
        foreach ($blog->comments as $comment){
            $commentlikes[$comment->id]=0;
            $commentdislikes[$comment->id]=0;
            foreach ($comment->likes as $like) {
                if($like->type==1){
                    $commentlikes[$comment->id]++;
                }elseif ($like->type==0){
                    $commentdislikes[$comment->id]++;
                }
            }
            $replieslikes[$comment->id]=[];
            $repliesdislikes[$comment->id]=[];
            foreach ($comment->replies as $reply){
                $replieslikes[$comment->id][$reply->id]=0;
                $repliesdislikes[$comment->id][$reply->id]=0;
                foreach ($reply->likes as $like){
                    if($like->type==1){
                        $replieslikes[$comment->id][$reply->id]++;
                    }elseif ($like->type==0){
                        $repliesdislikes[$comment->id][$reply->id]++;
                    }
                }
            }
        }
        return [$blog,$likes,$dislikes,$commentlikes,$commentdislikes,$replieslikes,$repliesdislikes];
    }

    public function createBlog(BlogDTO $blogDTO){
        $image=$blogDTO->image;
        $photosPath = public_path('/img/blog');
        $ph = Str::random(16);
        $ph .= '.' . $image->getClientOriginalExtension();
        $image->move($photosPath, $ph);
        $data["content"]=$blogDTO->blog;
        $data["title"]=$blogDTO->title;
        $data["privacy"]='all';
        $data["user_id"]=Auth::user()->id;
        $data["slug"]=Str::random(6).rand(100,999);
        $blog=Blog::create($data);
        $photo = new Image(['url' => $ph]);
        $blog->images()->save($photo);
        return $blog;
    }
}
