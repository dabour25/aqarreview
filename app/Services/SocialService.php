<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

class SocialService{


    public static function like_maker($targetData,$user_id,$slug,$target,$type=1){
        $data= $target::where('slug',$slug)->first();
        if($type==1){
            if($targetData){
                if($targetData->likes[0]->type==0){
                    Like::where('id',$targetData->likes[0]->id)->update(['type'=>true]);
                }else{
                    Like::where('id',$targetData->likes[0]->id)->delete();
                }
            }else{
                $like=new Like(['user_id'=>$user_id,'type'=>true]);
                $data->likes()->save($like);
            }
        }else{
            if($targetData){
                if($targetData->likes[0]->type==1){
                    Like::where('id',$targetData->likes[0]->id)->update(['type'=>false]);
                }else{
                    Like::where('id',$targetData->likes[0]->id)->delete();
                }
            }else{
                $like=new Like(['user_id'=>$user_id,'type'=>false]);
                $data->likes()->save($like);
            }
        }
    }

    public static function comment_maker($data,$user,$target){
        $comment=new Comment(['comment'=>$data->comment,'user_id'=>$user]);
        $target->comments()->save($comment);
    }

    public static function getPosts(){
        $likes=$dislikes=[];
        $posts=Post::with('users','images','likes','comments')->latest()->take(10)->get();
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
        }
        return [$posts,$likes,$dislikes];
    }
}