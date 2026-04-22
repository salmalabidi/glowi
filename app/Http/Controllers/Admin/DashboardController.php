<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats générales
        $usersCount = User::count();
        $adminsCount = User::where('is_admin', true)->count();

        $productsCount = Product::count();
        $activeProductsCount = Product::where('is_active', true)->count();

        $ordersCount = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $validatedOrders = Order::where('status', 'validated')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalRevenue = Order::where('status', 'validated')->sum('total');
        $pendingRevenue = Order::where('status', 'pending')->sum('total');

        // Derniers éléments
        $latestOrders = Order::with('user')->latest()->take(6)->get();
        $latestUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'adminsCount',
            'productsCount',
            'activeProductsCount',
            'ordersCount',
            'pendingOrders',
            'validatedOrders',
            'cancelledOrders',
            'totalRevenue',
            'pendingRevenue',
            'latestOrders',
            'latestUsers'
        ));
    }
}