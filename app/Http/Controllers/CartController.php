<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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
                $price = (float) $product->price;
                $subtotal = $price * $quantity;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'price' => $price,
                    'image' => $product->image,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            })
            ->filter()
            ->values();

        $total = $cart->sum('subtotal');

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $data['quantity'] ?? 1;
        $cart = session()->get('cart', []);

        $found = false;

        foreach ($cart as &$item) {
            if ((int) $item['product_id'] === (int) $data['product_id']) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (! $found) {
            $cart[] = [
                'product_id' => (int) $data['product_id'],
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count' => collect($cart)->sum('quantity'),
        ]);
    }

    public function updateQuantity(Request $request, $item)
    {
        $data = $request->validate([
            'action' => ['required', 'in:increase,decrease'],
        ]);

        $cart = collect(session()->get('cart', []))
            ->map(function ($cartItem) use ($item, $data) {
                if ((int) $cartItem['product_id'] === (int) $item) {

                    if ($data['action'] === 'increase') {
                        $cartItem['quantity'] += 1;
                    }

                    if ($data['action'] === 'decrease') {
                        $cartItem['quantity'] -= 1;
                    }
                }

                return $cartItem;
            })
            ->filter(fn ($cartItem) => (int) $cartItem['quantity'] > 0)
            ->values()
            ->all();

        session()->put('cart', $cart);

        $product = Product::find($item);
        $currentItem = collect($cart)->firstWhere('product_id', (int) $item);

        $itemQuantity = $currentItem['quantity'] ?? 0;
        $itemSubtotal = $product ? ((float) $product->price * $itemQuantity) : 0;

        $cartTotal = collect($cart)->sum(function ($cartItem) {
            $product = Product::find($cartItem['product_id']);
            return $product ? ((float) $product->price * (int) $cartItem['quantity']) : 0;
        });

        return response()->json([
            'success' => true,
            'count' => collect($cart)->sum('quantity'),
            'itemQuantity' => $itemQuantity,
            'itemSubtotal' => number_format($itemSubtotal, 2),
            'cartTotal' => number_format($cartTotal, 2),
            'removed' => $itemQuantity <= 0,
        ]);
    }

    /**
     * ✅ ACHETER MAINTENANT (corrigé propre)
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = max(1, (int) $request->input('quantity', 1));

        // 🔥 important : remplace complètement le panier
        session()->put('cart', [[
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]]);

        return redirect()->route('checkout.index');
    }

    public function remove(Request $request, $item)
    {
        $cart = collect(session()->get('cart', []))
            ->reject(fn ($cartItem) => (int) $cartItem['product_id'] === (int) $item)
            ->values()
            ->all();

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => collect($cart)->sum('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produit supprimé du panier.');
    }
}