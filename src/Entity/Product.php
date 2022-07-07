<?php

namespace Recruitment\Entity;

use \Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product extends Entity
{
    private $name;
    private $minimumQuantity;
    private $price;
    private const DEFAULT_MINIMUM_QUANTITY = 1.000;
    
    public function __construct()
    {
        $this->minimumQuantity = static::DEFAULT_MINIMUM_QUANTITY;
    }

    public function setMinimumQuantity(float $minimumQuantity): Product
    {
        if ($minimumQuantity <= 0) {
            throw new \InvalidArgumentException();
        }
        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }

    public function getMinimumQuantity(): float
    {
        return $this->minimumQuantity;
    }


    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setUnitPrice(float $price): Product
    {
        if ($price <= 0) {
            throw new InvalidUnitPriceException();
        }
        $this->price = $price;
        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->price;
    }
}
