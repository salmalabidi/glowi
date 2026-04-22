@extends('layouts.app')

@section('content')

<style>
:root {
    --rose: #c8748a;
    --rose-deep: #a85070;
    --rose-pale: #f5e6ea;
    --gold: #c9a96e;
    --cream: #fdf6f0;
    --dark: #1a0f14;
    --text: #3d2030;
    --text-light: #7a5c68;
}

.show-wrap {
    max-width: 1200px; margin: 0 auto;
    padding: 60px 48px 100px;
}
.breadcrumb {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 48px;
    font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase;
}
.breadcrumb a { color: var(--text-light); text-decoration: none; transition: color 0.2s; }
.breadcrumb a:hover { color: var(--rose); }
.breadcrumb span { color: rgba(60,30,40,0.3); }
.breadcrumb .current { color: var(--rose); }

.product-layout {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: start;
}

/* IMAGE SIDE */
.product-image-side { position: sticky; top: 90px; }
.product-main-img {
    background: var(--rose-pale);
    border-radius: 4px; overflow: hidden;
    aspect-ratio: 4/5;
    position: relative;
}
.product-main-img img {
    width: 100%; height: 100%;
    object-fit: contain; padding: 40px;
    transition: transform 0.5s ease;
}
.product-main-img:hover img { transform: scale(1.05); }
.product-main-img .category-badge {
    position: absolute; top: 20px; left: 20px;
    background: var(--rose);
    color: #fff; font-size: 0.58rem; letter-spacing: 0.15em;
    text-transform: uppercase; padding: 5px 12px; border-radius: 2px;
}

/* INFO SIDE */
.product-info-side {}
.product-cat-tag {
    font-size: 0.62rem; letter-spacing: 0.28em; text-transform: uppercase;
    color: var(--rose); margin-bottom: 12px;
}
.product-show-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 3vw, 2.8rem);
    font-weight: 300; line-height: 1.15;
    color: var(--text); margin-bottom: 8px;
}
.product-show-brand {
    font-size: 0.8rem; color: var(--text-light);
    margin-bottom: 24px; letter-spacing: 0.08em;
}
.product-show-brand span { color: var(--gold); font-weight: 500; }
.divider {
    height: 1px; background: rgba(200,116,138,0.15);
    margin: 28px 0;
}
.product-show-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.6rem; font-weight: 400;
    color: var(--rose-deep);
}
.product-show-price small {
    font-size: 1rem; font-weight: 300; color: var(--text-light);
    vertical-align: middle;
}

.product-show-desc {
    font-size: 0.88rem; line-height: 1.85;
    color: var(--text-light);
    margin-bottom: 32px;
}

/* STOCK */
.stock-indicator {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 32px; font-size: 0.78rem;
}
.stock-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #6dbf8a;
}
.stock-dot.low { background: var(--gold); }
.stock-dot.out { background: #e07070; }
.stock-text { color: var(--text-light); }

/* QUANTITY + ADD TO CART */
.purchase-row {
    display: flex; gap: 12px; align-items: center;
    margin-bottom: 20px;
}
.qty-control {
    display: flex; align-items: center; gap: 0;
    border: 1px solid rgba(200,116,138,0.25);
    border-radius: 2px; overflow: hidden;
}
.qty-btn {
    width: 42px; height: 52px;
    background: none; border: none; cursor: none;
    font-size: 1.2rem; color: var(--text);
    transition: background 0.2s;
    display: flex; align-items: center; justify-content: center;
}
.qty-btn:hover { background: var(--rose-pale); }
.qty-display {
    width: 48px; text-align: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; color: var(--text);
    border: none; background: none;
    outline: none;
}
.btn-add-cart {
    flex: 1; padding: 16px 24px;
    background: var(--rose); color: #fff; border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.7rem; letter-spacing: 0.2em; text-transform: uppercase;
    cursor: none; border-radius: 2px;
    transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
}
.btn-add-cart:hover {
    background: var(--rose-deep);
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(200,116,138,0.35);
}
.btn-add-cart:disabled { background: #ccc; transform: none; box-shadow: none; }
.btn-wishlist {
    width: 52px; height: 52px; border-radius: 2px;
    border: 1px solid rgba(200,116,138,0.3);
    background: none; cursor: none; font-size: 1.2rem;
    color: var(--rose); transition: background 0.2s, color 0.2s;
}
.btn-wishlist:hover { background: var(--rose); color: #fff; }
.btn-login-prompt {
    display: flex; align-items: center; gap: 10px;
    background: var(--rose-pale); padding: 16px 20px;
    border-radius: 2px; border: 1px dashed rgba(200,116,138,0.4);
    margin-bottom: 20px; font-size: 0.8rem; color: var(--text-light);
}
.btn-login-prompt a { color: var(--rose); font-weight: 500; text-decoration: none; }

/* PRODUCT DETAILS LIST */
.product-details-list {
    list-style: none; margin: 24px 0;
}
.product-details-list li {
    display: flex; justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(200,116,138,0.1);
    font-size: 0.8rem;
}
.product-details-list li .label { color: var(--text-light); }
.product-details-list li .value { color: var(--text); font-weight: 400; }

/* RELATED */
.related-section {
    padding: 80px 48px; max-width: 1200px; margin: 0 auto;
    border-top: 1px solid rgba(200,116,138,0.15);
}
.related-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem; font-weight: 300;
    margin-bottom: 36px; color: var(--text);
}
.related-title em { color: var(--rose); font-style: italic; }
.related-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
}
.related-card {
    cursor: none; text-decoration: none; color: inherit;
    transition: transform 0.3s;
}
.related-card:hover { transform: translateY(-4px); }
.related-card-img {
    background: var(--rose-pale); border-radius: 4px;
    aspect-ratio: 1; overflow: hidden; margin-bottom: 12px;
}
.related-card-img img {
    width: 100%; height: 100%; object-fit: contain;
    padding: 16px; transition: transform 0.4s;
}
.related-card:hover .related-card-img img { transform: scale(1.06); }
.related-card-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem; color: var(--text); margin-bottom: 4px;
}
.related-card-price { font-size: 0.82rem; color: var(--rose-deep); }

/* ══════════════════════════════════════════
   SECTION ÉVALUATIONS
══════════════════════════════════════════ */
.reviews-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 48px 100px;
}

.reviews-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 300;
    color: var(--text); margin-bottom: 8px;
}
.reviews-section-title em { color: var(--rose); font-style: italic; }

/* RÉSUMÉ GLOBAL */
.reviews-summary {
    display: flex;
    align-items: center;
    gap: 32px;
    padding: 28px 32px;
    background: linear-gradient(135deg, rgba(245,230,234,0.5), rgba(253,246,240,0.8));
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 16px;
    margin: 24px 0 40px;
}
.reviews-avg-score {
    font-family: 'Cormorant Garamond', serif;
    font-size: 4rem; font-weight: 300;
    color: var(--rose-deep);
    line-height: 1;
}
.reviews-avg-right { display: flex; flex-direction: column; gap: 6px; }
.reviews-stars-display { display: flex; gap: 3px; }
.star-filled { color: var(--gold); font-size: 1.2rem; }
.star-empty  { color: rgba(200,116,138,0.25); font-size: 1.2rem; }
.reviews-count-label {
    font-size: 0.78rem;
    color: var(--text-light);
    letter-spacing: 0.06em;
}

/* BARRE DE PROGRESSION PAR NOTE */
.reviews-bars { flex: 1; display: flex; flex-direction: column; gap: 7px; }
.review-bar-row {
    display: flex; align-items: center; gap: 10px;
    font-size: 0.72rem; color: var(--text-light);
}
.review-bar-label { width: 14px; text-align: right; flex-shrink: 0; }
.review-bar-track {
    flex: 1; height: 6px;
    background: rgba(200,116,138,0.12);
    border-radius: 999px; overflow: hidden;
}
.review-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--rose), var(--gold));
    border-radius: 999px;
    transition: width 0.6s ease;
}
.review-bar-count { width: 20px; text-align: right; flex-shrink: 0; }

/* FORMULAIRE AVIS */
.review-form-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.14);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 40px;
    box-shadow: 0 8px 28px rgba(36,18,25,0.05);
}
.review-form-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; font-weight: 400;
    color: var(--text); margin-bottom: 20px;
}
.star-picker {
    display: flex; gap: 6px;
    margin-bottom: 20px;
}
.star-picker input[type=radio] { display: none; }
.star-picker label {
    font-size: 1.8rem;
    color: rgba(200,116,138,0.25);
    cursor: none;
    transition: color 0.15s, transform 0.15s;
    line-height: 1;
}
.star-picker label:hover,
.star-picker label:hover ~ label,
.star-picker input[type=radio]:checked ~ label { color: rgba(200,116,138,0.25); }
/* RTL trick pour les étoiles */
.star-picker { flex-direction: row-reverse; justify-content: flex-end; }
.star-picker label:hover,
.star-picker label:hover ~ label { color: var(--gold); transform: scale(1.12); }
.star-picker input[type=radio]:checked ~ label,
.star-picker input[type=radio]:checked + label { color: var(--gold); }

/* Hover complet avec CSS pur */
.star-picker:has(label:hover) label { color: rgba(200,116,138,0.25); }
.star-picker label:hover,
.star-picker label:hover ~ label { color: var(--gold) !important; }
.star-picker:has(input:checked) label { color: rgba(200,116,138,0.25); }
.star-picker input:checked ~ label { color: var(--gold) !important; }

.review-textarea {
    width: 100%;
    min-height: 110px;
    padding: 14px 18px;
    border: 1px solid rgba(200,116,138,0.22);
    border-radius: 10px;
    font-family: 'Jost', sans-serif;
    font-size: 0.88rem;
    color: var(--text);
    background: var(--cream);
    outline: none;
    resize: vertical;
    transition: border-color 0.3s, box-shadow 0.3s;
    margin-bottom: 16px;
}
.review-textarea:focus {
    border-color: rgba(200,116,138,0.46);
    box-shadow: 0 0 0 4px rgba(200,116,138,0.08);
    background: #fff;
}
.review-textarea::placeholder { color: rgba(122,92,104,0.45); }

.btn-submit-review {
    padding: 13px 32px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; border: none; border-radius: 999px;
    font-family: 'Jost', sans-serif;
    font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase;
    cursor: none;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 8px 24px rgba(200,116,138,0.22);
}
.btn-submit-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px rgba(200,116,138,0.32);
}

/* ALERT */
.review-alert {
    padding: 14px 18px;
    border-radius: 10px;
    font-size: 0.82rem;
    margin-bottom: 20px;
}
.review-alert.success {
    background: rgba(109,191,138,0.12);
    border: 1px solid rgba(109,191,138,0.3);
    color: #2d6e4a;
}
.review-alert.error {
    background: rgba(224,112,112,0.10);
    border: 1px solid rgba(224,112,112,0.28);
    color: #8b2020;
}
.review-alert-login {
    background: var(--rose-pale);
    border: 1px dashed rgba(200,116,138,0.4);
    padding: 18px 22px;
    border-radius: 12px;
    font-size: 0.84rem;
    color: var(--text-light);
    margin-bottom: 32px;
}
.review-alert-login a { color: var(--rose); font-weight: 500; text-decoration: none; }

/* LISTE DES AVIS */
.reviews-list { display: flex; flex-direction: column; gap: 20px; }

.review-card {
    background: #fff;
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 14px;
    padding: 24px 28px;
    box-shadow: 0 4px 16px rgba(36,18,25,0.04);
    transition: box-shadow 0.3s;
    animation: reviewIn 0.5s ease both;
}
@keyframes reviewIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.review-card:hover { box-shadow: 0 8px 28px rgba(200,116,138,0.10); }

.review-header {
    display: flex; justify-content: space-between;
    align-items: flex-start; gap: 16px;
    margin-bottom: 14px;
}
.review-user-info { display: flex; align-items: center; gap: 12px; }
.review-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--gold));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.9rem; font-weight: 600;
    flex-shrink: 0;
    overflow: hidden;
}
.review-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.review-user-name {
    font-size: 0.88rem; font-weight: 500;
    color: var(--text); line-height: 1.2;
}
.review-date {
    font-size: 0.7rem; color: var(--text-light);
    margin-top: 2px; letter-spacing: 0.04em;
}
.review-stars { display: flex; gap: 2px; flex-shrink: 0; }
.review-stars .s { font-size: 0.95rem; }
.review-stars .s.on  { color: var(--gold); }
.review-stars .s.off { color: rgba(200,116,138,0.2); }

.review-comment {
    font-size: 0.88rem; line-height: 1.75;
    color: var(--text-light);
}
.review-comment.no-comment {
    font-style: italic;
    color: rgba(122,92,104,0.45);
}

.review-delete-btn {
    background: none; border: none;
    color: rgba(200,116,138,0.45); font-size: 0.72rem;
    letter-spacing: 0.08em; text-transform: uppercase;
    cursor: none; padding: 4px 8px;
    border-radius: 4px;
    transition: color 0.2s, background 0.2s;
    flex-shrink: 0;
    align-self: flex-start;
    margin-top: 2px;
}
.review-delete-btn:hover { color: #c0392b; background: rgba(192,57,43,0.07); }

.reviews-empty {
    text-align: center;
    padding: 48px 24px;
    border: 1px dashed rgba(200,116,138,0.2);
    border-radius: 14px;
    color: var(--text-light);
    font-size: 0.88rem;
}
.reviews-empty .empty-icon { font-size: 2.4rem; margin-bottom: 12px; display: block; }

/* ANIMATIONS */
.slide-in-left  { animation: slideLeft  0.7s ease both; }
.slide-in-right { animation: slideRight 0.7s ease 0.15s both; }
@keyframes slideLeft  { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideRight { from { opacity: 0; transform: translateX(30px);  } to { opacity: 1; transform: translateX(0); } }
</style>

<div class="show-wrap">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a>
        <span>›</span>
        <a href="{{ route('products.index') }}">Catalogue</a>
        <span>›</span>
        @if($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            <span>›</span>
        @endif
        <span class="current">{{ $product->name }}</span>
    </div>

    <div class="product-layout">
        <!-- IMAGE -->
        <div class="product-image-side slide-in-left">
            <div class="product-main-img">
                @if($product->category)
                    <span class="category-badge">{{ $product->category->name }}</span>
                @endif
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    onerror="this.src='https://via.placeholder.com/600x750/f5e6ea/c8748a?text={{ urlencode($product->name) }}'">
            </div>
        </div>

        <!-- INFO -->
        <div class="product-info-side slide-in-right">
            <div class="product-cat-tag">✦ {{ $product->category->name ?? 'Beauté' }} — {{ $product->product_type ?? '' }}</div>
            <h1 class="product-show-title">{{ $product->name }}</h1>
            <div class="product-show-brand">par <span>{{ $product->brand }}</span></div>

            {{-- Note moyenne inline --}}
            @if($reviews->count() > 0)
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                @php $avg = round($reviews->avg('rating'), 1); @endphp
                <div style="display:flex;gap:2px;">
                    @for($i=1;$i<=5;$i++)
                        <span style="font-size:0.9rem;color:{{ $i <= round($avg) ? '#c9a96e' : 'rgba(200,116,138,0.2)' }}">★</span>
                    @endfor
                </div>
                <span style="font-size:0.78rem;color:var(--text-light)">{{ $avg }}/5 · {{ $reviews->count() }} avis</span>
            </div>
            @endif

            <div class="divider"></div>

            <div class="product-show-price">
                {{ number_format($product->price, 2) }}
                <small>TND</small>
            </div>

            <div class="divider"></div>

            <p class="product-show-desc">{{ $product->description }}</p>

            <!-- Stock -->
            <div class="stock-indicator">
                <div class="stock-dot {{ $product->stock <= 5 ? 'low' : ($product->stock == 0 ? 'out' : '') }}"></div>
                <span class="stock-text">
                    @if($product->stock == 0)
                        Rupture de stock
                    @elseif($product->stock <= 5)
                        Presque épuisé — {{ $product->stock }} restants
                    @else
                        En stock ({{ $product->stock }} disponibles)
                    @endif
                </span>
            </div>

            <!-- Add to cart -->
            @auth
                @if($product->stock > 0)
                    <div class="purchase-row">
                        <div class="qty-control">
                            <button class="qty-btn" onclick="changeQty(-1)">−</button>
                            <input class="qty-display" type="number" id="qty" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="qty-btn" onclick="changeQty(1)">+</button>
                        </div>
                        <button class="btn-add-cart" id="add-btn" onclick="addToCart({{ $product->id }})">
                            Ajouter au panier
                        </button>
                        <button class="btn-wishlist" id="wish-btn" onclick="toggleWish(this)">♡</button>
                    </div>
                @else
                    <button class="btn-add-cart" disabled>Indisponible</button>
                @endif
            @else
                <div class="btn-login-prompt">
                    <span>💎</span>
                    <span>Connectez-vous pour ajouter au panier — <a href="{{ route('login') }}">Se connecter</a> ou <a href="{{ route('register') }}">Créer un compte</a></span>
                </div>
            @endauth

            <!-- Détails -->
            <ul class="product-details-list">
                @if($product->brand)
                    <li><span class="label">Marque</span><span class="value">{{ $product->brand }}</span></li>
                @endif
                @if($product->product_type)
                    <li><span class="label">Type</span><span class="value">{{ $product->product_type }}</span></li>
                @endif
                @if($product->category)
                    <li><span class="label">Catégorie</span><span class="value">{{ $product->category->name }}</span></li>
                @endif
                <li><span class="label">Prix</span><span class="value">{{ number_format($product->price, 2) }} TND</span></li>
                <li><span class="label">Stock</span><span class="value">{{ $product->stock }} unités</span></li>
            </ul>
        </div>
    </div>
</div>

<!-- RELATED PRODUCTS -->
@if(isset($related) && $related->count() > 0)
<div class="related-section">
    <h2 class="related-title">Vous aimerez <em>aussi</em></h2>
    <div class="related-grid">
        @foreach($related->take(4) as $rel)
        <a href="{{ route('products.show', $rel) }}" class="related-card">
            <div class="related-card-img">
                <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}"
                    onerror="this.src='https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi'">
            </div>
            <div class="related-card-name">{{ $rel->name }}</div>
            <div class="related-card-price">{{ number_format($rel->price, 2) }} TND</div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════
     SECTION ÉVALUATIONS
══════════════════════════════════════════ --}}
<div class="reviews-section">

    {{-- Titre --}}
    <h2 class="reviews-section-title">Évaluations & <em>Avis</em></h2>

    {{-- Alertes flash --}}
    @if(session('success'))
        <div class="review-alert success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="review-alert error">✕ {{ session('error') }}</div>
    @endif

    {{-- Résumé global --}}
    @if($reviews->count() > 0)
    @php
        $avgRating  = $reviews->avg('rating');
        $totalCount = $reviews->count();
        $barCounts  = [];
        for ($s = 5; $s >= 1; $s--) {
            $barCounts[$s] = $reviews->where('rating', $s)->count();
        }
    @endphp
    <div class="reviews-summary">
        <div class="reviews-avg-score">{{ number_format($avgRating, 1) }}</div>
        <div class="reviews-avg-right">
            <div class="reviews-stars-display">
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= round($avgRating) ? 'star-filled' : 'star-empty' }}">★</span>
                @endfor
            </div>
            <div class="reviews-count-label">{{ $totalCount }} avis client{{ $totalCount > 1 ? 's' : '' }}</div>
        </div>
        <div class="reviews-bars">
            @for($s = 5; $s >= 1; $s--)
            @php $pct = $totalCount > 0 ? ($barCounts[$s] / $totalCount) * 100 : 0; @endphp
            <div class="review-bar-row">
                <span class="review-bar-label">{{ $s }}</span>
                <span style="font-size:0.75rem;color:var(--gold)">★</span>
                <div class="review-bar-track">
                    <div class="review-bar-fill" style="width: {{ $pct }}%"></div>
                </div>
                <span class="review-bar-count">{{ $barCounts[$s] }}</span>
            </div>
            @endfor
        </div>
    </div>
    @endif

    {{-- Formulaire de soumission --}}
    @auth
        @php $alreadyReviewed = $reviews->where('user_id', Auth::id())->count() > 0; @endphp
        @if(!$alreadyReviewed)
        <div class="review-form-card">
            <div class="review-form-title">Laisser un avis</div>
            <form action="{{ route('reviews.store', $product) }}" method="POST">
                @csrf

                {{-- Sélecteur d'étoiles --}}
                <div class="star-picker" id="starPicker">
                    <input type="radio" name="rating" id="star5" value="5">
                    <label for="star5" title="5 étoiles">★</label>
                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4" title="4 étoiles">★</label>
                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3" title="3 étoiles">★</label>
                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2" title="2 étoiles">★</label>
                    <input type="radio" name="rating" id="star1" value="1">
                    <label for="star1" title="1 étoile">★</label>
                </div>
                @error('rating')
                    <div style="color:#c0392b;font-size:0.76rem;margin-bottom:10px;">{{ $message }}</div>
                @enderror

                <textarea
                    name="comment"
                    class="review-textarea"
                    placeholder="Partagez votre expérience avec ce produit… (optionnel)"
                    maxlength="1000"
                >{{ old('comment') }}</textarea>
                @error('comment')
                    <div style="color:#c0392b;font-size:0.76rem;margin-bottom:10px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-submit-review">Publier mon avis</button>
            </form>
        </div>
        @else
        <div class="review-alert success" style="margin-bottom:32px;">
            ✓ Vous avez déjà laissé un avis pour ce produit.
        </div>
        @endif
    @else
        <div class="review-alert-login">
            ✦ <a href="{{ route('login') }}">Connectez-vous</a> ou <a href="{{ route('register') }}">créez un compte</a> pour laisser un avis.
        </div>
    @endauth

    {{-- Liste des avis --}}
    @if($reviews->count() > 0)
    <div class="reviews-list">
        @foreach($reviews as $review)
        <div class="review-card" style="animation-delay: {{ $loop->index * 0.06 }}s">
            <div class="review-header">
                <div class="review-user-info">
                    <div class="review-avatar">
                        @if($review->user && $review->user->avatar)
                            <img src="{{ $review->user->avatar }}" alt="">
                        @else
                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="review-user-name">{{ $review->user->name ?? 'Utilisateur' }}</div>
                        <div class="review-date">{{ $review->created_at->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="s {{ $i <= $review->rating ? 'on' : 'off' }}">★</span>
                        @endfor
                    </div>
                    @auth
                        @if($review->user_id === Auth::id())
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                              onsubmit="return confirm('Supprimer votre avis ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="review-delete-btn">Supprimer</button>
                        </form>
                        @endif
                    @endauth
                </div>
            </div>
            @if($review->comment)
                <p class="review-comment">{{ $review->comment }}</p>
            @else
                <p class="review-comment no-comment">Aucun commentaire.</p>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="reviews-empty">
        <span class="empty-icon">✦</span>
        Aucun avis pour l'instant. Soyez le premier à donner votre avis !
    </div>
    @endif

</div>

@endsection

@section('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    let val = parseInt(input.value) + delta;
    val = Math.max(1, Math.min(max, val));
    input.value = val;
}

async function addToCart(productId) {
    const btn = document.getElementById('add-btn');
    const qty = parseInt(document.getElementById('qty').value);
    btn.textContent = '…'; btn.disabled = true;
    try {
        await fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        });
        btn.textContent = '✓ Ajouté !';
        btn.style.background = 'var(--rose-deep)';
        const badge = document.querySelector('.cart-badge');
        if (badge) badge.textContent = (parseInt(badge.textContent)||0) + qty;
        setTimeout(() => { btn.textContent = 'Ajouter au panier'; btn.disabled = false; btn.style.background = ''; }, 2000);
    } catch(e) {
        btn.textContent = 'Ajouter au panier'; btn.disabled = false;
    }
}

function toggleWish(btn) {
    btn.textContent = btn.textContent === '♡' ? '♥' : '♡';
    btn.style.background = btn.textContent === '♥' ? 'var(--rose)' : '';
    btn.style.color = btn.textContent === '♥' ? '#fff' : '';
}

// Sélecteur d'étoiles interactif
(function() {
    const labels = document.querySelectorAll('#starPicker label');
    const inputs = document.querySelectorAll('#starPicker input');
    labels.forEach(label => {
        label.addEventListener('mouseenter', () => {
            const forVal = label.getAttribute('for');
            const val = parseInt(forVal.replace('star', ''));
            labels.forEach(l => {
                const v = parseInt(l.getAttribute('for').replace('star', ''));
                l.style.color = v >= val ? '#c9a96e' : 'rgba(200,116,138,0.25)';
                l.style.transform = v >= val ? 'scale(1.12)' : 'scale(1)';
            });
        });
        label.addEventListener('mouseleave', () => {
            updateSelectedStars();
        });
    });
    inputs.forEach(input => {
        input.addEventListener('change', updateSelectedStars);
    });
    function updateSelectedStars() {
        const checked = document.querySelector('#starPicker input:checked');
        const val = checked ? parseInt(checked.value) : 0;
        labels.forEach(l => {
            const v = parseInt(l.getAttribute('for').replace('star', ''));
            l.style.color = v <= val ? '#c9a96e' : 'rgba(200,116,138,0.25)';
            l.style.transform = 'scale(1)';
        });
    }
})();
</script>
@endsection