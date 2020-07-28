<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;

class LoginUserValidator extends BaseRequestForm{

    public function rules(): array
    {
        return [
            'email'   => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}