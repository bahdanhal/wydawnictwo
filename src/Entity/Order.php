<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Cart;
use Recruitment\Interfaces\PreparedDataInterface;
use Recruitment\Helper\DataHelper;

class Order extends Entity implements PreparedDataInterface
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = clone $cart;
    }

    public function getDataForView(): array
    {
        return [
            'id' => $this->getId(),
            'items' => $this->cart->getDataForView(),
            'total_price' => DataHelper::prepareFloat($this->cart->getTotalPrice()),
            'total_price_gross' => DataHelper::prepareFloat($this->cart->getTotalPriceGross())
        ];
    }
}
