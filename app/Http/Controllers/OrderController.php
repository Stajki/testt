<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Money\Currency;
use Money\Money;

class OrderController extends Controller
{
    public function store()
    {
        $user = User::findCurrent();
        $totalPriceNett = new Money(0, new Currency('PLN'));
        $totalPriceGross = new Money(0, new Currency('PLN'));
        $cart = session()->get('cart');
        foreach ($cart as $product) {
            $priceNett = (new Money($product['price_nett'] * 100, new Currency('PLN')))->multiply($product['quantity']);
            $priceGross = (new Money($product['price_gross'] * 100, new Currency('PLN')))->multiply($product['quantity']);
            $totalPriceNett = $totalPriceNett->add($priceNett);
            $totalPriceGross = $totalPriceGross->add($priceGross);
        }
        /** @var Order $order */
        $order = Order::make([
            'total_price_nett' => $totalPriceNett,
            'total_price_gross' => $totalPriceGross,
        ]);
        $order->user()->associate($user);
        $order->save();
        $createdAt = new Carbon($order->created_at);

        $order->update([
            'order_number' => $order->id . '/' . $createdAt->month . '/' . $createdAt->year,
        ]);

        foreach ($cart as $key => $product) {
            /** @var OrderItem $item */
            $item = OrderItem::make([
                'price_nett' =>  new Money($product['price_nett'] * 100, new Currency('PLN')),
                'price_gross' =>  new Money($product['price_gross'] * 100, new Currency('PLN')),
                'quantity' => $product['quantity'],
            ]);
            $productModel = Product::withTrashed()->findOrFail($key);
            $item->order()->associate($order);
            $item->product()->associate($productModel);
            $item->save();
            $productModel->update([
               'available_stock' => $productModel->available_stock - $product['quantity'],
            ]);
        }

        session()->remove('cart');
        session()->remove('total_quantity');

        return redirect('/order/' . $order->id);
    }

    public function show(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->load([
           'items',
           'items.product',
        ]);

        return view('order.show', [
            'order' => $order,
            'items' => $order->items,
        ]);
    }

    public function index()
    {
        $user = User::findCurrent();
        $orders = Order::query()
            ->with([
                'items',
                'items.product',
            ])
            ->where('user_id', $user->id)
            ->get()
        ;

        return view('order.index', [
            'orders' => $orders,
        ]);
    }
}
