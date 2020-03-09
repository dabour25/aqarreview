<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Like;
use App\Models\Comment;

class BlogsService{

    public static function getBlogs($user_id=null){
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
        }
        return [$posts,$likes,$dislikes,$commentlikes,$commentdislikes,$replieslikes,$repliesdislikes];
    }
}