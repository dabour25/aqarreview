<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

class SocialService{


    public static function like_maker($targetData,$user_id,$id,$target,$type=1):bool{
        $response=false;
        $data= $target::where('id',$id)->first();
        if($type==1){
            if($targetData){
                if($targetData->likes[0]->type==0){
                    Like::where('id',$targetData->likes[0]->id)->update(['type'=>true]);
                    $response=true;
                }else{
                    Like::where('id',$targetData->likes[0]->id)->delete();
                }
            }else{
                $like=new Like(['user_id'=>$user_id,'type'=>true]);
                $data->likes()->save($like);
                $response=true;
            }
        }else{
            if($targetData){
                if($targetData->likes[0]->type==1){
                    Like::where('id',$targetData->likes[0]->id)->update(['type'=>false]);
                    $response=true;
                }else{
                    Like::where('id',$targetData->likes[0]->id)->delete();
                }
            }else{
                $like=new Like(['user_id'=>$user_id,'type'=>false]);
                $data->likes()->save($like);
                $response=true;
            }
        }
        return $response;
    }

    public static function comment_maker($data,$user,$target){
        $comment=new Comment(['comment'=>$data->comment,'user_id'=>$user]);
        $target->comments()->save($comment);
    }

    public static function getPosts($user_id=null){
        $likes=$dislikes=$commentlikes=$commentdislikes=$replieslikes=$repliesdislikes=[];
        $posts=Post::with('users','images','likes','comments');
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