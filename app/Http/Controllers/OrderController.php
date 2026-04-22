<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('account.orders', compact('orders'));
    }
}