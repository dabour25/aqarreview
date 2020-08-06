<?php

namespace App\DTOs\Users;


use App\DTOs\BaseDTO;

class ContactUsDTO extends BaseDTO
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $subject
     */
    public $subject;
    /**
     * @var string $message
     */
    public $message;
}
