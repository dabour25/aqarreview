<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;
use Carbon\Carbon;


class CreateBlogValidator extends BaseRequestForm
{

    public function rules(): array
    {

        return [
            'blog'=>'required|min:1',
            'image'=>'required|max:8192',
            'title'=>'required|min:5|max:191',
        ];
    }
}
