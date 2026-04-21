@extends('layouts.app')

@section('content')
<style>
.cart-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 48px 100px;
}
.cart-header {
    margin-bottom: 32px;
}
.cart-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    color: var(--text);
    font-weight: 400;
}
.cart-subtitle {
    color: var(--text-light);
    margin-top: 8px;
}
.cart-layout {
    display: grid;
    grid-template-columns: 1.6fr 0.8fr;
    gap: 32px;
}
.cart-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.cart-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 18px;
    display: grid;
    grid-template-columns: 110px 1fr auto;
    gap: 18px;
    align-items: center;
}
.cart-card img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    background: var(--rose-pale);
    border-radius: 6px;
    padding: 10px;
}
.cart-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    color: var(--text);
}
.cart-brand {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-top: 4px;
}
.cart-meta {
    margin-top: 12px;
    display: flex;
    gap: 18px;
    color: var(--text-light);
    font-size: 0.85rem;
}
.cart-price {
    font-size: 1.1rem;
    color: var(--rose-deep);
    font-weight: 600;
}
.remove-btn {
    margin-top: 12px;
    border: 1px solid rgba(200,116,138,0.2);
    background: transparent;
    color: var(--rose-deep);
    padding: 10px 14px;
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    cursor: pointer;
}
.cart-summary {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 24px;
    height: fit-content;
    position: sticky;
    top: 110px;
}
.summary-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 20px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
    color: var(--text-light);
}
.summary-total {
    display: flex;
    justify-content: space-between;
    margin-top: 18px;
    padding-top: 18px;
    border-top: 1px solid rgba(200,116,138,0.14);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text);
}
.checkout-btn {
    margin-top: 22px;
    width: 100%;
    background: var(--rose);
    color: #fff;
    border: none;
    padding: 14px 18px;
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.empty-cart {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 8px;
    padding: 48px 24px;
    text-align: center;
}
.empty-cart h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 10px;
}
.empty-cart p {
    color: var(--text-light);
    margin-bottom: 20px;
}
.back-shop {
    display: inline-block;
    text-decoration: none;
    background: var(--rose);
    color: #fff;
    padding: 12px 18px;
    border-radius: 6px;
}
@media (max-width: 900px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
    .cart-card {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="cart-page">
    <div class="cart-header">
        <h1 class="cart-title">Mon panier</h1>
        <p class="cart-subtitle">Retrouvez vos produits sélectionnés.</p>
    </div>

    @if($cart->isEmpty())
        <div class="empty-cart">
            <h3>Votre panier est vide</h3>
            <p>Ajoutez quelques produits pour commencer.</p>
            <a href="{{ route('products.index') }}" class="back-shop">Continuer mes achats</a>
        </div>
    @else
        <div class="cart-layout">
            <div class="cart-list">
                @foreach($cart as $item)
                    <div class="cart-card">
                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi' }}"
                             alt="{{ $item['name'] }}">

                        <div>
                            <div class="cart-name">{{ $item['name'] }}</div>
                            <div class="cart-brand">{{ $item['brand'] }}</div>

                            <div class="cart-meta">
                                <span>Qté : {{ $item['quantity'] }}</span>
                                <span>PU : {{ number_format($item['price'], 2) }} TND</span>
                            </div>

                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">Retirer</button>
                            </form>
                        </div>

                        <div class="cart-price">
                            {{ number_format($item['subtotal'], 2) }} TND
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="cart-summary">
                <div class="summary-title">Résumé</div>
                <div class="summary-row">
                    <span>Articles</span>
                    <span>{{ $cart->sum('quantity') }}</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span>Offerte</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>{{ number_format($total, 2) }} TND</span>
                </div>

                <button class="checkout-btn" type="button">Commander</button>
            </aside>
        </div>
    @endif
</div>
@endsection