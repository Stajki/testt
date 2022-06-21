<?php

namespace App\Components;

use Money\Money;
use App\Models\Product;

class CartProduct
{
    private $product, $quantity, $priceNett, $priceGross;

    public function __construct(Product $product, int $quantity, Money $priceNett, Money $priceGross)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->priceNett = $priceNett;
        $this->priceGross = $priceGross;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPriceNett(): Money
    {
        return $this->priceNett;
    }

    public function getPriceGross(): Money
    {
        return $this->priceGross;
    }
}
