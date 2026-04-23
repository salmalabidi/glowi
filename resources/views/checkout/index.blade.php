@extends('layouts.app')

@section('content')
<style>
:root{--rose:#c8748a;--rose-deep:#a85070;--rose-pale:#f5e6ea;--text:#3d2030;--text-light:#7a5c68;--dark:#24131a;--line:rgba(200,116,138,.14)}
.checkout-page{max-width:1180px;margin:0 auto;padding:48px 28px 90px}.checkout-layout{display:grid;grid-template-columns:1.1fr .9fr;gap:28px}.checkout-card,.summary-card{background:#fff;border:1px solid var(--line);border-radius:24px;padding:28px;box-shadow:0 18px 40px rgba(36,19,26,.06)}
.checkout-title,.section-title{font-family:'Cormorant Garamond',serif;color:var(--text)}.checkout-title{font-size:3rem;margin-bottom:6px}.section-title{font-size:2rem;margin-bottom:18px}.checkout-subtitle{color:var(--text-light);margin-bottom:26px}.order-item{display:grid;grid-template-columns:84px 1fr auto;gap:16px;align-items:center;padding:14px 0;border-bottom:1px solid rgba(200,116,138,.10)}.order-thumb{width:84px;height:84px;border-radius:16px;background:var(--rose-pale);overflow:hidden;display:flex;align-items:center;justify-content:center}.order-thumb img{width:100%;height:100%;object-fit:contain;padding:8px}.item-name{font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--text)}.item-brand,.item-meta,.checkout-subtitle{font-size:.92rem;color:var(--text-light)}.item-price{font-weight:600;color:var(--rose-deep)}.method-card{margin-bottom:14px}.method-card input{display:none}.method-label{display:block;border:1.5px solid rgba(200,116,138,.18);border-radius:18px;padding:18px 18px 18px 54px;background:#fff;cursor:pointer;position:relative;transition:.25s}.method-label:before{content:'';position:absolute;left:18px;top:50%;transform:translateY(-50%);width:20px;height:20px;border-radius:50%;border:2px solid rgba(200,116,138,.45)}.method-label:after{content:'';position:absolute;left:24px;top:50%;transform:translateY(-50%) scale(0);width:10px;height:10px;background:var(--rose);border-radius:50%;transition:.2s}.method-card input:checked + .method-label{border-color:var(--rose);background:linear-gradient(180deg, rgba(245,230,234,.55), #fff)}.method-card input:checked + .method-label:after{transform:translateY(-50%) scale(1)}.method-title{font-size:1rem;font-weight:600;color:var(--text)}.method-desc,.online-note{color:var(--text-light);font-size:.9rem;line-height:1.6}.online-note{margin-top:16px;padding:14px 16px;border-radius:14px;background:rgba(200,116,138,.05);border:1px solid rgba(200,116,138,.10)}.summary-row,.summary-total{display:flex;justify-content:space-between}.summary-row{color:var(--text-light);margin-bottom:12px}.summary-total{padding-top:18px;margin-top:18px;border-top:1px solid rgba(200,116,138,.14);font-size:1.2rem;font-weight:600;color:var(--text)}.confirm-btn{width:100%;margin-top:22px;border:none;border-radius:14px;background:linear-gradient(135deg,var(--rose),var(--rose-deep));color:#fff;padding:16px 18px;font-size:.84rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase}.flash{padding:14px 16px;border-radius:12px;margin-bottom:18px}.flash-success{background:rgba(79,176,108,.12);color:#287944}.flash-error{background:rgba(200,70,70,.08);color:#a33e52}.badges{display:flex;gap:8px;justify-content:flex-end}.badge-pay{padding:5px 10px;border-radius:999px;font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;background:rgba(200,116,138,.08);color:var(--rose-deep);border:1px solid rgba(200,116,138,.16)}@media(max-width:920px){.checkout-layout{grid-template-columns:1fr}.checkout-title{font-size:2.4rem}}
</style>
<div class="checkout-page">
    <h1 class="checkout-title">Paiement</h1>
    <p class="checkout-subtitle">Choisissez votre méthode de paiement et validez votre commande en toute sécurité.</p>
    <div class="checkout-layout">
        <div class="checkout-card">
            @if(session('success'))<div class="flash flash-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="flash flash-error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
            <h2 class="section-title">Articles</h2>
            @foreach($cart as $item)
                <div class="order-item">
                    <div class="order-thumb"><img src="{{ $item['image'] ? asset('storage/'.$item['image']) : 'https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi' }}" alt="{{ $item['name'] }}"></div>
                    <div>
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-brand">{{ $item['brand'] ?? 'Glowi' }}</div>
                        <div class="item-meta">Qté : {{ $item['quantity'] }} · PU : {{ number_format($item['price'], 2) }} TND</div>
                    </div>
                    <div class="item-price">{{ number_format($item['subtotal'], 2) }} TND</div>
                </div>
            @endforeach
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:28px;padding-bottom:14px;border-bottom:1px solid rgba(200,116,138,.12)">
                <div class="section-title" style="font-size:1.8rem;margin:0">Paiement</div>
                <div class="badges"><span class="badge-pay">Cash</span><span class="badge-pay">Card demo</span><span class="badge-pay">SSL</span></div>
            </div>
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <div class="method-card">
                    <input type="radio" name="payment_method" id="cash" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                    <label class="method-label" for="cash">
                        <div class="method-title">Paiement à la livraison</div>
                        <div class="method-desc">CASH    </div>
                    </label>
                </div>
                <div class="method-card">
                    <input type="radio" name="payment_method" id="online_demo" value="online_demo" {{ old('payment_method') === 'online_demo' ? 'checked' : '' }}>
                    <label class="method-label" for="online_demo">
                        <div class="method-title"> Paiement en ligne </div>
                        <div class="method-desc">ONLINE</div>
                    </label>
                </div>
            
                <button type="submit" class="confirm-btn">Confirmer la commande</button>
            </form>
        </div>
        <div class="summary-card">
            <h2 class="section-title">Résumé de la commande</h2>
            @foreach($cart as $item)
                <div class="summary-row"><span>{{ $item['name'] }} × {{ $item['quantity'] }}</span><span>{{ number_format($item['subtotal'], 2) }} TND</span></div>
            @endforeach
            <div class="summary-row"><span>Sous-total</span><span>{{ number_format($total, 2) }} TND</span></div>
            <div class="summary-row"><span>Livraison</span><span>Gratuite</span></div>
            <div class="summary-total"><span>Total</span><span>{{ number_format($total, 2) }} TND</span></div>
        </div>
    </div>
</div>
@endsection
