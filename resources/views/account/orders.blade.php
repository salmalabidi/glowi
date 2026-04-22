@extends('layouts.app')

@section('content')
<style>
.orders-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 48px 100px;
}
.orders-header {
    margin-bottom: 32px;
}
.orders-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    color: var(--text);
    font-weight: 400;
}
.orders-subtitle {
    color: var(--text-light);
    margin-top: 8px;
}
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 22px;
}
.order-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 10px;
    padding: 24px;
}
.order-top {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
.order-id {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    color: var(--text);
}
.order-meta {
    color: var(--text-light);
    font-size: 0.85rem;
    margin-top: 6px;
}
.order-status {
    background: var(--rose-pale);
    color: var(--rose-deep);
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    height: fit-content;
}
.order-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
    border-top: 1px solid rgba(200,116,138,0.12);
    padding-top: 18px;
}
.order-item {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    color: var(--text);
    flex-wrap: wrap;
}
.order-total {
    margin-top: 18px;
    padding-top: 18px;
    border-top: 1px solid rgba(200,116,138,0.12);
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    color: var(--text);
}
.empty-orders {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 10px;
    padding: 48px 24px;
    text-align: center;
}
.empty-orders h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 10px;
}
.empty-orders p {
    color: var(--text-light);
    margin-bottom: 20px;
}
.shop-btn {
    display: inline-block;
    background: var(--rose);
    color: #fff;
    text-decoration: none;
    padding: 12px 18px;
    border-radius: 8px;
}
</style>

@php
    $orders = auth()->user()->orders()->with('items.product')->latest()->get();
@endphp

<div class="orders-page">
    <div class="orders-header">
        <h1 class="orders-title">Mes commandes</h1>
        <p class="orders-subtitle">Retrouvez l’historique de vos achats.</p>
    </div>

    @if($orders->isEmpty())
        <div class="empty-orders">
            <h3>Aucune commande pour le moment</h3>
            <p>Votre historique apparaîtra ici après votre premier checkout.</p>
            <a href="{{ route('products.index') }}" class="shop-btn">Découvrir les produits</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-top">
                        <div>
                            <div class="order-id">Commande #{{ $order->id }}</div>
                            <div class="order-meta">
                                Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>

                        <div class="order-status">
                            {{ $order->status }}
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="order-item">
                                <span>
                                    {{ $item->product->name ?? 'Produit supprimé' }}
                                    · Qté : {{ $item->quantity }}
                                </span>
                                <span>{{ number_format($item->subtotal, 2) }} TND</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        <span>Total</span>
                        <span>{{ number_format($order->total, 2) }} TND</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection