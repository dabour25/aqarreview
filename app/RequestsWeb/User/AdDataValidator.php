<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;
use Carbon\Carbon;


class AdDataValidator extends BaseRequestForm
{

    public function rules(): array
    {
        return [
            'name'=>'required|max:60|min:3',
            'phone'=>'required|max:30|min:11',
            'email'=>'required|max:50|min:5|email',
        ];

    }
}
