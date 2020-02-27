<?php

namespace App\RequestForms\User;

use App\RequestForms\BaseRequestForm;


class CreateUserValidator extends BaseRequestForm
{

    public function rules(): array
    {

        return [
            'name'=>'required|max:50|min:3',
            'phone'=>'max:30',
            'age'=>'required|before:'.Carbon::now(),
            'email'=>'required|max:50|min:5|email|unique:users,email',
            'password'=>'required|max:60|min:8|regex:/[A-z]*[0-9]+[A-z]*/|confirmed',
            'role'=>'required'
        ];
    }
}