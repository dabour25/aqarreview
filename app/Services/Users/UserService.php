<?php
namespace App\Services\Users;

use App\DTOs\Users\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService{
    public function create_user(UserDTO $userDTO){
        $userDTO->password=Hash::make($userDTO->password);
        User::create($userDTO->toArray());
        return true;
    }
}