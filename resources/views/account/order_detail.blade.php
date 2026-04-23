@extends('layouts.app')

@section('content')
<style>
.od-page { max-width:900px; margin:0 auto; padding:52px 32px 100px; }
.od-back { display:inline-flex; align-items:center; gap:6px; color:var(--rose); font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:28px; transition:gap .2s; }
.od-back:hover { gap:10px; }
.od-title { font-family:'Cormorant Garamond',serif; font-size:clamp(2.2rem,4vw,3.2rem); color:var(--text); font-weight:400; margin-bottom:6px; }
.od-meta { color:var(--text-light); font-size:.85rem; margin-bottom:32px; }
.od-card { background:#fff; border:1px solid rgba(200,116,138,.12); border-radius:22px; padding:28px; box-shadow:0 12px 32px rgba(36,18,25,.06); margin-bottom:20px; animation:fadeSlideUp .6s ease both; }
.od-card-title { font-size:.70rem; letter-spacing:.18em; text-transform:uppercase; color:var(--rose-deep); margin-bottom:18px; }
.od-item { display:flex; align-items:center; gap:16px; padding:12px 0; border-bottom:1px solid rgba(200,116,138,.08); }
.od-item:last-child { border-bottom:none; }
.od-item-img { width:60px; height:60px; object-fit:cover; border-radius:10px; background:rgba(200,116,138,.08); }
.od-item-img-placeholder { width:60px; height:60px; border-radius:10px; background:rgba(200,116,138,.08); display:flex; align-items:center; justify-content:center; font-size:1.4rem; flex-shrink:0; }
.od-item-info { flex:1; }
.od-item-name { font-weight:500; color:var(--text); margin-bottom:3px; }
.od-item-brand { font-size:.75rem; color:var(--text-light); }
.od-item-price { font-family:'Cormorant Garamond',serif; font-size:1.1rem; color:var(--rose-deep); white-space:nowrap; }
.od-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid rgba(200,116,138,.07); font-size:.9rem; }
.od-row:last-child { border-bottom:none; font-weight:600; font-size:1rem; }
.od-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; font-weight:600; }
.od-badge-pending   { background:rgba(201,169,110,.15); color:#8a6a20; }
.od-badge-confirmed { background:rgba(80,160,100,.13);  color:#2a7a40; }
.od-badge-delivered { background:rgba(80,100,200,.12);  color:#2040a0; }
.od-badge-cancelled { background:rgba(200,80,80,.12);   color:#a03030; }
.od-progress { display:flex; align-items:center; gap:4px; margin-top:12px; }
.od-step { flex:1; height:5px; border-radius:99px; background:rgba(200,116,138,.10); }
.od-step.active { background:linear-gradient(90deg,var(--rose),var(--gold)); }
.od-step-label { font-size:.68rem; color:var(--rose-deep); margin-top:6px; }
@keyframes fadeSlideUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
</style>

<div class="od-page">
    <a href="{{ route('orders') }}" class="od-back">← Mes commandes</a>
    <h1 class="od-title">Commande #{{ $order->id }}</h1>
    <p class="od-meta">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>

    {{-- Statut & livraison --}}
    <div class="od-card">
        <div class="od-card-title">Statut</div>
        @php
            $statusMap = ['pending'=>'En attente','confirmed'=>'Confirmée','delivered'=>'Livrée','cancelled'=>'Annulée'];
            $badgeMap  = ['pending'=>'pending','confirmed'=>'confirmed','delivered'=>'delivered','cancelled'=>'cancelled'];
            $stepsLabel = ['Confirmée','Préparation','Prête','Collectée','En route','Livrée'];
            $step = $order->delivery_step ?? 0;
        @endphp
        <span class="od-badge od-badge-{{ $badgeMap[$order->status] ?? 'pending' }}">
            {{ $statusMap[$order->status] ?? $order->status }}
        </span>
        <div class="od-progress" style="margin-top:16px;">
            @foreach($stepsLabel as $si => $sl)
                <div class="od-step {{ $si <= $step ? 'active' : '' }}"></div>
            @endforeach
        </div>
        <div class="od-step-label">{{ $stepsLabel[$step] ?? 'Confirmée' }}</div>
    </div>

    {{-- Articles --}}
    <div class="od-card" style="animation-delay:.08s">
        <div class="od-card-title">Articles commandés</div>
        @foreach($order->items as $item)
            <div class="od-item">
                @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name ?? '' }}" class="od-item-img">
                @else
                    <div class="od-item-img-placeholder">🛍</div>
                @endif
                <div class="od-item-info">
                    <div class="od-item-name">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                    <div class="od-item-brand">Qté : {{ $item->quantity }} · {{ number_format($item->price,2) }} TND / unité</div>
                </div>
                <div class="od-item-price">{{ number_format($item->subtotal,2) }} TND</div>
            </div>
        @endforeach
    </div>

    {{-- Récapitulatif --}}
    <div class="od-card" style="animation-delay:.16s">
        <div class="od-card-title">Récapitulatif</div>
        <div class="od-row"><span>Sous-total</span><span>{{ number_format($order->total,2) }} TND</span></div>
        <div class="od-row"><span>Livraison</span><span>Offerte</span></div>
        <div class="od-row"><span>Total payé</span><span>{{ number_format($order->total,2) }} TND</span></div>
    </div>
</div>
@endsection
