@extends('layouts.app')

@section('content')

<style>
:root {
    --rose: #c8748a;
    --rose-deep: #a85070;
    --rose-pale: #f5e6ea;
    --rose-soft: #f8edf1;
    --gold: #c9a96e;
    --cream: #fdf6f0;
    --dark: #1a0f14;
    --text: #3d2030;
    --text-light: #7a5c68;
    --line: rgba(200,116,138,0.14);
    --shadow-soft: 0 18px 45px rgba(36,18,25,0.08);
    --shadow-premium: 0 24px 60px rgba(36,18,25,0.12);
}

/* ── HERO ─────────────────────────────────────────────────────────── */
.wish-hero {
    position: relative; overflow: hidden;
    padding: 78px 80px 58px;
    min-height: 220px;
    display: flex; align-items: flex-end;
    isolation: isolate;
    background:
        radial-gradient(circle at 12% 22%, rgba(255,255,255,0.07), transparent 22%),
        radial-gradient(circle at 86% 30%, rgba(200,116,138,0.18), transparent 28%),
        linear-gradient(120deg, #170b11 0%, #241019 38%, #2a121d 100%);
}

.wish-hero::before {
    content: ''; position: absolute; inset: 0;
    background:
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: linear-gradient(to bottom, rgba(0,0,0,0.35), transparent 90%);
    pointer-events: none; z-index: -1;
}

.wish-hero-inner {
    max-width: 1240px; width: 100%; margin: 0 auto;
    display: flex; justify-content: space-between;
    align-items: flex-end; gap: 32px;
}

.wish-kicker {
    display: inline-flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,0.72);
    font-size: 0.72rem; letter-spacing: 0.22em; text-transform: uppercase;
    margin-bottom: 14px;
}

.wish-kicker::before {
    content: ''; width: 34px; height: 1px;
    background: linear-gradient(90deg, var(--rose), var(--gold));
}

.wish-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.6rem, 4.5vw, 4.2rem);
    font-weight: 300; color: #fff;
    line-height: 1.02; letter-spacing: -0.02em;
}

.wish-title em { color: #e194ab; font-style: italic; font-weight: 400; }

.wish-subtitle {
    margin-top: 14px;
    color: rgba(255,255,255,0.55);
    font-size: 0.92rem; line-height: 1.8; max-width: 560px;
}

.wish-count-pill {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; margin-top: 20px;
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 999px;
    background: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.80);
    font-size: 0.72rem; letter-spacing: 0.14em; text-transform: uppercase;
    backdrop-filter: blur(10px);
}

.wish-count-pill strong { color: #fff; font-weight: 600; }

/* ── BODY ─────────────────────────────────────────────────────────── */
.wish-body {
    max-width: 1280px; margin: 0 auto;
    padding: 52px 56px 100px;
}

/* ── EMPTY STATE ──────────────────────────────────────────────────── */
.wish-empty {
    text-align: center;
    padding: 90px 24px;
    border-radius: 28px;
    background: linear-gradient(180deg, rgba(255,255,255,0.80), rgba(255,255,255,0.64));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: var(--shadow-soft);
    animation: fadeUp 0.7s ease both;
}

.wish-empty .empty-icon {
    font-size: 3.5rem; color: var(--rose);
    margin-bottom: 20px;
    display: inline-block;
    animation: heartBeat 2.4s ease-in-out infinite;
}

@keyframes heartBeat {
    0%,100% { transform: scale(1); }
    14%     { transform: scale(1.18); }
    28%     { transform: scale(1); }
    42%     { transform: scale(1.12); }
    70%     { transform: scale(1); }
}

.wish-empty h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem; font-weight: 300;
    color: var(--text); margin-bottom: 10px;
}

.wish-empty p {
    color: var(--text-light); font-size: 0.92rem;
    line-height: 1.8; max-width: 380px; margin: 0 auto 28px;
}

.btn-discover {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; border-radius: 999px;
    font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase;
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 12px 28px rgba(200,116,138,0.22);
}

.btn-discover:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(200,116,138,0.30);
}

/* ── GRID ─────────────────────────────────────────────────────────── */
.wish-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 28px;
}

/* ── CARD ─────────────────────────────────────────────────────────── */
.wish-card {
    position: relative; overflow: hidden;
    border-radius: 24px;
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,255,255,0.94));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: var(--shadow-soft);
    transition: transform 0.38s ease, box-shadow 0.38s ease, border-color 0.32s ease;
    animation: fadeUp 0.55s ease both;
}

.wish-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-premium);
    border-color: rgba(200,116,138,0.24);
}

/* Image */
.wish-img-wrap {
    position: relative; aspect-ratio: 4/5; overflow: hidden;
    background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.65), transparent 30%),
                linear-gradient(180deg, #fbf1f4 0%, #f6e7eb 100%);
}

.wish-img-wrap img {
    width: 100%; height: 100%;
    object-fit: contain; padding: 22px;
    transition: transform 0.6s ease;
}

.wish-card:hover .wish-img-wrap img { transform: scale(1.07); }

/* Overlay */
.wish-overlay {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    opacity: 0;
    background: linear-gradient(180deg, rgba(26,15,20,0.08), rgba(26,15,20,0.55));
    transition: opacity 0.35s ease;
}

.wish-card:hover .wish-overlay { opacity: 1; }

.overlay-btn {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 10px 18px; border-radius: 999px;
    background: rgba(255,255,255,0.96);
    color: var(--dark); text-decoration: none; border: none;
    font-family: 'Jost', sans-serif; font-size: 0.68rem;
    letter-spacing: 0.16em; text-transform: uppercase;
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.overlay-btn:hover {
    background: var(--rose); color: #fff;
    transform: translateY(-2px);
}

.overlay-btn.danger:hover {
    background: #c0392b; color: #fff;
}

/* Info */
.wish-info { padding: 18px 18px 20px; }

.wish-cat {
    font-size: 0.60rem; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--rose); margin-bottom: 6px;
}

.wish-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.22rem; font-weight: 400;
    color: var(--text); line-height: 1.25; margin-bottom: 3px;
    transition: color 0.28s ease;
}

.wish-card:hover .wish-name { color: var(--rose-deep); }

.wish-brand { color: var(--text-light); font-size: 0.74rem; margin-bottom: 14px; }

.wish-footer {
    display: flex; align-items: center;
    justify-content: space-between; gap: 10px;
}

.wish-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.32rem; font-weight: 500;
    color: var(--rose-deep);
}

.add-cart-btn {
    flex: 1; padding: 10px 14px;
    border: none; border-radius: 999px;
    background: linear-gradient(135deg, var(--rose-pale), #fff);
    color: var(--rose); font-family: 'Jost', sans-serif;
    font-size: 0.66rem; letter-spacing: 0.14em; text-transform: uppercase;
    transition: transform 0.25s ease, background 0.25s ease,
                color 0.25s ease, box-shadow 0.25s ease;
}

.add-cart-btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    box-shadow: 0 10px 22px rgba(200,116,138,0.20);
}

/* Remove badge */
.remove-badge {
    position: absolute; top: 14px; right: 14px;
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.92);
    border: 1px solid rgba(200,116,138,0.14);
    display: flex; align-items: center; justify-content: center;
    color: var(--rose); font-size: 0.8rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.25s ease, background 0.25s ease,
                color 0.25s ease, border-color 0.25s ease;
    text-decoration: none;
    z-index: 2;
}

.remove-badge:hover {
    transform: scale(1.12);
    background: #c0392b; color: #fff;
    border-color: #c0392b;
}

/* ── ACTIONS BAR ──────────────────────────────────────────────────── */
.wish-actions {
    display: flex; align-items: center;
    justify-content: space-between; gap: 16px;
    margin-bottom: 32px;
}

.wish-actions-right { display: flex; gap: 12px; }

.btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px;
    border: 1px solid rgba(200,116,138,0.24);
    border-radius: 999px; background: transparent;
    color: var(--rose-deep); font-family: 'Jost', sans-serif;
    font-size: 0.70rem; letter-spacing: 0.14em; text-transform: uppercase;
    text-decoration: none;
    transition: background 0.25s ease, border-color 0.25s ease,
                transform 0.25s ease, box-shadow 0.25s ease;
}

.btn-outline:hover {
    background: rgba(200,116,138,0.07);
    border-color: rgba(200,116,138,0.40);
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(200,116,138,0.10);
}

/* ── RESPONSIVE ───────────────────────────────────────────────────── */
@media (max-width: 1180px) {
    .wish-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 860px) {
    .wish-hero { padding: 60px 24px 44px; }
    .wish-body  { padding: 36px 24px 80px; }
    .wish-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
}

@media (max-width: 520px) {
    .wish-grid { grid-template-columns: 1fr; }
    .wish-title { font-size: 2.2rem; }
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

{{-- ── HERO ──────────────────────────────────────────────────────────── --}}
<div class="wish-hero">
    <div class="wish-hero-inner">
        <div>
            <div class="wish-kicker">Votre sélection</div>
            <h1 class="wish-title">Ma liste de <em>souhaits</em></h1>
            <p class="wish-subtitle">Les produits qui ont capturé votre cœur — retrouvez-les ici, prêts à rejoindre votre routine.</p>
            <div class="wish-count-pill">
                <strong>{{ $items->count() }}</strong> produit{{ $items->count() > 1 ? 's' : '' }} enregistré{{ $items->count() > 1 ? 's' : '' }}
            </div>
        </div>
    </div>
</div>

{{-- ── BODY ──────────────────────────────────────────────────────────── --}}
<div class="wish-body">

    @if($items->isEmpty())

        {{-- EMPTY STATE --}}
        <div class="wish-empty">
            <div class="empty-icon">♡</div>
            <h2>Votre liste est vide</h2>
            <p>Parcourez notre catalogue et ajoutez vos produits préférés en cliquant sur ♡</p>
            <a href="{{ route('products.index') }}" class="btn-discover">
                ✦ Découvrir le catalogue
            </a>
        </div>

    @else

        {{-- ACTIONS --}}
        <div class="wish-actions">
            <p style="color:var(--text-light);font-size:0.84rem;">
                {{ $items->count() }} produit{{ $items->count() > 1 ? 's' : '' }} dans votre liste
            </p>
            <div class="wish-actions-right">
                <a href="{{ route('products.index') }}" class="btn-outline">
                    ✦ Continuer mes achats
                </a>
            </div>
        </div>

        {{-- GRID --}}
        <div class="wish-grid">
            @foreach($items as $index => $wishItem)
                @php $product = $wishItem->product; @endphp
                <div class="wish-card" style="animation-delay: {{ $index * 0.06 }}s">

                    {{-- Bouton supprimer --}}
                    <form action="{{ route('wishlist.remove', $wishItem) }}" method="POST" style="display:contents">
                        @csrf @method('DELETE')
                        <button type="submit" class="remove-badge" title="Retirer de la wishlist">✕</button>
                    </form>

                    {{-- Image --}}
                    <div class="wish-img-wrap">
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            onerror="this.src='https://via.placeholder.com/400x500/f5e6ea/c8748a?text={{ urlencode($product->name) }}'"
                        >
                        <div class="wish-overlay">
                            <a href="{{ route('products.show', $product) }}" class="overlay-btn">Voir</a>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="wish-info">
                        <div class="wish-cat">
                            {{ $product->category->name ?? '' }}
                            {{ $product->product_type ? '— ' . $product->product_type : '' }}
                        </div>
                        <div class="wish-name">{{ $product->name }}</div>
                        <div class="wish-brand">{{ $product->brand }}</div>

                        <div class="wish-footer">
                            <div class="wish-price">{{ number_format($product->price, 2) }} TND</div>
                            <button
                                class="add-cart-btn"
                                onclick="addToCart({{ $product->id }}, this)"
                            >
                                + Panier
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
</div>

@endsection

@section('scripts')
<script>
function addToCart(productId, btn) {
    const original = btn.textContent;
    btn.textContent = '…';

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = '✓ Ajouté';
        btn.style.background = 'linear-gradient(135deg, var(--rose), var(--rose-deep))';
        btn.style.color = '#fff';

        if (typeof window.updateCartBadge === 'function') {
            window.updateCartBadge(data.count);
        }

        setTimeout(() => {
            btn.textContent = original;
            btn.style.background = '';
            btn.style.color = '';
        }, 1800);
    })
    .catch(() => { btn.textContent = original; });
}
</script>
@endsection