<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats générales
        $usersCount          = User::count();
        $adminsCount         = User::where('is_admin', true)->count();

        $productsCount       = Product::count();
        $activeProductsCount = Product::where('active', true)->count();

        $ordersCount         = Order::count();
        $pendingOrders       = Order::where('status', 'pending')->count();
        $validatedOrders     = Order::where('status', 'validated')->count();
        $cancelledOrders     = Order::where('status', 'cancelled')->count();

        $totalRevenue        = Order::where('status', 'validated')->sum('total');
        $pendingRevenue      = Order::where('status', 'pending')->sum('total');

        // Derniers éléments
        $latestOrders = Order::with('user')->latest()->take(6)->get();
        $latestUsers  = User::latest()->take(6)->get();

        // ── Données graphiques (compatibles SQLite + MySQL) ──────────────

        // Détecte le driver de base de données
        $driver = DB::getDriverName(); // 'sqlite' ou 'mysql'

        $dateFormat = $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        // 1) Revenus des 6 derniers mois (validées uniquement)
        $revenueByMonth = Order::where('status', 'validated')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("{$dateFormat} as month, SUM(total) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $revenueLabels = [];
        $revenueData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $revenueLabels[] = now()->subMonths($i)->format('M Y');
            $revenueData[]   = round((float)($revenueByMonth[$key] ?? 0), 2);
        }

        // 2) Commandes par statut (donut)
        $orderStatusData = [
            'pending'   => $pendingOrders,
            'validated' => $validatedOrders,
            'cancelled' => $cancelledOrders,
        ];

        // 3) Nouvelles inscriptions par mois (6 mois)
        $usersByMonth = User::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("{$dateFormat} as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $usersLabels = [];
        $usersData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $usersLabels[] = now()->subMonths($i)->format('M Y');
            $usersData[]   = (int)($usersByMonth[$key] ?? 0);
        }

        // 4) Top 5 produits les plus commandés
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as qty')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        $topProductLabels = $topProducts->pluck('name')->toArray();
        $topProductData   = $topProducts->pluck('qty')->map(fn($v) => (int)$v)->toArray();

        return view('admin.dashboard', compact(
            'usersCount', 'adminsCount',
            'productsCount', 'activeProductsCount',
            'ordersCount', 'pendingOrders', 'validatedOrders', 'cancelledOrders',
            'totalRevenue', 'pendingRevenue',
            'latestOrders', 'latestUsers',
            'revenueLabels', 'revenueData',
            'orderStatusData',
            'usersLabels', 'usersData',
            'topProductLabels', 'topProductData'
        ));
    }
}