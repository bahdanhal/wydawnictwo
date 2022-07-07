<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Cart;
use Recruitment\Interfaces\PreparedDataInterface;

class Order extends Entity implements PreparedDataInterface
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = clone $cart;
    }

    public function getDataForView(): array
    {
        $items = $this->cart->getDataForView();
        $totalPrice = $this->cart->getTotalPrice();
        return ['id' => $this->getId(), 'items' => $items, 'total_price' => $totalPrice];
    }
}
