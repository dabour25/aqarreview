<?php

namespace App\RequestsWeb;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class BaseRequestForm
{
    protected $_request;
    /**
     * @var bool
     */
    private $status=true;
    /**
     * @var array
     */
    private $errors=[];

    abstract public function rules(): array;

    //abstract public function authorized(): bool;

    public function __construct(Request $request = null, $forceDie = true)
    {

//        if (!$this->authorized())
//            appSystem()->response()->unAuthorized()->json(200, true);

        if (!is_null($request)) {
            $this->_request = $request;
            $rules = $this->rules();
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                if ($forceDie) {
                    $error=$validator->errors()->toArray();
                    throw ValidationException::withMessages($error);
                }else{
                    $this->status = false;
                    $this->errors  =$validator->errors()->toArray();
                }

            }


        }
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    public function request()
    {
        return $this->_request;
    }
}