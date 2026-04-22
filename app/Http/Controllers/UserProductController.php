<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProductController extends Controller
{
    /**
     * Liste des produits de l'utilisateur connecté.
     */
    public function index()
    {
        $products = Auth::user()->products()->with('category')->latest()->paginate(12);
        return view('user.products.index', compact('products'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $categories = Category::all();
        return view('user.products.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau produit lié à l'utilisateur.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'brand'        => 'nullable|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['active']  = true;

        Product::create($data);

        return redirect()->route('user.products.index')
            ->with('success', 'Produit ajouté avec succès ! Il est maintenant visible sur le catalogue.');
    }

    /**
     * Formulaire d'édition (uniquement le propriétaire).
     */
    public function edit(Product $product)
    {
        $this->authorize_owner($product);
        $categories = Category::all();
        return view('user.products.edit', compact('product', 'categories'));
    }

    /**
     * Mise à jour (uniquement le propriétaire).
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize_owner($product);

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'brand'        => 'nullable|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('user.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Suppression (uniquement le propriétaire).
     */
    public function destroy(Product $product)
    {
        $this->authorize_owner($product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('user.products.index')
            ->with('success', 'Produit supprimé.');
    }

    /**
     * Vérifie que l'utilisateur connecté est bien le propriétaire.
     */
    private function authorize_owner(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Accès refusé — ce produit ne vous appartient pas.');
        }
    }
}
