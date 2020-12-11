<?php

namespace App\DTOs\Users;


use App\DTOs\BaseDTO;

class AdDataDTO extends BaseDTO
{
    /**
     * @var string $name
     */
    public $name;
    /**
     * @var string $phone
     */
    public $phone;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var boolean $showmail
     */
    public $showemail;
}
