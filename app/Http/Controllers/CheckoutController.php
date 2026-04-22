<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = collect(session('cart', []))
            ->map(function ($item) {
                $product = Product::find($item['product_id']);

                if (! $product) {
                    return null;
                }

                $quantity = max(1, (int) $item['quantity']);
                $subtotal = (float) $product->price * $quantity;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'price' => (float) $product->price,
                    'image' => $product->image,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            })
            ->filter()
            ->values();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Votre panier est vide.');
        }

        $total = $cart->sum('subtotal');

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = collect(session('cart', []))
            ->map(function ($item) {
                $product = Product::find($item['product_id']);

                if (! $product) {
                    return null;
                }

                $quantity = max(1, (int) $item['quantity']);
                $price = (float) $product->price;

                return [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                ];
            })
            ->filter()
            ->values();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Votre panier est vide.');
        }

        $total = $cart->sum('subtotal');

        DB::transaction(function () use ($cart, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('orders')->with('success', 'Votre commande a bien été confirmée.');
    }
}