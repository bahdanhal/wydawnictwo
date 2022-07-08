<?php

namespace Recruitment\Cart;

use Recruitment\BaseEntity;
use Recruitment\Entity\Product;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Helper\DataHelper;
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

    public function getTotalPriceGross(): float
    {
        return $this->product->getUnitPriceGross() * $this->quantity;
    }

    public function getProductVatStr(): string
    {
        $vat = $this->product->getVat();
        $vatStr = DataHelper::prepareFloat($vat);
        $vatStr .= '%';
        return $vatStr;
    }

    public function getDataForView(): array
    {
        return [
            'id' => $this->product->getId(),
            'quantity' => DataHelper::prepareFloat($this->getQuantity()),
            'total_price' => DataHelper::prepareFloat($this->getTotalPrice()),
            'total_price_gross' => DataHelper::prepareFloat($this->getTotalPriceGross()),
            'product_vat' => $this->getProductVatStr()
        ];
    }
}
