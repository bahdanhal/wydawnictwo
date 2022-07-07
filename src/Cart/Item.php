<?php

namespace Recruitment\Cart;

use Recruitment\BaseEntity;
use Recruitment\Entity\Product;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Interfaces\PreparedDataInterface;

class Item extends BaseEntity implements PreparedDataInterface
{
    private $product;
    private $quantity;

    public function __construct(Product $product, float $quantity)
    {
        if ($quantity < $product->getMinimumQuantity()) {
            throw new \InvalidArgumentException();
        }
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function setQuantity(float $quantity): Item
    {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException();
        }
        $this->quantity = $quantity;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getTotalPrice(): float
    {
        return $this->product->getUnitPrice() * $this->quantity;
    }

    public function getDataForView(): array
    {
        return [
            'id' => $this->product->getId(),
            'quantity' => $this->getQuantity(),
            'total_price' => $this->getTotalPrice()
        ];
    }
}
