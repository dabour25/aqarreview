<?php

namespace App\RequestForms;

use Illuminate\Http\Request;
use Validator;

/**
 * Created by PhpStorm.
 * User: jp
 * Date: 4/10/19
 * Time: 3:00 PM
 */
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
                    $error = \Illuminate\Validation\ValidationException::withMessages($validator->errors()->toArray());
                    throw $error;
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