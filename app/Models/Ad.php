<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use SoftDeletes;
    protected $fillable=["title","user_id","price","description","size","general_type","type","floor","rooms","pathroom","kitchen","finish","furniture","parking","image","images","address","slug"];

    public function updater(){
        return $this->belongsTo(Admin::class,'updated_by');
    }
}
