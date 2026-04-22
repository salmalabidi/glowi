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

/* ANIMATIONS */
.slide-in-left { animation: slideLeft 0.7s ease both; }
.slide-in-right { animation: slideRight 0.7s ease 0.15s both; }
@keyframes slideLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
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
</script>
@endsection