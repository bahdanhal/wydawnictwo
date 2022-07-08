<?php

namespace Recruitment\Entity;

use \Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product extends Entity
{
    private $name;
    private $minimumQuantity;
    private $price;
    private $vat;
    private const DEFAULT_MINIMUM_QUANTITY = 1.000;
    private const DEFAULT_VAT = 0.000;
    
    public function __construct()
    {
        $this->minimumQuantity = static::DEFAULT_MINIMUM_QUANTITY;
        $this->vat = static::DEFAULT_VAT;
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

    public function setVat(float $vat): Product
    {
        if ($vat < 0) {
            throw new \InvalidArgumentException();
        }
        $this->vat = $vat;
        return $this;
    }

    public function getVat(): float
    {
        return $this->vat;
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

    public function getUnitPriceGross(): float
    {
        return $this->price * (1 + 0.01 * $this->vat);
    }
}
