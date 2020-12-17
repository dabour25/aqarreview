<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;
use Carbon\Carbon;


class ReportValidator extends BaseRequestForm
{

    public function rules(): array
    {

        return [
            'report'=>'required|max:1000|min:2',
        ];
    }
}
