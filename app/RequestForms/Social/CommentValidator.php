<?php

namespace App\RequestForms\Social;

use App\RequestForms\BaseRequestForm;


class CommentValidator extends BaseRequestForm
{

    public function rules(): array
    {

        return [
            'comment'=>'required|max:500|min:1',
        ];
    }
}