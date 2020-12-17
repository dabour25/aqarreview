<?php
namespace App\Services\Users;

use App\DTOs\Users\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService{
    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function get_user_by_slug(string $slug){
        return User::with(['images','followers'])->where('slug',$slug)->first();
    }

    /**
     * @param UserDTO $userDTO
     * @return bool
     */
    public function create_user(UserDTO $userDTO):bool {
        $userDTO->password=Hash::make($userDTO->password);
        User::create($userDTO->toArray());
        return true;
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function blockUser(string $slug):bool{
        $user=$this->get_user_by_slug($slug);
        if(!$user){
            session()->push('m','danger');
            session()->push('m','User Not Found');
            return false;
        }
        $user->role='blocked';
        $user->save();
        session()->push('m','success');
        session()->push('m','User Blocked Successfully');
        return true;
    }
}
