<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($cat = $request->input('category')) {
            $query->where('category_id', $cat);
        }

        if ($request->input('stock') === 'out') {
            $query->where('stock', '<=', 0);
        } elseif ($request->input('stock') === 'low') {
            $query->where('stock', '>', 0)->where('stock', '<=', 5);
        }

        $products   = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'brand'       => 'nullable|string|max:255',
            'product_type'=> 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
            'active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['active'] = $request->boolean('active');

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'brand'       => 'nullable|string|max:255',
            'product_type'=> 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
            'active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['active'] = $request->boolean('active');

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['active' => !$product->active]);
        return back()->with('success', 'Statut du produit modifié.');
    }
}
