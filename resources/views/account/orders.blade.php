@extends('layouts.app')

@section('content')
<style>
.orders-page {
    max-width: 1240px;
    margin: 0 auto;
    padding: 56px 40px 100px;
}

.orders-hero {
    margin-bottom: 34px;
    animation: fadeSlideUp 0.7s ease both;
}

.orders-kicker {
    display: inline-block;
    color: var(--rose);
    font-size: 0.72rem;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.orders-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5vw, 4.4rem);
    line-height: 1;
    color: var(--text);
    margin-bottom: 12px;
    font-weight: 400;
}

.orders-subtitle {
    color: var(--text-light);
    font-size: 1rem;
    line-height: 1.8;
    max-width: 700px;
}

.orders-topbar {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin: 30px 0 34px;
}

.orders-stat {
    position: relative;
    overflow: hidden;
    background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(255,255,255,0.80));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 24px;
    padding: 22px 24px;
    box-shadow: 0 18px 42px rgba(36,18,25,0.06);
    backdrop-filter: blur(12px);
    animation: fadeSlideUp 0.8s ease both;
}

.orders-stat:nth-child(2) { animation-delay: 0.08s; }
.orders-stat:nth-child(3) { animation-delay: 0.16s; }

.orders-stat::after {
    content: '';
    position: absolute;
    inset: auto -10% -35% auto;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,116,138,0.10), transparent 70%);
    pointer-events: none;
}

.orders-stat-label {
    color: var(--text-light);
    font-size: 0.72rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.orders-stat-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    line-height: 1;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.order-card {
    position: relative;
    overflow: hidden;
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 28px;
    box-shadow: 0 20px 48px rgba(36,18,25,0.06);
    padding: 28px 30px;
    transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
    animation: fadeSlideUp 0.75s ease both;
}

.order-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 26px 58px rgba(36,18,25,0.10);
    border-color: rgba(200,116,138,0.18);
}

.order-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--rose), var(--gold));
    opacity: 0.75;
}

.order-head {
    display: flex;
    justify-content: space-between;
    gap: 18px;
    align-items: flex-start;
    margin-bottom: 20px;
}

.order-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 8px;
    line-height: 1;
}

.order-date {
    color: var(--text-light);
    font-size: 0.95rem;
}

.order-status {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    white-space: nowrap;
}

.order-status::before {
    content: '';
    width: 9px;
    height: 9px;
    border-radius: 50%;
    display: inline-block;
    animation: pulseDot 1.8s infinite;
}

.status-pending {
    background: rgba(230, 185, 120, 0.14);
    color: #a86d12;
    border: 1px solid rgba(230, 185, 120, 0.22);
}

.status-pending::before {
    background: #d8a23a;
}

.status-validated {
    background: rgba(98, 184, 128, 0.14);
    color: #2f7a47;
    border: 1px solid rgba(98, 184, 128, 0.20);
}

.status-validated::before {
    background: #4fb06c;
}

.status-cancelled {
    background: rgba(212, 98, 98, 0.14);
    color: #a63d3d;
    border: 1px solid rgba(212, 98, 98, 0.20);
}

.status-cancelled::before {
    background: #cf5b5b;
}

.order-body {
    border-top: 1px solid rgba(200,116,138,0.12);
    border-bottom: 1px solid rgba(200,116,138,0.12);
    padding: 18px 0;
    margin-bottom: 18px;
}

.order-item {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 18px;
    align-items: center;
    padding: 12px 0;
    color: var(--text);
}

.order-item + .order-item {
    border-top: 1px solid rgba(200,116,138,0.08);
}

.order-item-name {
    font-size: 1.08rem;
    color: var(--text);
}

.order-item-meta {
    color: var(--text-light);
    font-size: 0.92rem;
}

.order-item-price {
    font-weight: 600;
    color: var(--rose-deep);
    font-size: 1rem;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.order-total-label {
    color: var(--text);
    font-weight: 600;
    font-size: 1rem;
}

.order-total {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    line-height: 1;
}

.order-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.order-mini-badge {
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(200,116,138,0.08);
    color: var(--rose-deep);
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 1px solid rgba(200,116,138,0.10);
}

.orders-empty {
    text-align: center;
    padding: 70px 30px;
    border-radius: 28px;
    background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(255,255,255,0.82));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: 0 18px 42px rgba(36,18,25,0.05);
    animation: fadeSlideUp 0.7s ease both;
}

.orders-empty-icon {
    font-size: 2.8rem;
    margin-bottom: 14px;
    color: var(--rose);
}

.orders-empty h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem;
    color: var(--text);
    margin-bottom: 10px;
}

.orders-empty p {
    color: var(--text-light);
    margin-bottom: 22px;
    line-height: 1.8;
}

.orders-empty a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    border-radius: 999px;
    text-decoration: none;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    font-size: 0.82rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.orders-empty a:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(200,116,138,0.20);
}

@keyframes pulseDot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.25); opacity: 0.65; }
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(18px);
        filter: blur(5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}

@media (max-width: 900px) {
    .orders-page {
        padding: 40px 22px 84px;
    }

    .orders-topbar {
        grid-template-columns: 1fr;
    }

    .order-head {
        flex-direction: column;
        align-items: flex-start;
    }

    .order-item {
        grid-template-columns: 1fr;
        gap: 6px;
    }

    .order-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

@php
    $ordersCollection = collect($orders ?? []);
    $pendingCount = $ordersCollection->where('status', 'pending')->count();
    $validatedCount = $ordersCollection->where('status', 'validated')->count();
    $cancelledCount = $ordersCollection->where('status', 'cancelled')->count();

    $statusMap = [
        'pending' => ['label' => 'En attente', 'class' => 'status-pending'],
        'validated' => ['label' => 'Validée', 'class' => 'status-validated'],
        'cancelled' => ['label' => 'Annulée', 'class' => 'status-cancelled'],
    ];
@endphp

<div class="orders-page">
    <div class="orders-hero">
        <div class="orders-kicker">Historique des commandes</div>
        <h1 class="orders-title">Mes commandes</h1>
        <p class="orders-subtitle">
            Retrouvez l’historique de vos achats, suivez leur statut et consultez rapidement les détails de chaque commande.
        </p>
    </div>

    <div class="orders-topbar">
        <div class="orders-stat">
            <div class="orders-stat-label">En attente</div>
            <div class="orders-stat-value">{{ $pendingCount }}</div>
        </div>

        <div class="orders-stat">
            <div class="orders-stat-label">Validées</div>
            <div class="orders-stat-value">{{ $validatedCount }}</div>
        </div>

        <div class="orders-stat">
            <div class="orders-stat-label">Annulées</div>
            <div class="orders-stat-value">{{ $cancelledCount }}</div>
        </div>
    </div>

    @if($ordersCollection->isEmpty())
        <div class="orders-empty">
            <div class="orders-empty-icon">✦</div>
            <h3>Aucune commande pour le moment</h3>
            <p>Vous n’avez pas encore passé de commande. Découvrez nos produits et commencez votre première expérience Glowi.</p>
            <a href="{{ route('products.index') }}">Voir le catalogue</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($ordersCollection as $index => $order)
                @php
                    $status = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'status-pending'];
                @endphp

                <div class="order-card" style="animation-delay: {{ $index * 0.08 }}s;">
                    <div class="order-head">
                        <div>
                            <div class="order-title">Commande #{{ $order->id }}</div>
                            <div class="order-date">
                                Passée le {{ optional($order->created_at)->format('d/m/Y à H:i') }}
                            </div>
                        </div>

                        <div class="order-status {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </div>
                    </div>

                    <div class="order-body">
                        @forelse($order->items as $item)
                            <div class="order-item">
                                <div>
                                    <div class="order-item-name">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                                    <div class="order-item-meta">Qté : {{ $item->quantity }}</div>
                                </div>

                                <div class="order-item-meta">
                                    {{ number_format($item->price ?? 0, 2) }} TND
                                </div>

                                <div class="order-item-price">
                                    {{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 2) }} TND
                                </div>
                            </div>
                        @empty
                            <div class="order-item">
                                <div class="order-item-name">Aucun article trouvé pour cette commande.</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="order-footer">
                        <div class="order-badges">
                            <span class="order-mini-badge">{{ $order->items->count() }} article(s)</span>
                            <a href="{{ route('orders.show', $order) }}" class="order-mini-badge" style="text-decoration:none;background:rgba(200,116,138,.13);color:var(--rose-deep);">📦 Voir détails</a>
                        </div>

                        @php $step = $order->delivery_step ?? 0; @endphp
                        <div style="flex:1;padding:0 20px;">
                            <div style="font-size:.62rem;color:var(--text-light);letter-spacing:.12em;text-transform:uppercase;margin-bottom:6px;">Livraison</div>
                            <div style="display:flex;align-items:center;gap:4px;">
                                @php $stepsLabel = ['Confirmée','Préparation','Prête','Collectée','En route','Livrée']; @endphp
                                @foreach($stepsLabel as $si => $sl)
                                    <div style="flex:1;height:4px;border-radius:999px;background:{{ $si <= $step ? 'linear-gradient(90deg,var(--rose),var(--gold))' : 'rgba(200,116,138,.12)' }};"></div>
                                @endforeach
                            </div>
                            <div style="font-size:.68rem;color:var(--rose-deep);margin-top:4px;">{{ $stepsLabel[$step] ?? 'Confirmée' }}</div>
                        </div>

                        <div>
                            <div class="order-total-label">Total</div>
                            <div class="order-total">{{ number_format($order->total ?? 0, 2) }} TND</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection