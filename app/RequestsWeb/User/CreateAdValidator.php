<?php

namespace App\RequestsWeb\User;

use App\RequestsWeb\BaseRequestForm;
use Carbon\Carbon;


class CreateAdValidator extends BaseRequestForm
{

    public function rules(): array
    {
        $type=$this->request()->input('type');
        if($type!='land'){
            return [
                'title'=>'required|max:60|min:3',
                'price'=>'required|numeric',
                'description'=>'required|max:1000',
                'size'=>'required|numeric',
                'general_type'=>'required|in:sell,rent',
                'type'=>'required',
                'floor'=>'required|numeric',
                'rooms'=>'required|numeric',
                'pathrooms'=>'required|numeric',
                'kitchens'=>'required|numeric',
                'finish'=>'required',
                'furniture'=>'required|in:yes,no',
                'parking'=>'required|in:yes,no',
                'address'=>'required|min:1|max:1000',
            ];
        }else{
            return [
                'title'=>'required|max:60|min:3',
                'price'=>'required|numeric',
                'description'=>'required|max:1000',
                'size'=>'required|numeric',
                'general_type'=>'required|in:sell,rent',
                'type'=>'required',
                'address'=>'required|max:1000'
            ];
        }
    }
}
