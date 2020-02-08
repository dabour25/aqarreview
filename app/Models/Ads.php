<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use SoftDeletes;
    protected $table='ads';
    protected $fillable=["title","user_id","price","description","size","general_type","type","floor","rooms","pathroom","kitchen","finish","furniture","parking","image","images","address"];

    public function updater(){
        return $this->belongsTo(Users::class,'updated_by');
    }
}
