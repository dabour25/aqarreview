<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps=false;
    protected $fillable=['user_id','type','likable_id','likable_type'];
    public function likable(){
        return $this->morphTo();
    }
}
