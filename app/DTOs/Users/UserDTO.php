<?php

namespace App\DTOs\Users;


use App\DTOs\BaseDTO;

class UserDTO extends BaseDTO
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
     * @var string $age
     */
    public $age;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var string $password
     */
    public $password;
    /**
     * @var string $role
     */
    public $role;
    /**
     * @var string $slug
     */
    public $slug;
}
