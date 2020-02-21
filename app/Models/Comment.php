<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['user_id','comment','commentable_id','commentable_type'];
    public function commentable(){
        return $this->morphTo();
    }
    public function images(){
        return $this->morphMany('App\Models\Image', 'imagable');
    }
    public function replies(){
        return $this->morphMany('App\Models\Reply', 'repliable');
    }
    public function likes(){
        return $this->morphMany('App\Models\Like', 'likable');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
