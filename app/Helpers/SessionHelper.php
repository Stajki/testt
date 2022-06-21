<?php

namespace App\Helpers;

class SessionHelper
{
    public static function updateTotalQuantity(): int
    {
        $totalQuantity = 0;
        $cart = session()->get('cart');
        session()->remove('total_quantity');

        if (!is_array($cart)) {
            session()->put('total_quantity', $totalQuantity);
            return $totalQuantity;
        }

        foreach ($cart as $product) {
            $totalQuantity += $product['quantity'];
        }

        session()->put('total_quantity', $totalQuantity);

        return $totalQuantity;
    }
}
