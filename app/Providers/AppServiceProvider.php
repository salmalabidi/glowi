<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Utiliser notre vue de pagination personnalisée (div au lieu de nav)
        Paginator::defaultView('pagination.custom');
        Paginator::defaultSimpleView('pagination.custom');

        View::composer('*', function ($view) {
            $cartCount = collect(session('cart', []))->sum('quantity');
            $view->with('cartCount', $cartCount);
        });
    }
}