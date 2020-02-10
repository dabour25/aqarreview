<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable=['slug','user_id','privacy','content'];
    public function images(){
        return $this->morphMany('App\Models\Image', 'imagable');
    }
    public function comments(){
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    public function likes(){
        return $this->morphMany('App\Models\Like', 'likable');
    }
}
