<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['url','imagable_id','imagable_type'];
    public function imagable(){
        return $this->morphTo();
    }
}
