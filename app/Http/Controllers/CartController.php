<?php

namespace App\Http\Controllers;

use App\Components\CartProduct;
use App\Helpers\SessionHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CartController extends Controller
{
    public function update(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->post('quantity');
        if ($quantity > $product->available_stock || $quantity < 0) {
            throw new BadRequestException('Unavailable stock.');
        }

        $cart = session()->get('cart');
        session()->remove('cart');

        $cart[$productId] = [
            'quantity' => $quantity,
            'price_nett' => $product->price_nett->getAmount() / 100,
            'price_gross' => $product->price_gross->getAmount() / 100,
        ];

        if (isset($cart[$productId]) && $quantity == 0) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);
        $totalQuantity = SessionHelper::updateTotalQuantity();

        return response()->json([
            'total_quantity' => $totalQuantity,
            'message' => 'Success',
        ]);
    }

    public function show()
    {
        $cart = session()->get('cart');
        $products = $this->populateProducts($cart);
        $totalAmount = 0;
        $products->each(function ($product) use (&$totalAmount) {
            $totalAmount += ($product->getPriceGross()->getAmount() / 100) * $product->getQuantity();
        });

        return view('cart.index', [
            'products' => $products,
            'total_amount' => $totalAmount,
        ]);
    }

    private function populateProducts(?array $cart): Collection
    {
        $products = collect();

        if (!is_array($cart)) {
            return $products;
        }

        foreach ($cart as $key => $product) {
            $productModel = Product::withTrashed()->findOrFail($key);

            $products->push(new CartProduct(
                $productModel,
                $product['quantity'],
                new Money($product['price_nett'] * 100, new Currency('PLN')),
                new Money($product['price_gross'] * 100, new Currency('PLN'))
            ));
        }

        return $products;
    }
}
