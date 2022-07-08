<?php

namespace Recruitment\Cart;

use Recruitment\BaseEntity;
use Recruitment\Entity\Product;
use Recruitment\Entity\Order;
use Recruitment\Interfaces\PreparedDataInterface;
use \OutOfBoundsException;

class Cart extends BaseEntity implements PreparedDataInterface
{
    private $items;
    
    public function __construct()
    {
        $this->items = [];
    }

    public function __clone()
    {
        $this->items = $this->items;
    }

    public function addProduct(Product $product, float $quantity = 1): Cart
    {
        $productId = $product->getId();
        try {
            $key = $this->getItemKeyById($productId);
            $this->setQuantity($product, $quantity += $this->items[$key]->getQuantity());
        } catch (OutOfBoundsException $e) {
            $this->items[] = new Item($product, $quantity);
        }
        return $this;
    }

    public function removeProduct(Product $product): Cart
    {
        $removedId = $product->getId();
        try {
            $key = $this->getItemKeyById($removedId);
            unset($this->items[$key]);
            $this->items = array_values($this->items);
        } catch (OutOfBoundsException $e) {
        }
        return $this;
    }

    public function setQuantity(Product $product, float $quantity): Cart
    {
        $productId = $product->getId();
        try {
            $key = $this->getItemKeyById($productId);
            $this->items[$key]->setQuantity($quantity);
        } catch (OutOfBoundsException $e) {
            $this->items[] = new Item($product, $quantity);
        }
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getProduct()->getUnitPrice() * $item->getQuantity();
        }
        return $totalPrice;
    }

    public function getTotalPriceGross(): float
    {
        $totalPriceGross = 0;
        foreach ($this->items as $item) {
            $totalPriceGross += $item->getProduct()->getUnitPriceGross() * $item->getQuantity();
        }
        return $totalPriceGross;
    }

    public function getDataForView(): array
    {
        $itemsData = [];
        foreach ($this->items as $item) {
            $itemsData[] = $item->getDataForView();
        }
        return $itemsData;
    }

    public function checkout($orderId): Order
    {
        $order = new Order($this);
        $order->setId($orderId);
        $this->items = [];
        return $order;
    }

    public function getItem($index): Item
    {
        if (empty($this->items[$index])) {
            throw new OutOfBoundsException();
        }
        return $this->items[$index];
    }

    public function getItemKeyById($id): int
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProduct()->getId() == $id) {
                return $key;
            }
        }
        throw new OutOfBoundsException();
    }
}
