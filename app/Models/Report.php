<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable=['to_user','reporter','report','seen'];
    public $timestamps=false;

}
