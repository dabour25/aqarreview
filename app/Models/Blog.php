<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable=['slug','user_id','privacy','content','title'];
    public function images(){
        return $this->morphMany(Image::class, 'imagable');
    }
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable')->with('user','replies')->latest();
    }
    public function likes(){
        return $this->morphMany(Like::class, 'likable');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id')->with('images');
    }
}
