<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Soumettre un avis (note + commentaire) sur un produit
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Empêcher un double avis du même utilisateur sur le même produit
        $already = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($already) {
            return redirect()
                ->route('products.show', $product)
                ->with('error', 'Vous avez déjà laissé un avis pour ce produit.');
        }

        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Votre avis a été publié. Merci !');
    }

    /**
     * Supprimer son propre avis
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()
            ->route('products.show', $productId)
            ->with('success', 'Votre avis a été supprimé.');
    }
}