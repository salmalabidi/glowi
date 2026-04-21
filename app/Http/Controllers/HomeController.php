<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 3 latest nouveautés
        $nouveautes = Product::where('active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(3)
            ->get();

        // 3 maquillage products
        $maquillageCategory = Category::where('slug', 'maquillage')->first();
        $maquillages = Product::where('active', true)
            ->where('stock', '>', 0)
            ->when($maquillageCategory, fn($q) => $q->where('category_id', $maquillageCategory->id))
            ->inRandomOrder()
            ->take(3)
            ->get();

        // 3 skincare products
        $skincareCategory = Category::where('slug', 'skincare')->first();
        $skincares = Product::where('active', true)
            ->where('stock', '>', 0)
            ->when($skincareCategory, fn($q) => $q->where('category_id', $skincareCategory->id))
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('home', compact('nouveautes', 'maquillages', 'skincares'));
    }
}