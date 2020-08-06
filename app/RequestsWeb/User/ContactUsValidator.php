<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;


class ContactUsValidator extends BaseRequestForm
{

    public function rules(): array
    {

        return [
            'name'=>'required|max:50|min:5',
            'email'=>'required|max:50|min:5|email',
            'subject'=>'required|max:80|min:5',
            'message'=>'required|max:1000',
        ];
    }
}
