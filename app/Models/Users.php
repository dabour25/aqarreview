<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;
    protected $table='users';

    public function scopeFilter($query,$request){
        if($request->filter){
            $query->where('role',$request->filter);
        }
        return $query;
    }
    public static function remove($id){
        self::where('id',$id)->delete();
    }
}
