<?php

namespace App\DTOs\Users;


use App\DTOs\BaseDTO;

class AdDTO extends BaseDTO
{
    /**
     * @var string $title
     */
    public $title;
    /**
     * @var double $price
     */
    public $price;
    /**
     * @var string $description
     */
    public $description;
    /**
     * @var double $size
     */
    public $size;
    /**
     * @var string $general_type
     */
    public $general_type;
    /**
     * @var string $type
     */
    public $type;
    /**
     * @var int $floor
     */
    public $floor;
    /**
     * @var int $rooms
     */
    public $rooms;
    /**
     * @var int $pathrooms
     */
    public $bathrooms;
    /**
     * @var int $kitchens
     */
    public $kitchens;
    /**
     * @var string $finish
     */
    public $finish;
    /**
     * @var string $furniture
     */
    public $furniture;
    /**
     * @var string $parking
     */
    public $parking;
    /**
     * @var string $address
     */
    public $address;
    /**
     * @var $images
     */
    public $images;
}
