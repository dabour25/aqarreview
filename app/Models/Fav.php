<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    protected $table='favourites';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(Users::class,'user_id');
    }
    public function ad(){
        return $this->belongsTo(Ads::class,'ad_id');
    }
}
