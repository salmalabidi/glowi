<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user'])
            ->where('active', true)
            ->where('stock', '>', 0);

        if ($request->filled('category')) {
            $categoryInput = trim((string) $request->category);
            $query->whereHas('category', function ($q) use ($categoryInput) {
                $q->where('slug', $categoryInput)
                  ->orWhereRaw('LOWER(name) = ?', [mb_strtolower($categoryInput)]);
            });
        }

        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('search')) {
            $search = mb_strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(brand) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(product_type) LIKE ?', ["%{$search}%"]);
            });
        }

        switch ($request->sort) {
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'name': $query->orderBy('name', 'asc'); break;
            default: $query->latest(); break;
        }

        $filteredCount = $query->count();
        $products = $query->paginate(12);

        $totalCount = Product::where('active', true)->where('stock', '>', 0)->count();
        $categories = Category::withCount([
            'products' => fn ($q) => $q->where('active', true)->where('stock', '>', 0)
        ])->orderBy('name')->get();

        $productTypes = Product::where('active', true)->where('stock', '>', 0)->distinct()->pluck('product_type')->filter()->values();
        $brands = Product::where('active', true)->where('stock', '>', 0)->distinct()->pluck('brand')->filter()->sort()->values();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('products.partials.grid', compact('products'))->render();
            $pagination = $products->withQueryString()->links()->toHtml();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'count' => $filteredCount,
            ]);
        }

        return view('products.index', compact('products', 'categories', 'productTypes', 'brands', 'totalCount'));
    }

    public function search(Request $request)
    {
        if ($request->has('q')) {
            $q = trim($request->q);
            if (strlen($q) < 2) return response()->json([]);
            $s = mb_strtolower($q);

            $products = Product::with('category')
                ->where('active', true)
                ->where('stock', '>', 0)
                ->where(function ($query) use ($s) {
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$s}%"])
                        ->orWhereRaw('LOWER(brand) LIKE ?', ["%{$s}%"])
                        ->orWhereRaw('LOWER(product_type) LIKE ?', ["%{$s}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$s}%"]);
                })
                ->orderBy('name')
                ->limit(8)
                ->get();

            return response()->json($products->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'brand' => $p->brand ?? '',
                    'price' => (float) $p->price,
                    'image_url' => $p->image ? asset('storage/' . $p->image) : null,
                    'category' => optional($p->category)->name ?? '',
                ];
            })->values());
        }

        return $this->index($request);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user', 'user']);

        $related = Product::where('active', true)
            ->where('stock', '>', 0)
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('product_type', $product->product_type);
            })
            ->inRandomOrder()->take(4)->get();

        $reviews = $product->reviews()->with('user')->latest()->get();
        $inWishlist = auth()->check()
            ? \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists()
            : false;

        return view('products.show', compact('product', 'related', 'reviews', 'inWishlist'));
    }
}
