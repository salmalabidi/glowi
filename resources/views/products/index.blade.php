@extends('layouts.app')

@section('content')

<style>
:root {
    --rose: #c8748a; --rose-deep: #a85070; --rose-pale: #f5e6ea;
    --gold: #c9a96e; --cream: #fdf6f0; --dark: #1a0f14;
    --text: #3d2030; --text-light: #7a5c68;
}

/* CATALOGUE HERO */
.catalogue-hero {
    background: var(--dark);
    padding: 60px 80px 50px;
    position: relative; overflow: hidden;
}
.catalogue-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 50% 100% at 80% 50%, rgba(200,116,138,0.15) 0%, transparent 70%);
}
.catalogue-hero-inner {
    max-width: 1200px; margin: 0 auto;
    position: relative; z-index: 1;
    display: flex; align-items: flex-end; justify-content: space-between;
}
.catalogue-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.5rem, 4vw, 3.5rem);
    font-weight: 300; color: #fff; line-height: 1.1;
}
.catalogue-title em { color: var(--rose); font-style: italic; }
.catalogue-count {
    font-size: 0.7rem; letter-spacing: 0.2em; text-transform: uppercase;
    color: rgba(255,255,255,0.35); margin-top: 8px;
}

/* SEARCH BAR */
.search-bar-wrap {
    background: var(--cream); padding: 24px 80px;
    border-bottom: 1px solid rgba(200,116,138,0.12);
    position: sticky; top: 70px; z-index: 100;
}
.search-bar-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; gap: 12px; align-items: center;
}
.search-input-wrap {
    flex: 1; position: relative;
}
.search-input-wrap input {
    width: 100%; padding: 13px 20px 13px 44px;
    border: 1px solid rgba(200,116,138,0.25);
    border-radius: 2px; background: #fff;
    font-family: 'Jost', sans-serif; font-size: 0.85rem;
    color: var(--text); outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.search-input-wrap input:focus {
    border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(200,116,138,0.08);
}
.search-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--text-light); font-size: 0.9rem; pointer-events: none;
}
.search-loading {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; display: none;
    border: 2px solid var(--rose-pale); border-top-color: var(--rose);
    border-radius: 50%; animation: spin 0.7s linear infinite;
}
.search-loading.active { display: block; }
@keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }

.filter-select,
.sort-select {
    padding: 13px 16px;
    border: 1px solid rgba(200,116,138,0.25);
    border-radius: 2px; background: #fff;
    font-family: 'Jost', sans-serif; font-size: 0.8rem;
    color: var(--text); outline: none; cursor: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.filter-select:focus,
.sort-select:focus {
    border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(200,116,138,0.08);
}

/* CATALOGUE BODY */
.catalogue-body {
    max-width: 1280px; margin: 0 auto;
    padding: 48px 48px 100px;
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 48px; align-items: start;
}

/* SIDEBAR FILTERS */
.sidebar {
    position: sticky; top: 145px;
}
.sidebar-section { margin-bottom: 32px; }
.sidebar-title {
    font-size: 0.62rem; letter-spacing: 0.25em; text-transform: uppercase;
    color: var(--rose); margin-bottom: 14px;
}
.sidebar-links { list-style: none; }
.sidebar-links li + li { margin-top: 2px; }
.sidebar-links a {
    display: flex; align-items: center; justify-content: space-between;
    padding: 9px 12px;
    color: var(--text-light); text-decoration: none;
    font-size: 0.82rem; border-radius: 2px;
    transition: background 0.2s, color 0.2s, transform 0.2s;
}
.sidebar-links a:hover, .sidebar-links a.active {
    background: var(--rose-pale); color: var(--rose-deep);
    transform: translateX(3px);
}
.sidebar-links a .count {
    font-size: 0.68rem; color: rgba(200,116,138,0.5);
}

.price-range { margin-top: 8px; }
.price-range input[type=range] {
    width: 100%; accent-color: var(--rose); cursor: none;
}
.price-labels {
    display: flex; justify-content: space-between;
    font-size: 0.75rem; color: var(--text-light); margin-top: 6px;
}

/* PRODUCTS */
.products-area {}
.results-bar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px; padding-bottom: 16px;
    border-bottom: 1px solid rgba(200,116,138,0.12);
}
.results-count { font-size: 0.78rem; color: var(--text-light); }
.results-count strong { color: var(--text); }

#products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    transition: opacity 0.3s;
}
#products-grid.loading { opacity: 0.4; }

.product-card {
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    cursor: none;
    border: 1px solid rgba(200,116,138,0.10);
    transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.35s ease;
    animation: cardIn 0.55s ease both;
    will-change: transform;
}
@keyframes cardIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 22px 55px rgba(60,30,40,0.12);
    border-color: rgba(200,116,138,0.26);
}
.product-card::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.00) 0%,
        rgba(255,255,255,0.10) 45%,
        rgba(255,255,255,0.00) 100%
    );
    opacity: 0;
    transition: opacity 0.35s ease;
    pointer-events: none;
}
.product-card:hover::after {
    opacity: 1;
}

.product-img-wrap {
    position: relative; aspect-ratio: 4/5; overflow: hidden;
    background: linear-gradient(180deg, #f8edef 0%, var(--rose-pale) 100%);
}
.product-img-wrap img {
    width: 100%; height: 100%; object-fit: contain; padding: 20px;
    transition: transform 0.6s ease, filter 0.45s ease;
}
.product-card:hover .product-img-wrap img {
    transform: scale(1.06);
    filter: brightness(1.03);
}

.product-overlay {
    position: absolute; inset: 0;
    background: rgba(26,15,20,0.55);
    display: flex; align-items: center; justify-content: center; gap: 12px;
    opacity: 0; transition: opacity 0.35s;
}
.product-card:hover .product-overlay { opacity: 1; }

.overlay-btn {
    background: #fff; color: var(--dark); border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.62rem; letter-spacing: 0.15em; text-transform: uppercase;
    padding: 10px 18px; border-radius: 2px; text-decoration: none;
    transition: background 0.25s, color 0.25s, transform 0.25s, box-shadow 0.25s;
}
.overlay-btn:hover {
    background: var(--rose); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(200,116,138,0.18);
}

.wishlist-btn {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: none; color: #fff; font-size: 1rem;
    transition: background 0.25s, border-color 0.25s, transform 0.25s;
}
.wishlist-btn:hover {
    background: var(--rose); border-color: var(--rose);
    transform: scale(1.06);
}

.product-badge {
    position: absolute; top: 14px; left: 14px;
    background: var(--rose); color: #fff;
    font-size: 0.58rem; letter-spacing: 0.12em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 2px;
    box-shadow: 0 8px 18px rgba(200,116,138,0.18);
}

.product-info { padding: 18px 20px 20px; }
.product-cat {
    font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--rose); margin-bottom: 5px;
}
.product-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 400; color: var(--text);
    margin-bottom: 3px; line-height: 1.3;
    transition: color 0.3s ease;
}
.product-card:hover .product-name {
    color: var(--rose-deep);
}

.product-brand {
    font-size: 0.72rem; color: var(--text-light); margin-bottom: 12px;
}
.product-footer { display: flex; align-items: center; justify-content: space-between; }
.product-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.25rem; font-weight: 500; color: var(--rose-deep);
    transition: transform 0.3s ease, color 0.3s ease;
}
.product-card:hover .product-price {
    transform: translateX(3px);
}

.add-mini {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--rose-pale); border: none; cursor: none;
    color: var(--rose); font-size: 1.2rem;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.25s, color 0.25s, transform 0.25s, box-shadow 0.25s;
}
.add-mini:hover {
    background: var(--rose); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(200,116,138,0.18);
}

/* EMPTY STATE */
.empty-state {
    grid-column: 1 / -1; text-align: center; padding: 80px 20px;
}
.empty-state .icon { font-size: 3rem; margin-bottom: 16px; }
.empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; color: var(--text); margin-bottom: 8px;
}
.empty-state p { color: var(--text-light); font-size: 0.88rem; }

/* RESPONSIVE */
@media (max-width: 1100px) {
    #products-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .catalogue-body {
        grid-template-columns: 220px 1fr;
        gap: 28px;
    }
}

@media (max-width: 900px) {
    .catalogue-hero,
    .search-bar-wrap {
        padding-left: 24px;
        padding-right: 24px;
    }

    .catalogue-body {
        grid-template-columns: 1fr;
        padding: 32px 24px 80px;
    }

    .sidebar {
        position: static;
    }

    .search-bar-inner {
        flex-wrap: wrap;
    }

    .filter-select,
    .sort-select {
        flex: 1 1 180px;
    }
}

@media (max-width: 640px) {
    #products-grid {
        grid-template-columns: 1fr;
    }

    .catalogue-hero {
        padding-top: 40px;
        padding-bottom: 36px;
    }

    .catalogue-title {
        font-size: 2.2rem;
    }
}
</style>

<!-- CATALOGUE HERO -->
<div class="catalogue-hero">
    <div class="catalogue-hero-inner">
        <div>
            <h1 class="catalogue-title">
                @if(request('category') === 'skincare') Skincare <em>Premium</em>
                @elseif(request('category') === 'maquillage') Notre <em>Maquillage</em>
                @elseif(request('category') === 'accessoires') Les <em>Accessoires</em>
                @else Toute la <em>Collection</em>
                @endif
            </h1>
            <p class="catalogue-count" id="total-count">{{ $totalCount }} produits sélectionnés</p>
        </div>
    </div>
</div>

<!-- SEARCH BAR -->
<div class="search-bar-wrap">
    <div class="search-bar-inner">
        <div class="search-input-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" id="search-input" placeholder="Rechercher un produit, une marque..." value="{{ request('search') }}">
            <div class="search-loading" id="search-loader"></div>
        </div>

        <select class="filter-select" id="cat-filter" onchange="applyFilters()">
            <option value="">Toutes catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select class="filter-select" id="type-filter" onchange="applyFilters()">
            <option value="">Tous les types</option>
            @foreach($productTypes as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>

        <select class="sort-select" id="sort-filter" onchange="applyFilters()">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A–Z</option>
        </select>
    </div>
</div>

<div class="catalogue-body">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-section">
            <div class="sidebar-title">Catégories</div>
            <ul class="sidebar-links">
                <li>
                    <a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                        Tout voir <span class="count">{{ $totalCount }}</span>
                    </a>
                </li>
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="{{ request('category') == $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }} <span class="count">{{ $cat->products_count ?? '' }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        @if(request('category') === 'maquillage')
        <div class="sidebar-section">
            <div class="sidebar-title">Type de maquillage</div>
            <ul class="sidebar-links">
                <li><a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Yeux']) }}" class="{{ request('type') == 'Yeux' ? 'active' : '' }}">✦ Yeux</a></li>
                <li><a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Teint']) }}" class="{{ request('type') == 'Teint' ? 'active' : '' }}">✦ Teint</a></li>
                <li><a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Gloss']) }}" class="{{ request('type') == 'Gloss' ? 'active' : '' }}">✦ Lèvres</a></li>
            </ul>
        </div>
        @endif

        <div class="sidebar-section">
            <div class="sidebar-title">Prix</div>
            <div class="price-range">
                <input type="range" min="0" max="200" value="{{ request('max_price', 200) }}" id="price-range" oninput="document.getElementById('price-val').textContent=this.value">
                <div class="price-labels">
                    <span>0 TND</span>
                    <span id="price-val">{{ request('max_price', 200) }} TND</span>
                </div>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-title">Marques</div>
            <ul class="sidebar-links">
                @foreach($brands ?? [] as $brand)
                <li>
                    <a href="{{ route('products.index', array_merge(request()->query(), ['brand' => $brand])) }}" class="{{ request('brand') == $brand ? 'active' : '' }}">
                        {{ $brand }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <!-- PRODUCTS -->
    <div class="products-area">
        <div class="results-bar">
            <div class="results-count">
                <strong id="count-display">{{ $products->total() }}</strong> produits trouvés
            </div>
        </div>

        <div id="products-grid">
            @forelse($products as $index => $product)
            <div class="product-card" style="animation-delay: {{ $index * 0.05 }}s">
                <div class="product-img-wrap">
                    @if($loop->index < 3)
                        <span class="product-badge">Nouveau</span>
                    @endif

                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        onerror="this.src='https://via.placeholder.com/400x500/f5e6ea/c8748a?text={{ urlencode($product->name) }}'"
                    >

                    <div class="product-overlay">
                        <a href="{{ route('products.show', $product) }}" class="overlay-btn">Voir</a>
                        @auth
                        <button class="wishlist-btn" onclick="toggleWish(this)">♡</button>
                        @endauth
                    </div>
                </div>

                <div class="product-info">
                    <div class="product-cat">
                        {{ $product->category->name ?? '' }} {{ $product->product_type ? '— '.$product->product_type : '' }}
                    </div>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-brand">{{ $product->brand }}</div>

                    <div class="product-footer">
                        <div class="product-price">{{ number_format($product->price, 2) }} TND</div>
                        @auth
                        <button class="add-mini" onclick="addToCart({{ $product->id }}, this)">+</button>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="icon">✦</div>
                <h3>Aucun produit trouvé</h3>
                <p>Essayez d'autres filtres ou termes de recherche.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top:40px; display:flex; justify-content:center;">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let searchTimeout;
const searchInput = document.getElementById('search-input');
const loader = document.getElementById('search-loader');
const grid = document.getElementById('products-grid');

if (searchInput) {
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        loader.classList.add('active');
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 350);
    });
}

function applyFilters() {
    const params = new URLSearchParams();
    const search = searchInput.value.trim();
    const cat = document.getElementById('cat-filter').value;
    const type = document.getElementById('type-filter').value;
    const sort = document.getElementById('sort-filter').value;
    const price = document.getElementById('price-range').value;

    if (search) params.set('search', search);
    if (cat) params.set('category', cat);
    if (type) params.set('type', type);
    if (sort && sort !== 'newest') params.set('sort', sort);
    if (price && price != 200) params.set('max_price', price);

    const url = '/products/search?' + params.toString();
    grid.classList.add('loading');
    loader.classList.add('active');

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            grid.innerHTML = data.html;
            document.getElementById('count-display').textContent = data.count;
            grid.classList.remove('loading');
            loader.classList.remove('active');

            grid.querySelectorAll('.product-card').forEach((c, i) => {
                c.style.animationDelay = (i * 0.05) + 's';
            });
        })
        .catch(() => {
            grid.classList.remove('loading');
            loader.classList.remove('active');
        });
}

function addToCart(productId, btn) {
    btn.textContent = '…';

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(() => {
        btn.textContent = '✓';
        btn.style.background = 'var(--rose)';
        btn.style.color = '#fff';

        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = (parseInt(badge.textContent) || 0) + 1;
        }

        setTimeout(() => {
            btn.textContent = '+';
            btn.style.background = '';
            btn.style.color = '';
        }, 1500);
    })
    .catch(() => {
        btn.textContent = '+';
    });
}

function toggleWish(btn) {
    btn.textContent = btn.textContent === '♡' ? '♥' : '♡';
}
</script>
@endsection