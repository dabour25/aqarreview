<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable=['follower','followed'];

    public static function deleteOrCreate($follower,$followed){
        $old=self::where('follower',$follower)->where('followed',$followed)->first();
        if($old){
            $old->delete();
        }else{
            self::insert(['follower'=>$follower,'followed'=>$followed]);
        }
    }
    public function followerData(){
        return $this->belongsTo(User::class,'follower');
    }
    public function followingData(){
        return $this->belongsTo(User::class,'followed');
    }
}
