<?php

namespace App\DTOs\Users;


use App\DTOs\BaseDTO;

class BlogDTO extends BaseDTO
{
    /**
     * @var array $name
     */
    public $image;

    /**
     * @var string $title
     */
    public $title;

    /**
     * @var string $blog
     */
    public $blog;
}
