<?php
namespace App\Services\Ads;

use App\DTOs\Users\UserDTO;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdService{

    /**
     * @param int $count
     * @return mixed
     */
    public function getNewAds(int $count=3){
        $newads=Ad::where('show',1)->orderBy('id','desc')->take($count)->get();
        return $newads;
    }
}
