@extends('layouts.app')

@section('content')
<style>
.checkout-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 48px 100px;
}
.checkout-header {
    margin-bottom: 32px;
}
.checkout-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    color: var(--text);
    font-weight: 400;
}
.checkout-subtitle {
    color: var(--text-light);
    margin-top: 8px;
}
.checkout-layout {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 32px;
}
.checkout-card,
.summary-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 10px;
    padding: 28px;
}
.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    margin-bottom: 18px;
    color: var(--text);
}
.user-info {
    display: grid;
    gap: 14px;
}
.info-row {
    padding: 14px 16px;
    border-radius: 8px;
    background: var(--rose-pale);
    color: var(--text);
}
.info-label {
    display: block;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--rose-deep);
    margin-bottom: 6px;
}
.order-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.order-item {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    gap: 16px;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid rgba(200,116,138,0.12);
}
.order-item:last-child {
    border-bottom: none;
}
.order-item img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    background: var(--rose-pale);
    border-radius: 8px;
    padding: 8px;
}
.item-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.35rem;
    color: var(--text);
}
.item-brand {
    color: var(--text-light);
    font-size: 0.82rem;
    margin-top: 4px;
}
.item-meta {
    margin-top: 8px;
    font-size: 0.82rem;
    color: var(--text-light);
}
.item-price {
    color: var(--rose-deep);
    font-weight: 600;
    font-size: 1rem;
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
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--text);
}
.confirm-btn {
    margin-top: 22px;
    width: 100%;
    background: var(--rose);
    color: #fff;
    border: none;
    padding: 15px 18px;
    border-radius: 8px;
    font-family: 'Jost', sans-serif;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}
.confirm-btn:hover {
    transform: translateY(-2px);
    background: var(--rose-deep);
    box-shadow: 0 14px 28px rgba(200,116,138,0.18);
}
.note {
    margin-top: 14px;
    font-size: 0.82rem;
    color: var(--text-light);
    line-height: 1.6;
}
@media (max-width: 900px) {
    .checkout-layout {
        grid-template-columns: 1fr;
    }
    .order-item {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="checkout-page">
    <div class="checkout-header">
        <h1 class="checkout-title">Finaliser ma commande</h1>
        <p class="checkout-subtitle">Vérifiez vos informations avant confirmation.</p>
    </div>

    <div class="checkout-layout">
        <div class="checkout-card">
            <h2 class="section-title">Informations client</h2>

            <div class="user-info">
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    {{ auth()->user()->name }}
                </div>

                <div class="info-row">
                    <span class="info-label">Email</span>
                    {{ auth()->user()->email }}
                </div>

                <div class="info-row">
                    <span class="info-label">Mode de traitement</span>
                    Commande confirmée immédiatement
                </div>
            </div>

            <h2 class="section-title" style="margin-top: 28px;">Articles</h2>

            <div class="order-list">
                @foreach($cart as $item)
                    <div class="order-item">
                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi' }}"
                             alt="{{ $item['name'] }}">

                        <div>
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-brand">{{ $item['brand'] }}</div>
                            <div class="item-meta">
                                Qté : {{ $item['quantity'] }} · PU : {{ number_format($item['price'], 2) }} TND
                            </div>
                        </div>

                        <div class="item-price">
                            {{ number_format($item['subtotal'], 2) }} TND
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="summary-card">
            <h2 class="section-title">Résumé</h2>

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

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <button type="submit" class="confirm-btn">Confirmer la commande</button>
            </form>

            <p class="note">
                Cette étape enregistre votre commande dans votre espace client et vide automatiquement votre panier.
            </p>
        </aside>
    </div>
</div>
@endsection