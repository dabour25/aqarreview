<?php

namespace App\RequestForms\User;

use App\RequestForms\BaseRequestForm;
use Carbon\Carbon;


class UpdateUserValidator extends BaseRequestForm
{

    public function rules(): array
    {
        return [
            'name'=>'required|max:50|min:3',
            'phone'=>'max:30',
            'age'=>'required|before:'.Carbon::now(),
            'password'=>'required_with:old_password|max:60|nullable|min:8|regex:/[A-z]*[0-9]+[A-z]*/|confirmed',
            'role'=>'required',
        ];
    }
}