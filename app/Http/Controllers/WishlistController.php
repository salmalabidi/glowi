<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);

        $wishlist = collect($wishlistIds)
            ->map(function ($productId) {
                return Product::with('category')->find($productId);
            })
            ->filter()
            ->values();

        return view('wishlist.index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $wishlist = session()->get('wishlist', []);

        if (in_array($data['product_id'], $wishlist)) {
            $wishlist = array_values(array_filter($wishlist, fn ($id) => $id != $data['product_id']));
            $added = false;
        } else {
            $wishlist[] = $data['product_id'];
            $added = true;
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'success' => true,
            'added' => $added,
            'count' => count($wishlist),
        ]);
    }

    public function remove($productId)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_values(array_filter($wishlist, fn ($id) => $id != $productId));

        session()->put('wishlist', $wishlist);

        return response()->json([
            'success' => true,
            'count' => count($wishlist),
        ]);
    }
}