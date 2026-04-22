<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ]);
            $added = true;
        }

        $count = Wishlist::where('user_id', auth()->id())->count();

        return response()->json(['added' => $added, 'count' => $count]);
    }

    public function remove(Wishlist $wishlist)
    {
        abort_if($wishlist->user_id !== auth()->id(), 403);
        $wishlist->delete();
        return back()->with('success', 'Produit retiré de la wishlist.');
    }

    public function ids()
    {
        $ids = Wishlist::where('user_id', auth()->id())->pluck('product_id');
        return response()->json($ids);
    }
}