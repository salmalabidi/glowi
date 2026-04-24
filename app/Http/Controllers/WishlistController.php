<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->pluck('product')
            ->filter()
            ->values();

        return view('wishlist.index', compact('wishlist'));
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $data['product_id'],
            ]);
            $added = true;
        }

        return response()->json([
            'success' => true,
            'added' => $added,
            'count' => Wishlist::where('user_id', Auth::id())->count(),
        ]);
    }

    public function ids()
    {
        return response()->json(
            Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->values()
        );
    }

    public function remove($productId)
    {
        $deleted = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        if (! $deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Produit introuvable dans la wishlist.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'count' => Wishlist::where('user_id', Auth::id())->count(),
        ]);
    }
}