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
                $product = Product::find($item['product_id'] ?? null);

                if (! $product) {
                    return null;
                }

                $quantity = max(1, (int) ($item['quantity'] ?? 1));
                $price = (float) $product->price;
                $subtotal = $price * $quantity;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand ?? '',
                    'price' => $price,
                    'image' => $product->image ?? null,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            })
            ->filter()
            ->values();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cart->sum('subtotal');

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,online'],
        ]);

        $cart = collect(session('cart', []))
            ->map(function ($item) {
                $product = Product::find($item['product_id'] ?? null);

                if (! $product) {
                    return null;
                }

                $quantity = max(1, (int) ($item['quantity'] ?? 1));
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
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cart->sum('subtotal');
        $paymentMethod = $data['payment_method'];

        DB::transaction(function () use ($cart, $total, $paymentMethod) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'online' ? 'paid' : 'unpaid',
                'payment_provider' => $paymentMethod === 'online' ? 'demo' : null,
                'provider_payment_id' => null,
                'paid_at' => $paymentMethod === 'online' ? now() : null,
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

        $message = $paymentMethod === 'online'
            ? 'Commande confirmée avec paiement en ligne.'
            : 'Commande confirmée. Paiement à la livraison.';

        return redirect()->route('orders')->with('success', $message);
    }
}