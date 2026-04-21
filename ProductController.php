<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('active', true)
            ->where('stock', '>', 0);

        // Filtre catégorie
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filtre type
        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        // Recherche
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Tri
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        // Types disponibles (selon catégorie sélectionnée si filtrée)
        $typesQuery = Product::where('active', true)->where('stock', '>', 0);
        if ($request->filled('category')) {
            $typesQuery->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        $types = $typesQuery->distinct()->pluck('product_type')->filter()->sort()->values();

        return view('products.index', compact('products', 'categories', 'types'));
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->where('active', true)
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    // AJAX Search endpoint
    public function search(Request $request)
    {
        $q = $request->get('q', '');

        if (strlen($q) < 2) return response()->json([]);

        $products = Product::with('category')
            ->where('active', true)
            ->where('stock', '>', 0)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('brand', 'like', "%$q%")
                      ->orWhere('product_type', 'like', "%$q%");
            })
            ->limit(6)
            ->get()
            ->map(fn($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => $p->price,
                'brand'     => $p->brand,
                'image_url' => $p->image_url,
                'category'  => $p->category->name,
            ]);

        return response()->json($products);
    }
}
