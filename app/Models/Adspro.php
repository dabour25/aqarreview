<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adspro extends Model
{
    protected $table='ads_profile';
    public $timestamps = false;

    protected $fillable=["ad_id","name","email","phone","email_show"];

    public function advertise(){
        return $this->belongsTo(Ad::class,'ad');
    }
}
