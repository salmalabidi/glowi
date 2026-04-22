<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = collect(session('cart', []))->sum('quantity');
            $wishCount = 0;
            if (auth()->check()) {
                $wishCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
            }
            $view->with('cartCount', $cartCount);
            $view->with('wishCount', $wishCount);
        });
    }
}