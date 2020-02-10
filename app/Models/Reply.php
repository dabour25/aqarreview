<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table="replies";
    protected $fillable=['user_id','reply','repliable_id','repliable_type'];
    public function images(){
        return $this->morphMany('App\Models\Image', 'imagable');
    }
    public function repliable(){
        return $this->morphTo();
    }
    public function likes(){
        return $this->morphMany('App\Models\Like', 'likable');
    }
}
