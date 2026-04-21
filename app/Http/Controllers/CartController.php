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

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
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
            if ($item['product_id'] == $data['product_id']) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (! $found) {
            $cart[] = [
                'product_id' => $data['product_id'],
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count' => collect($cart)->sum('quantity'),
        ]);
    }

    public function remove($item)
    {
        $cart = collect(session()->get('cart', []))
            ->reject(fn ($cartItem) => $cartItem['product_id'] == $item)
            ->values()
            ->all();

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}