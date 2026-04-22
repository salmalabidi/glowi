@extends('layouts.app')

@section('content')

<style>
:root {
    --rose: #c8748a;
    --rose-deep: #a85070;
    --rose-pale: #f5e6ea;
    --gold: #c9a96e;
    --gold-light: #e8d5b0;
    --cream: #fdf6f0;
    --dark: #1a0f14;
    --dark-mid: #2d1a22;
    --text: #3d2030;
    --text-light: #7a5c68;
}

/* ============================
   HERO SECTION
============================= */
.hero {
    min-height: calc(100vh - 70px);
    background: var(--dark);
    display: grid;
    grid-template-columns: 1fr 1fr;
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 20% 50%, rgba(200,116,138,0.18) 0%, transparent 70%);
    pointer-events: none;
}
.hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}
.hero-left {
    display: flex; flex-direction: column; justify-content: center;
    padding: 80px 64px 80px 80px;
    position: relative; z-index: 2;
}
.hero-tag {
    display: flex; align-items: center; gap: 12px;
    color: var(--gold); font-size: 0.65rem; letter-spacing: 0.3em;
    text-transform: uppercase; margin-bottom: 28px;
    opacity: 0;
    animation: heroFadeIn 0.9s ease 0.2s forwards;
}
.hero-tag::before {
    content: ''; display: block;
    width: 40px; height: 1px; background: var(--gold);
}
.hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(3rem, 5vw, 5.5rem);
    font-weight: 300; line-height: 1.05;
    color: #fff; margin-bottom: 24px;
    opacity: 0;
    animation: heroFadeIn 0.9s ease 0.4s forwards;
}
.hero-title em {
    font-style: italic; color: var(--rose);
    display: block;
}
.hero-title .gold { color: var(--gold); }
.hero-sub {
    color: rgba(255,255,255,0.5);
    font-size: 0.88rem; line-height: 1.8;
    max-width: 380px; margin-bottom: 44px;
    opacity: 0;
    animation: heroFadeIn 0.9s ease 0.6s forwards;
}
.hero-ctas {
    display: flex; align-items: center; gap: 20px;
    opacity: 0;
    animation: heroFadeIn 0.9s ease 0.8s forwards;
}
.btn-primary {
    background: var(--rose);
    color: #fff; border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.7rem; font-weight: 500; letter-spacing: 0.2em;
    text-transform: uppercase; padding: 16px 32px;
    border-radius: 2px; text-decoration: none;
    position: relative; overflow: hidden;
    transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
    display: inline-block;
}
.btn-primary::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
    opacity: 0;
    transition: opacity 0.3s;
}
.btn-primary:hover {
    background: var(--rose-deep);
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(200,116,138,0.35);
}
.btn-primary:hover::after { opacity: 1; }
.btn-ghost {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,0.7); text-decoration: none;
    font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase;
    transition: color 0.3s;
}
.btn-ghost:hover { color: var(--gold); }
.btn-ghost .arrow {
    width: 36px; height: 36px; border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; transition: border-color 0.3s, background 0.3s, transform 0.3s;
}
.btn-ghost:hover .arrow {
    border-color: var(--gold);
    background: rgba(201,169,110,0.1);
    transform: translateX(4px);
}
.hero-stats {
    display: flex; gap: 40px; margin-top: 60px;
    border-top: 1px solid rgba(255,255,255,0.08);
    padding-top: 32px;
    opacity: 0;
    animation: heroFadeIn 0.9s ease 1s forwards;
}
.hero-stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem; font-weight: 300; color: #fff;
}
.hero-stat-label {
    font-size: 0.65rem; letter-spacing: 0.2em;
    color: rgba(255,255,255,0.4); text-transform: uppercase;
}

/* HERO GRID */
.hero-right {
    position: relative; z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 3px; padding: 3px;
    opacity: 0;
    animation: heroSlideLeft 1s ease 0.3s forwards;
}
.hero-img {
    overflow: hidden; position: relative;
    background: var(--dark-mid);
}
.hero-img:first-child { grid-column: 1; grid-row: 1 / 3; }
.hero-img:nth-child(2) { grid-column: 2; grid-row: 1 / 3; }
.hero-img:nth-child(3) { grid-column: 3; grid-row: 1; }
.hero-img:nth-child(4) { grid-column: 3; grid-row: 2; }
.hero-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease, filter 0.7s ease;
    filter: brightness(0.85) saturate(0.9);
}
.hero-img:hover img { transform: scale(1.06); filter: brightness(0.98) saturate(1.15); }

/* Hero entry animations */
@keyframes heroFadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes heroSlideLeft {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ============================
   SECTION COMMONS
============================= */
.section {
    padding: 100px 80px;
    max-width: 1400px; margin: 0 auto;
}
.section-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 56px;
}
.section-label {
    font-size: 0.62rem; letter-spacing: 0.3em; text-transform: uppercase;
    color: var(--rose); margin-bottom: 10px;
}
.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 3vw, 2.8rem);
    font-weight: 300; color: var(--text);
    line-height: 1.15;
}
.section-title em { font-style: italic; color: var(--rose-deep); }
.section-link {
    color: var(--text-light); text-decoration: none;
    font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase;
    border-bottom: 1px solid var(--gold);
    padding-bottom: 3px;
    transition: color 0.3s, letter-spacing 0.3s;
}
.section-link:hover { color: var(--rose); letter-spacing: 0.22em; }

/* ============================
   PRODUCT CARDS
============================= */
.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.product-card {
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
    transition: transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.4s;
    cursor: none;
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 28px 70px rgba(60,30,40,0.14);
}
.product-img-wrap {
    position: relative;
    aspect-ratio: 4/5;
    overflow: hidden;
    background: var(--rose-pale);
}
.product-img-wrap img {
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 20px;
    transition: transform 0.6s ease;
}
.product-card:hover .product-img-wrap img { transform: scale(1.07); }
.product-overlay {
    position: absolute; inset: 0;
    background: rgba(26,15,20,0.55);
    display: flex; align-items: center; justify-content: center; gap: 12px;
    opacity: 0; transition: opacity 0.35s;
}
.product-card:hover .product-overlay { opacity: 1; }
.overlay-btn {
    background: #fff; color: var(--dark);
    border: none; cursor: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.62rem; letter-spacing: 0.15em; text-transform: uppercase;
    padding: 10px 18px; border-radius: 2px;
    text-decoration: none;
    transition: background 0.2s, color 0.2s, transform 0.2s;
}
.overlay-btn:hover { background: var(--rose); color: #fff; transform: scale(1.04); }
.wishlist-btn {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: none; transition: background 0.2s, border-color 0.2s, transform 0.2s;
    color: #fff; font-size: 1rem;
}
.wishlist-btn:hover { background: var(--rose); border-color: var(--rose); transform: scale(1.1); }
.product-badge {
    position: absolute; top: 14px; left: 14px;
    background: var(--rose);
    color: #fff; font-size: 0.58rem; letter-spacing: 0.12em;
    text-transform: uppercase; padding: 4px 10px; border-radius: 2px;
    animation: badgePulse 2.5s ease infinite;
}
@keyframes badgePulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(200,116,138,0.4); }
    50%      { box-shadow: 0 0 0 6px rgba(200,116,138,0); }
}
.product-info { padding: 18px 20px 20px; }
.product-cat {
    font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--rose); margin-bottom: 6px;
}
.product-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 400; color: var(--text);
    margin-bottom: 4px; line-height: 1.3;
}
.product-brand { font-size: 0.72rem; color: var(--text-light); margin-bottom: 12px; }
.product-footer { display: flex; align-items: center; justify-content: space-between; }
.product-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; font-weight: 500; color: var(--rose-deep);
}
.add-to-cart-mini {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--rose-pale); border: none; cursor: none;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, transform 0.2s;
    color: var(--rose); font-size: 1.1rem;
}
.add-to-cart-mini:hover { background: var(--rose); color: #fff; transform: rotate(90deg) scale(1.1); }

/* ============================
   BANNER — MAQUILLAGE
============================= */
.banner-maquillage {
    background: var(--dark);
    margin: 0; padding: 100px 80px;
    position: relative; overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px; align-items: center;
}
.banner-maquillage::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 50% 80% at 80% 50%, rgba(200,116,138,0.2) 0%, transparent 70%);
}
.banner-text { position: relative; z-index: 2; }
.banner-text .section-label { color: var(--gold); }
.banner-text .section-title { color: #fff; }
.banner-text p {
    color: rgba(255,255,255,0.5); font-size: 0.88rem; line-height: 1.8;
    margin-top: 16px; margin-bottom: 32px; max-width: 400px;
}
.banner-imgs {
    position: relative; z-index: 2;
    display: grid; grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
}
.banner-img {
    border-radius: 4px; overflow: hidden;
    aspect-ratio: 3/4; background: var(--dark-mid);
}
.banner-img img {
    width: 100%; height: 100%; object-fit: cover;
    filter: brightness(0.8) saturate(0.85);
    transition: filter 0.5s, transform 0.5s;
}
.banner-img:hover img { filter: brightness(1) saturate(1.15); transform: scale(1.06); }

/* ============================
   SKINCARE SECTION — LIGHT
============================= */
.skincare-section {
    background: var(--rose-pale);
    padding: 100px 80px;
}
.skincare-inner { max-width: 1400px; margin: 0 auto; }
.skincare-section .section-title { color: var(--dark); }

/* ============================
   EDITORIAL STRIP
============================= */
.editorial-strip {
    background: linear-gradient(135deg, #fdf0f4 0%, #fff5eb 100%);
    padding: 80px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 0;
}
.editorial-item {
    padding: 40px 48px;
    border-right: 1px solid rgba(200,116,138,0.15);
    display: flex; flex-direction: column; align-items: center;
    text-align: center;
    transition: background 0.3s;
}
.editorial-item:hover { background: rgba(200,116,138,0.04); }
.editorial-item:last-child { border-right: none; }
.editorial-icon {
    width: 52px; height: 52px;
    background: var(--rose-pale);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin-bottom: 18px;
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), background 0.3s;
}
.editorial-item:hover .editorial-icon {
    transform: scale(1.18) rotate(-6deg);
    background: rgba(200,116,138,0.18);
}
.editorial-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; color: var(--text); margin-bottom: 10px;
}
.editorial-desc { font-size: 0.78rem; color: var(--text-light); line-height: 1.7; }

/* ============================
   NEWSLETTER
============================= */
.newsletter {
    background: var(--dark-mid);
    padding: 80px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.newsletter::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(circle at 20% 50%, rgba(200,116,138,0.08), transparent 40%),
        radial-gradient(circle at 80% 50%, rgba(201,169,110,0.08), transparent 40%);
    pointer-events: none;
}
.newsletter-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.5rem; font-weight: 300; color: #fff;
    margin-bottom: 12px; position: relative;
}
.newsletter-title em { color: var(--rose); font-style: italic; }
.newsletter-sub {
    color: rgba(255,255,255,0.45); font-size: 0.85rem;
    margin-bottom: 36px; position: relative;
}
.newsletter-form {
    display: flex; gap: 0; max-width: 440px; margin: 0 auto;
    border: 1px solid rgba(201,169,110,0.3);
    position: relative;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.newsletter-form:focus-within {
    border-color: rgba(200,116,138,0.5);
    box-shadow: 0 0 0 3px rgba(200,116,138,0.08);
}
.newsletter-form input {
    flex: 1; background: transparent; border: none;
    color: #fff; font-family: 'Jost', sans-serif;
    font-size: 0.82rem; padding: 14px 20px;
    outline: none;
}
.newsletter-form input::placeholder { color: rgba(255,255,255,0.3); }
.newsletter-form button {
    background: var(--rose); border: none; cursor: none;
    color: #fff; font-family: 'Jost', sans-serif;
    font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;
    padding: 14px 24px;
    transition: background 0.3s, letter-spacing 0.3s;
}
.newsletter-form button:hover { background: var(--rose-deep); letter-spacing: 0.28em; }

/* ============================
   ANIMATIONS
============================= */
.fade-up {
    opacity: 0; transform: translateY(32px);
    transition: opacity 0.8s cubic-bezier(0.25,0.46,0.45,0.94),
                transform 0.8s cubic-bezier(0.25,0.46,0.45,0.94);
}
.fade-up.visible { opacity: 1; transform: translateY(0); }
.fade-up-delay-1 { transition-delay: 0.1s; }
.fade-up-delay-2 { transition-delay: 0.2s; }
.fade-up-delay-3 { transition-delay: 0.3s; }

/* Shimmer on section titles */
.section-title em {
    background: linear-gradient(90deg, var(--rose-deep), var(--rose), var(--rose-deep));
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s linear infinite;
}
@keyframes shimmer { to { background-position: 200% center; } }
</style>

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <div class="hero-tag">Beauté Authentique & Luxe</div>
        <h1 class="hero-title">
            Révélez votre
            <em>éclat</em>
            <span class="gold">naturel</span>
        </h1>
        <p class="hero-sub">Skincare de prestige, maquillage raffiné, accessoires curatés — une sélection pensée pour sublimer chaque femme.</p>
        <div class="hero-ctas">
            <a href="{{ route('products.index') }}" class="btn-primary">Découvrir</a>
            <a href="{{ route('products.index', ['category' => 'maquillage']) }}" class="btn-ghost">
                <span class="arrow">→</span>
                Maquillage
            </a>
        </div>
        <div class="hero-stats">
            <div>
                <div class="hero-stat-num" data-target="60">60+</div>
                <div class="hero-stat-label">Produits</div>
            </div>
            <div>
                <div class="hero-stat-num" data-target="3">3</div>
                <div class="hero-stat-label">Collections</div>
            </div>
            <div>
                <div class="hero-stat-num" data-target="100">100%</div>
                <div class="hero-stat-label">Sélectionnés</div>
            </div>
        </div>
    </div>
    <div class="hero-right">
        <div class="hero-img">
            <img src="{{ asset('storage/images/photo1.png') }}" alt="Beauté" onerror="this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600'">
        </div>
        <div class="hero-img">
            <img src="{{ asset('storage/images/photo2.png') }}" alt="Skincare" onerror="this.src='https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=600'">
        </div>
        <div class="hero-img">
            <img src="{{ asset('storage/images/photo3.png') }}" alt="Produits" onerror="this.src='https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400'">
        </div>
        <div class="hero-img">
            <img src="{{ asset('storage/images/photo4.png') }}" alt="Maquillage" onerror="this.src='https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=400'">
        </div>
    </div>
</section>

<!-- EDITORIAL STRIP -->
<div class="editorial-strip">
    <div class="editorial-item fade-up">
        <div class="editorial-icon">🌿</div>
        <div class="editorial-title">Formules Prestige</div>
        <div class="editorial-desc">Ingrédients sélectionnés avec soin, dermatologiquement testés pour chaque type de peau.</div>
    </div>
    <div class="editorial-item fade-up fade-up-delay-1">
        <div class="editorial-icon">✦</div>
        <div class="editorial-title">Curation Experte</div>
        <div class="editorial-desc">Chaque produit est soigneusement choisi par nos expertes beauté pour sa qualité et ses résultats.</div>
    </div>
    <div class="editorial-item fade-up fade-up-delay-2">
        <div class="editorial-icon">💎</div>
        <div class="editorial-title">Luxe Accessible</div>
        <div class="editorial-desc">L'excellence des grandes marques à des prix pensés pour toutes les femmes passionnées de beauté.</div>
    </div>
</div>

<!-- NOUVEAUTÉS -->
<div class="section">
    <div class="section-header fade-up">
        <div>
            <div class="section-label">✦ Arrivages récents</div>
            <h2 class="section-title">Nos <em>Nouveautés</em></h2>
        </div>
        <a href="{{ route('products.index') }}" class="section-link">Voir tout →</a>
    </div>
    <div class="products-grid">
        @foreach($nouveautes as $index => $product)
        <div class="product-card fade-up fade-up-delay-{{ $index }}">
            <div class="product-img-wrap">
                @if($product->created_at->diffInDays() < 30)
                    <span class="product-badge">Nouveau</span>
                @endif
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/400x500/f5e6ea/c8748a?text=Glowi'">
                <div class="product-overlay">
                    <a href="{{ route('products.show', $product) }}" class="overlay-btn">Voir</a>
                    @auth
                    <button class="wishlist-btn" onclick="toggleWish(this, {{ $product->id }})" title="Wishlist">♡</button>
                    @endauth
                </div>
            </div>
            <div class="product-info">
                <div class="product-cat">{{ $product->category->name ?? '' }}</div>
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-brand">{{ $product->brand }}</div>
                <div class="product-footer">
                    <div class="product-price">{{ number_format($product->price, 2) }} TND</div>
                    @auth
                    <button class="add-to-cart-mini" title="Ajouter au panier" onclick="addToCart({{ $product->id }}, this)">+</button>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- MAQUILLAGE BANNER + PRODUITS -->
<section class="banner-maquillage">
    <div class="banner-text fade-up">
        <div class="section-label">✦ Collection</div>
        <h2 class="section-title">L'art du <em style="color:var(--rose);background:none;-webkit-text-fill-color:var(--rose);">Maquillage</em></h2>
        <p>Des teintes soigneusement sélectionnées, des textures sublimes — pour un maquillage qui révèle votre beauté naturelle.</p>
        <a href="{{ route('products.index', ['category' => 'maquillage']) }}" class="btn-primary">Voir la collection</a>
    </div>
    <div class="banner-imgs fade-up fade-up-delay-1">
        @foreach($maquillages as $product)
        <a href="{{ route('products.show', $product) }}" class="banner-img">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=400'">
        </a>
        @endforeach
    </div>
</section>

<!-- SKINCARE SECTION -->
<section class="skincare-section">
    <div class="skincare-inner">
        <div class="section-header fade-up">
            <div>
                <div class="section-label">✦ Routine beauté</div>
                <h2 class="section-title">Skincare <em>Premium</em></h2>
            </div>
            <a href="{{ route('products.index', ['category' => 'skincare']) }}" class="section-link">Explorer →</a>
        </div>
        <div class="products-grid">
            @foreach($skincares as $index => $product)
            <div class="product-card fade-up fade-up-delay-{{ $index }}">
                <div class="product-img-wrap">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/400x500/f5e6ea/c8748a?text=Glowi'">
                    <div class="product-overlay">
                        <a href="{{ route('products.show', $product) }}" class="overlay-btn">Voir</a>
                        @auth
                        <button class="wishlist-btn" onclick="toggleWish(this, {{ $product->id }})">♡</button>
                        @endauth
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-cat">Skincare</div>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-brand">{{ $product->brand }}</div>
                    <div class="product-footer">
                        <div class="product-price">{{ number_format($product->price, 2) }} TND</div>
                        @auth
                        <button class="add-to-cart-mini" onclick="addToCart({{ $product->id }}, this)">+</button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter">
    <div class="newsletter-title">Rejoignez l'univers <em>Glowi</em></div>
    <p class="newsletter-sub">Recevez nos nouveautés, conseils beauté et offres exclusives en avant-première.</p>
    <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Votre adresse email...">
        <button type="submit">S'inscrire</button>
    </form>
</section>

@endsection

@section('scripts')
<script>
// ── Fade-up on scroll ──────────────────────────────────────
const faders = document.querySelectorAll('.fade-up');
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
faders.forEach(el => obs.observe(el));

// ── Hero parallax subtle ───────────────────────────────────
const heroLeft  = document.querySelector('.hero-left');
const heroImgs  = document.querySelectorAll('.hero-img img');
window.addEventListener('scroll', () => {
    const y = window.scrollY;
    if (heroLeft) heroLeft.style.transform = `translateY(${y * 0.07}px)`;
    heroImgs.forEach((img, i) => {
        img.style.transform = `translateY(${y * (0.03 + i * 0.008)}px)`;
    });
}, { passive: true });

// ── Animated counters ──────────────────────────────────────
function animateCounter(el, target, suffix, duration = 1400) {
    let start = null;
    const step = (ts) => {
        if (!start) start = ts;
        const progress = Math.min((ts - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target) + suffix;
        if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

const statNums = document.querySelectorAll('.hero-stat-num[data-target]');
const statsObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.dataset.target);
            const raw    = el.textContent.trim();
            const suffix = raw.includes('%') ? '%' : raw.includes('+') ? '+' : '';
            animateCounter(el, target, suffix);
            statsObs.unobserve(el);
        }
    });
}, { threshold: 0.6 });
statNums.forEach(el => statsObs.observe(el));

// ── Stagger product cards ──────────────────────────────────
document.querySelectorAll('.product-card').forEach((card, i) => {
    card.style.transitionDelay = (i * 0.055) + 's';
});

// ── Add to cart ────────────────────────────────────────────
async function addToCart(productId, btn) {
    btn.textContent = '…';
    btn.style.pointerEvents = 'none';
    try {
        const res = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        });
        btn.textContent = '✓';
        btn.style.background = 'var(--rose)';
        btn.style.color = '#fff';
        const badge = document.getElementById('cart-badge');
        if (badge) {
            const count = (parseInt(badge.textContent) || 0) + 1;
            badge.style.display = 'flex';
            badge.textContent = count;
            badge.classList.remove('bump');
            void badge.offsetWidth;
            badge.classList.add('bump');
        }
        setTimeout(() => {
            btn.textContent = '+';
            btn.style.background = '';
            btn.style.color = '';
            btn.style.pointerEvents = '';
        }, 1500);
    } catch (e) {
        btn.textContent = '+';
        btn.style.pointerEvents = '';
    }
}

// ── Wishlist toggle (appel API réel) ───────────────────────
function toggleWish(btn, productId) {
    btn.disabled = true;
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = data.added ? '♥' : '♡';
        btn.style.background  = data.added ? 'var(--rose)' : '';
        btn.style.borderColor = data.added ? 'var(--rose)' : '';
        btn.disabled = false;
        // Mettre à jour le badge wishlist navbar
        const wishBadge = document.getElementById('wish-badge');
        if (wishBadge) {
            wishBadge.style.display = data.count > 0 ? 'flex' : 'none';
            wishBadge.textContent = data.count;
        }
    })
    .catch(() => { btn.disabled = false; });
}

// Initialiser les cœurs au chargement
document.addEventListener('DOMContentLoaded', function() {
    @auth
    fetch('/wishlist/ids')
        .then(r => r.json())
        .then(ids => {
            document.querySelectorAll('.wishlist-btn[onclick]').forEach(btn => {
                const match = btn.getAttribute('onclick').match(/\d+/);
                if (match && ids.includes(parseInt(match[0]))) {
                    btn.textContent = '♥';
                    btn.style.background  = 'var(--rose)';
                    btn.style.borderColor = 'var(--rose)';
                }
            });
        })
        .catch(() => {});
    @endauth
});

// ── Newsletter form ────────────────────────────────────────
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = this.querySelector('input[type="email"]');
    const btn   = this.querySelector('button');
    if (!input.value) return;
    const orig = btn.textContent;
    btn.textContent = '✓ Inscrit !';
    btn.style.background = '#6b9e6e';
    input.value = '';
    setTimeout(() => {
        btn.textContent = orig;
        btn.style.background = '';
    }, 3000);
});
</script>
@endsection