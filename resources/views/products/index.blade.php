@extends('layouts.app')

@section('content')

@php
    $currentCategory = request('category');
    $heroClass = match($currentCategory) {
        'skincare' => 'hero-skincare',
        'maquillage' => 'hero-makeup',
        'accessoires' => 'hero-accessories',
        default => 'hero-catalogue',
    };

    $heroLabel = match($currentCategory) {
        'skincare' => 'Skincare Premium',
        'maquillage' => 'Maquillage Raffiné',
        'accessoires' => 'Accessoires Curatés',
        default => 'Toute la Collection',
    };

    $heroSub = match($currentCategory) {
        'skincare' => 'Rituel soin, textures précieuses et éclat naturel.',
        'maquillage' => 'Pigments élégants, finis lumineux et gestes experts.',
        'accessoires' => 'Objets choisis pour sublimer chaque routine beauté.',
        default => 'Une sélection premium pensée pour une expérience beauté plus raffinée.',
    };
@endphp

<style>
:root {
    --rose: #c8748a;
    --rose-deep: #a85070;
    --rose-pale: #f5e6ea;
    --rose-soft: #f8edf1;
    --gold: #c9a96e;
    --gold-light: #e9d7b7;
    --cream: #fdf6f0;
    --dark: #1a0f14;
    --dark-2: #241219;
    --text: #3d2030;
    --text-light: #7a5c68;
    --line: rgba(200,116,138,0.14);
    --shadow-soft: 0 18px 45px rgba(36, 18, 25, 0.08);
    --shadow-premium: 0 24px 60px rgba(36, 18, 25, 0.12);
}

/* PAGE */
.catalogue-page {
    position: relative;
}

/* HERO */
.catalogue-hero {
    position: relative;
    overflow: hidden;
    padding: 78px 80px 58px;
    min-height: 240px;
    display: flex;
    align-items: flex-end;
    isolation: isolate;
    background:
        radial-gradient(circle at 12% 22%, rgba(255,255,255,0.08), transparent 22%),
        radial-gradient(circle at 86% 30%, rgba(200,116,138,0.16), transparent 28%),
        linear-gradient(120deg, #170b11 0%, #241019 38%, #2a121d 100%);
}

.catalogue-hero.hero-skincare {
    background:
        radial-gradient(circle at 10% 20%, rgba(255,255,255,0.08), transparent 22%),
        radial-gradient(circle at 84% 24%, rgba(201,169,110,0.18), transparent 28%),
        linear-gradient(120deg, #160d12 0%, #1d1720 38%, #2d1b24 100%);
}

.catalogue-hero.hero-makeup {
    background:
        radial-gradient(circle at 12% 20%, rgba(255,255,255,0.08), transparent 22%),
        radial-gradient(circle at 84% 24%, rgba(200,116,138,0.22), transparent 28%),
        linear-gradient(120deg, #190d13 0%, #2a121a 38%, #34131f 100%);
}

.catalogue-hero.hero-accessories {
    background:
        radial-gradient(circle at 12% 20%, rgba(255,255,255,0.08), transparent 22%),
        radial-gradient(circle at 84% 24%, rgba(201,169,110,0.20), transparent 28%),
        linear-gradient(120deg, #171014 0%, #24161d 38%, #2c1a20 100%);
}

.catalogue-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: linear-gradient(to bottom, rgba(0,0,0,0.35), transparent 90%);
    pointer-events: none;
    z-index: -1;
}

.catalogue-hero::after {
    content: '';
    position: absolute;
    inset: auto -10% -35% auto;
    width: 520px;
    height: 520px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,116,138,0.12), transparent 65%);
    filter: blur(8px);
    animation: heroFloat 8s ease-in-out infinite;
    pointer-events: none;
    z-index: -1;
}

@keyframes heroFloat {
    0%,100% { transform: translateY(0px) translateX(0px); }
    50% { transform: translateY(-16px) translateX(-10px); }
}

.catalogue-hero-inner {
    max-width: 1240px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 32px;
}

.catalogue-copy {
    max-width: 760px;
}

.catalogue-kicker {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.72);
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    margin-bottom: 16px;
    animation: fadeUp 0.7s ease both;
}

.catalogue-kicker::before {
    content: '';
    width: 34px;
    height: 1px;
    background: linear-gradient(90deg, var(--rose), var(--gold));
}

.catalogue-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.9rem, 5vw, 4.8rem);
    font-weight: 300;
    color: #fff;
    line-height: 1.02;
    letter-spacing: -0.02em;
    animation: fadeUp 0.9s ease both;
}

.catalogue-title em {
    color: #e194ab;
    font-style: italic;
    font-weight: 400;
}

.catalogue-subtitle {
    margin-top: 18px;
    color: rgba(255,255,255,0.60);
    font-size: 0.94rem;
    line-height: 1.8;
    max-width: 620px;
    animation: fadeUp 1.05s ease both;
}

.catalogue-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 22px;
    animation: fadeUp 1.15s ease both;
}

.meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 999px;
    background: rgba(255,255,255,0.04);
    color: rgba(255,255,255,0.78);
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
}

.meta-pill strong {
    color: #fff;
    font-weight: 500;
}

/* SEARCH / FILTER BAR */
.search-bar-wrap {
    position: sticky;
    top: 70px;
    z-index: 100;
    background: rgba(253, 246, 240, 0.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--line);
    box-shadow: 0 8px 18px rgba(26,15,20,0.03);
    padding: 22px 80px;
}

.search-bar-inner {
    max-width: 1240px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 14px;
}

.search-input-wrap {
    flex: 1;
    position: relative;
}

.search-input-wrap input {
    width: 100%;
    padding: 16px 54px 16px 50px;
    border: 1px solid rgba(200,116,138,0.22);
    border-radius: 16px;
    background: rgba(255,255,255,0.90);
    font-family: 'Jost', sans-serif;
    font-size: 0.92rem;
    color: var(--text);
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s, background 0.3s;
    box-shadow: 0 10px 24px rgba(26,15,20,0.03);
}

.search-input-wrap input:focus {
    border-color: rgba(200,116,138,0.46);
    box-shadow: 0 0 0 4px rgba(200,116,138,0.08), 0 14px 28px rgba(26,15,20,0.04);
    transform: translateY(-1px);
    background: #fff;
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--rose-deep);
    opacity: 0.85;
    pointer-events: none;
}

.search-icon svg {
    width: 100%;
    height: 100%;
    display: block;
    stroke: currentColor;
}

.search-loading {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    display: none;
    border: 2px solid rgba(200,116,138,0.18);
    border-top-color: var(--rose);
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
.search-loading.active { display: block; }
@keyframes spin {
    to { transform: translateY(-50%) rotate(360deg); }
}

.filter-select,
.sort-select {
    min-width: 172px;
    padding: 16px 16px;
    border: 1px solid rgba(200,116,138,0.22);
    border-radius: 16px;
    background: rgba(255,255,255,0.90);
    font-family: 'Jost', sans-serif;
    font-size: 0.84rem;
    color: var(--text);
    outline: none;
    cursor: none;
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
    box-shadow: 0 10px 24px rgba(26,15,20,0.03);
}

.filter-select:focus,
.sort-select:focus {
    border-color: rgba(200,116,138,0.46);
    box-shadow: 0 0 0 4px rgba(200,116,138,0.08), 0 14px 28px rgba(26,15,20,0.04);
    transform: translateY(-1px);
}

/* BODY */
.catalogue-body {
    max-width: 1320px;
    margin: 0 auto;
    padding: 46px 48px 100px;
    display: grid;
    grid-template-columns: 255px 1fr;
    gap: 44px;
    align-items: start;
}

/* SIDEBAR */
.sidebar {
    position: sticky;
    top: 152px;
}

.sidebar-shell {
    background: linear-gradient(180deg, rgba(255,255,255,0.70), rgba(255,255,255,0.52));
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 24px;
    padding: 22px 18px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(12px);
}

.sidebar-section + .sidebar-section {
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid rgba(200,116,138,0.10);
}

.sidebar-title {
    font-size: 0.64rem;
    letter-spacing: 0.26em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 14px;
}

.sidebar-links {
    list-style: none;
}

.sidebar-links li + li {
    margin-top: 5px;
}

.sidebar-links a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 14px;
    color: var(--text-light);
    text-decoration: none;
    font-size: 0.86rem;
    transition: background 0.22s, color 0.22s, transform 0.22s, box-shadow 0.22s;
}

.sidebar-links a:hover,
.sidebar-links a.active {
    background: linear-gradient(135deg, rgba(200,116,138,0.12), rgba(201,169,110,0.10));
    color: var(--rose-deep);
    transform: translateX(3px);
    box-shadow: 0 10px 18px rgba(200,116,138,0.06);
}

.sidebar-links a .count {
    font-size: 0.68rem;
    color: rgba(200,116,138,0.60);
}

.price-range input[type=range] {
    width: 100%;
    accent-color: var(--rose);
    cursor: none;
}

.price-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 0.78rem;
    color: var(--text-light);
}

/* RESULTS */
.products-area {
    min-width: 0;
}

.results-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 22px;
    padding: 0 2px 16px;
    border-bottom: 1px solid var(--line);
}

.results-left {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.results-count {
    font-size: 0.9rem;
    color: var(--text-light);
}

.results-count strong {
    color: var(--text);
    font-weight: 600;
}

.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(200,116,138,0.10), rgba(201,169,110,0.08));
    color: var(--rose-deep);
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    border: 1px solid rgba(200,116,138,0.10);
}

/* GRID */
#products-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 26px;
    transition: opacity 0.3s ease;
}
#products-grid.loading {
    opacity: 0.4;
}

/* CARD */
.product-card {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,255,255,0.94));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: var(--shadow-soft);
    transition: transform 0.38s ease, box-shadow 0.38s ease, border-color 0.32s ease;
    cursor: none;
    animation: cardIn 0.55s ease both;
    will-change: transform;
}

@keyframes cardIn {
    from { opacity: 0; transform: translateY(26px) scale(0.985); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-premium);
    border-color: rgba(200,116,138,0.26);
}

.product-card::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.00) 0%,
        rgba(255,255,255,0.12) 45%,
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
    position: relative;
    aspect-ratio: 4 / 5;
    overflow: hidden;
    background:
        radial-gradient(circle at 30% 20%, rgba(255,255,255,0.65), transparent 30%),
        linear-gradient(180deg, #fbf1f4 0%, #f6e7eb 100%);
}

.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 22px;
    transition: transform 0.6s ease, filter 0.45s ease;
}

.product-card:hover .product-img-wrap img {
    transform: scale(1.07);
    filter: brightness(1.03);
}

.product-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    opacity: 0;
    background: linear-gradient(180deg, rgba(26,15,20,0.10), rgba(26,15,20,0.58));
    transition: opacity 0.35s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 18px;
    border-radius: 999px;
    background: rgba(255,255,255,0.96);
    color: var(--dark);
    text-decoration: none;
    border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.68rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
}

.overlay-btn:hover {
    background: var(--rose);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(200,116,138,0.18);
}

.wishlist-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.26);
    color: #fff;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: none;
    transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease;
}

.wishlist-btn:hover {
    transform: scale(1.06);
    background: var(--rose);
    border-color: var(--rose);
}

.product-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 7px 12px;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--rose), var(--gold));
    color: #fff;
    font-size: 0.58rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    box-shadow: 0 10px 18px rgba(200,116,138,0.20);
}

.product-info {
    padding: 20px 20px 22px;
}

.product-cat {
    font-size: 0.62rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 8px;
}

.product-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.28rem;
    font-weight: 400;
    color: var(--text);
    line-height: 1.25;
    margin-bottom: 4px;
    transition: color 0.28s ease;
}

.product-card:hover .product-name {
    color: var(--rose-deep);
}

.product-brand {
    color: var(--text-light);
    font-size: 0.76rem;
    margin-bottom: 14px;
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.product-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.36rem;
    font-weight: 500;
    color: var(--rose-deep);
    transition: transform 0.28s ease;
}

.product-card:hover .product-price {
    transform: translateX(3px);
}

.add-mini {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, var(--rose-pale), #fff);
    color: var(--rose);
    font-size: 1.2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.add-mini:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
    box-shadow: 0 12px 24px rgba(200,116,138,0.18);
}

/* EMPTY */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 86px 24px;
    border-radius: 28px;
    background: linear-gradient(180deg, rgba(255,255,255,0.82), rgba(255,255,255,0.68));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: var(--shadow-soft);
}

.empty-state .icon {
    font-size: 3.1rem;
    color: var(--rose-deep);
    margin-bottom: 18px;
    animation: pulseStar 2.4s ease-in-out infinite;
}

@keyframes pulseStar {
    0%,100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.08); opacity: 0.75; }
}

.empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-light);
    font-size: 0.92rem;
}

/* PAGINATION */
.pagination-wrap {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

/* SCROLL ANIM */
.fade-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.75s ease, transform 0.75s ease;
}
.fade-up.show {
    opacity: 1;
    transform: translateY(0);
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */
@media (max-width: 1180px) {
    #products-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .catalogue-body {
        grid-template-columns: 240px 1fr;
        gap: 30px;
    }
}

@media (max-width: 980px) {
    .catalogue-hero,
    .search-bar-wrap {
        padding-left: 24px;
        padding-right: 24px;
    }

    .catalogue-body {
        grid-template-columns: 1fr;
        padding: 34px 24px 86px;
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
        min-width: 0;
    }

    .catalogue-hero-inner {
        align-items: flex-start;
    }
}

@media (max-width: 640px) {
    #products-grid {
        grid-template-columns: 1fr;
    }

    .catalogue-hero {
        padding-top: 54px;
        padding-bottom: 42px;
        min-height: 220px;
    }

    .catalogue-title {
        font-size: 2.45rem;
    }

    .catalogue-subtitle {
        font-size: 0.88rem;
    }

    .search-bar-inner {
        gap: 10px;
    }

    .search-input-wrap input,
    .filter-select,
    .sort-select {
        border-radius: 14px;
        font-size: 0.82rem;
    }

    .sidebar-shell {
        border-radius: 20px;
    }

    .product-card {
        border-radius: 20px;
    }
}
</style>

<div class="catalogue-page">
    <!-- HERO -->
    <div class="catalogue-hero {{ $heroClass }}">
        <div class="catalogue-hero-inner">
            <div class="catalogue-copy">
                <div class="catalogue-kicker">Collection Glowi</div>

                <h1 class="catalogue-title">
                    @if($currentCategory === 'skincare')
                        Skincare <em>Premium</em>
                    @elseif($currentCategory === 'maquillage')
                        Maquillage <em>Raffiné</em>
                    @elseif($currentCategory === 'accessoires')
                        Accessoires <em>Curatés</em>
                    @else
                        Toute la <em>Collection</em>
                    @endif
                </h1>

                <p class="catalogue-subtitle">{{ $heroSub }}</p>

                <div class="catalogue-meta">
                    <div class="meta-pill">
                        Produits <strong id="total-count">{{ $totalCount }}</strong>
                    </div>

                    @if(request('type'))
                        <div class="meta-pill">
                            Type <strong>{{ request('type') }}</strong>
                        </div>
                    @endif

                    @if(request('brand'))
                        <div class="meta-pill">
                            Marque <strong>{{ request('brand') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-bar-wrap">
        <div class="search-bar-inner">
            <div class="search-input-wrap">
                <span class="search-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L16.65 16.65" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.8 18.1C14.8317 18.1 18.1 14.8317 18.1 10.8C18.1 6.76832 14.8317 3.5 10.8 3.5C6.76832 3.5 3.5 6.76832 3.5 10.8C3.5 14.8317 6.76832 18.1 10.8 18.1Z" stroke-width="1.8"/>
                    </svg>
                </span>

                <input
                    type="text"
                    id="search-input"
                    placeholder="Rechercher un produit, une marque..."
                    value="{{ request('search') }}"
                >

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
            <div class="sidebar-shell fade-up">
                <div class="sidebar-section">
                    <div class="sidebar-title">Catégories</div>

                    <ul class="sidebar-links">
                        <li>
                            <a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                Tout voir
                                <span class="count">{{ $totalCount }}</span>
                            </a>
                        </li>

                        @foreach($categories as $cat)
                            <li>
                                <a
                                    href="{{ route('products.index', ['category' => $cat->slug]) }}"
                                    class="{{ request('category') == $cat->slug ? 'active' : '' }}"
                                >
                                    {{ $cat->name }}
                                    <span class="count">{{ $cat->products_count ?? '' }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if(request('category') === 'maquillage')
                    <div class="sidebar-section">
                        <div class="sidebar-title">Type de maquillage</div>

                        <ul class="sidebar-links">
                            <li>
                                <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Yeux']) }}" class="{{ request('type') == 'Yeux' ? 'active' : '' }}">
                                    ✦ Yeux
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Teint']) }}" class="{{ request('type') == 'Teint' ? 'active' : '' }}">
                                    ✦ Teint
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Gloss']) }}" class="{{ request('type') == 'Gloss' ? 'active' : '' }}">
                                    ✦ Lèvres
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <div class="sidebar-section">
                    <div class="sidebar-title">Prix</div>

                    <div class="price-range">
                        <input
                            type="range"
                            min="0"
                            max="200"
                            value="{{ request('max_price', 200) }}"
                            id="price-range"
                            oninput="document.getElementById('price-val').textContent=this.value+' TND'; clearTimeout(window._priceT); window._priceT=setTimeout(applyFilters, 500);"
                        >
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
                                <a
                                    href="{{ route('products.index', array_merge(request()->query(), ['brand' => $brand])) }}"
                                    class="{{ request('brand') == $brand ? 'active' : '' }}"
                                >
                                    {{ $brand }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        <!-- PRODUCTS -->
        <div class="products-area">
            <div class="results-bar fade-up">
                <div class="results-left">
                    <div class="results-count">
                        <strong id="count-display">{{ $products->total() }}</strong> produits trouvés
                    </div>

                    <div class="active-filters">
                        @if(request('category'))
                            <span class="filter-chip">{{ request('category') }}</span>
                        @endif

                        @if(request('type'))
                            <span class="filter-chip">{{ request('type') }}</span>
                        @endif

                        @if(request('brand'))
                            <span class="filter-chip">{{ request('brand') }}</span>
                        @endif

                        @if(request('search'))
                            <span class="filter-chip">“{{ request('search') }}”</span>
                        @endif
                    </div>
                </div>
            </div>

            <div id="products-grid">
                @forelse($products as $index => $product)
                    <div class="product-card fade-up" style="animation-delay: {{ $index * 0.05 }}s">
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
                                    <button class="wishlist-btn" onclick="toggleWish(this, {{ $product->id }})">♡</button>
                                @endauth
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="product-cat">
                                {{ $product->category->name ?? '' }}{{ $product->product_type ? ' — ' . $product->product_type : '' }}
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
                    <div class="empty-state fade-up">
                        <div class="icon">✦</div>
                        <h3>Aucun produit trouvé</h3>
                        <p>Essayez d'autres filtres ou un autre terme de recherche.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrap">
                {{ $products->withQueryString()->links() }}
            </div>
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
    if (price && parseInt(price) < 200) params.set('max_price', price);

    const url = '/products/search?' + params.toString();

    grid.classList.add('loading');
    loader.classList.add('active');

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        grid.innerHTML = data.html;
        document.getElementById('count-display').textContent = data.count;
        grid.classList.remove('loading');
        loader.classList.remove('active');

        grid.querySelectorAll('.product-card').forEach((c, i) => {
            c.style.animationDelay = (i * 0.05) + 's';
            c.classList.add('show');
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
    .then(async (response) => {
        if (!response.ok) {
            throw new Error('Erreur panier');
        }

        const data = await response.json();

        btn.textContent = '✓';
        btn.style.background = 'var(--rose)';
        btn.style.color = '#fff';

        if (typeof updateCartBadge === 'function') {
            updateCartBadge(data.count);
        }

        setTimeout(() => {
            btn.textContent = '+';
            btn.style.background = '';
            btn.style.color = '';
        }, 1400);
    })
    .catch(() => {
        btn.textContent = '+';
    });
}

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
        btn.classList.toggle('wishlisted', data.added);
        btn.disabled = false;

        // Mettre à jour le badge wishlist dans la navbar
        const wishBadge = document.getElementById('wish-badge');
        if (wishBadge) {
            wishBadge.style.display = data.count > 0 ? 'flex' : 'none';
            wishBadge.textContent = data.count > 0 ? data.count : '♡';
        }
    })
    .catch(() => { btn.disabled = false; });
}

document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.12
    });

    document.querySelectorAll('.fade-up').forEach((el) => {
        observer.observe(el);
    });
});
</script>
@endsection