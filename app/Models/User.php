<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;
    protected $fillable = [
        'name', 'email', 'password','slug','phone','age','role','remember_token','deleted_by',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guard = 'user';
    public function scopeFilter($query,$request){
        if($request->filter){
            if($request->filter=='removed'){
                $query->onlyTrashed();
            }else{
                $query->where('role',$request->filter);
            }
        }
        return $query;
    }
    public static function remove($slug){
        self::where('slug',$slug)->delete();
    }
    public function images(){
        return $this->morphMany('App\Models\Image', 'imagable');
    }
    public function followers(){
        return $this->belongsTo(Follower::class,'id','followed');
    }
}
