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

        // Category filter
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Product type filter
        if ($request->type) {
            $query->where('product_type', $request->type);
        }

        // Brand filter
        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        // Price filter
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('brand', 'like', "%$search%")
                  ->orWhere('product_type', 'like', "%$search%");
            });
        }

        // Sort
        switch ($request->sort) {
            case 'price_asc':  $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'name':       $query->orderBy('name', 'asc'); break;
            default:           $query->latest(); break;
        }

        $filteredCount = $query->count();
        $products      = $query->paginate(12);
        $totalCount    = Product::where('active', true)->where('stock', '>', 0)->count();
        $categories    = Category::withCount(['products' => fn($q) => $q->where('active', true)->where('stock', '>', 0)])->get();
        $productTypes  = Product::where('active', true)->where('stock', '>', 0)->distinct()->pluck('product_type')->filter()->values();
        $brands        = Product::where('active', true)->where('stock', '>', 0)->distinct()->pluck('brand')->filter()->sort()->values();

        // AJAX request → return partial HTML + count
        if ($request->ajax() || $request->wantsJson()) {
            $html = view('products.partials.grid', compact('products'))->render();
            return response()->json(['html' => $html, 'count' => $filteredCount]);
        }

        return view('products.index', compact('products', 'categories', 'productTypes', 'brands', 'totalCount'));
    }

    public function search(Request $request)
    {
        $query = Product::with('category')
            ->where('active', true)
            ->where('stock', '>', 0);

        $searchTerm = $request->q ?? $request->search;
        if ($searchTerm) {
            $s = $searchTerm;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('description', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%")
                  ->orWhere('product_type', 'like', "%$s%");
            });
        }
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->type) {
            $query->where('product_type', $request->type);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        switch ($request->sort) {
            case 'price_asc':  $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'name':       $query->orderBy('name', 'asc'); break;
            default:           $query->latest(); break;
        }

        $count    = $query->count();
        $products = $query->paginate(12);
        $html     = view('products.partials.grid', compact('products'))->render();

        return response()->json(['html' => $html, 'count' => $count]);
    }

    // ✅ NOUVEAU : recherche live pour la navbar (retourne un tableau JSON de produits)
    public function navSearch(Request $request)
    {
        $q = $request->q;
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where('active', true)
            ->where('stock', '>', 0)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('brand', 'like', "%$q%")
                      ->orWhere('product_type', 'like', "%$q%");
            })
            ->limit(6)
            ->get();

        return response()->json($products->map(fn($p) => [
            'id'        => $p->id,
            'name'      => $p->name,
            'brand'     => $p->brand,
            'price'     => $p->price,
            'image_url' => $p->image ? asset('storage/' . $p->image) : null,
        ]));
    }

    public function show(Product $product)
    {
        $product->load('category');

        $related = Product::where('active', true)
            ->where('stock', '>', 0)
            ->where('id', '!=', $product->id)
            ->where(function($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('product_type', $product->product_type);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}