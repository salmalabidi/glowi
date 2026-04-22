@extends('layouts.app')

@section('content')
<style>
.seller-page { max-width: 1100px; margin: 0 auto; padding: 52px 32px 100px; }

.seller-hero {
    position: relative; overflow: hidden;
    border-radius: 28px; padding: 32px 36px; margin-bottom: 28px;
    background:
        radial-gradient(circle at 10% 20%, rgba(200,116,138,0.16), transparent 28%),
        radial-gradient(circle at 88% 25%, rgba(201,169,110,0.13), transparent 26%),
        linear-gradient(135deg, rgba(255,255,255,0.94), rgba(255,255,255,0.84));
    border: 1px solid rgba(200,116,138,0.12);
    box-shadow: 0 20px 48px rgba(36,18,25,0.07);
    animation: fadeUp .6s ease both;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;
}
.seller-hero-left {}
.hero-kicker { color:var(--rose); font-size:.70rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:8px; }
.hero-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2.2rem,4vw,3.2rem); color:var(--text); line-height:1; }
.hero-sub    { color:var(--text-light); margin-top:8px; font-size:.92rem; }

.btn-add {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 24px; border-radius: 999px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; text-decoration: none; font-size:.80rem; letter-spacing:.14em; text-transform:uppercase;
    transition: transform .22s, box-shadow .22s; white-space: nowrap;
}
.btn-add:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(200,116,138,0.28); }

.alert-success {
    padding:14px 20px; border-radius:16px; margin-bottom:20px;
    background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.22);
}
.alert-error {
    padding:14px 20px; border-radius:16px; margin-bottom:20px;
    background:rgba(212,98,98,0.10); color:#a03030; border:1px solid rgba(212,98,98,0.18);
}

/* Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.product-card {
    background: rgba(255,255,255,0.97);
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 12px 32px rgba(36,18,25,0.06);
    transition: transform .25s, box-shadow .25s;
    animation: fadeUp .7s ease both;
}
.product-card:hover { transform: translateY(-5px); box-shadow: 0 22px 48px rgba(36,18,25,0.10); }

.product-img-wrap {
    position: relative; overflow: hidden;
    height: 200px; background: rgba(200,116,138,0.07);
}
.product-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .4s ease;
}
.product-card:hover .product-img-wrap img { transform: scale(1.04); }
.product-img-ph {
    width:100%; height:100%; display:flex; align-items:center; justify-content:center;
    font-size: 3rem; color: rgba(200,116,138,0.30);
}

.status-badge {
    position: absolute; top: 12px; right: 12px;
    padding: 5px 11px; border-radius: 999px; font-size:.62rem; letter-spacing:.14em; text-transform:uppercase; font-weight:600;
}
.badge-active   { background:rgba(98,184,128,0.90); color:#fff; }
.badge-inactive { background:rgba(212,98,98,0.85);  color:#fff; }

.product-body { padding: 18px 20px; }
.product-name { font-family:'Cormorant Garamond',serif; font-size:1.25rem; color:var(--text); margin-bottom:4px; font-weight:500; }
.product-cat  { color:var(--text-light); font-size:.78rem; letter-spacing:.10em; text-transform:uppercase; margin-bottom:10px; }
.product-price { color:var(--rose-deep); font-size:1.1rem; font-weight:600; margin-bottom:14px; }
.product-stock { color:var(--text-light); font-size:.82rem; margin-bottom:14px; }

.card-actions { display:flex; gap:8px; }
.act-btn {
    flex: 1; padding:9px 0; border-radius:999px; font-size:.70rem; letter-spacing:.12em;
    text-transform:uppercase; text-decoration:none; border:none; cursor:pointer;
    transition:transform .2s; display:inline-flex; align-items:center; justify-content:center;
    text-align: center;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit   { background:rgba(201,169,110,0.15); color:#7a5a1a; border:1px solid rgba(201,169,110,0.22); }
.act-danger { background:rgba(212,98,98,0.12); color:#a03030; border:1px solid rgba(212,98,98,0.20); }

/* Empty */
.empty-state {
    text-align:center; padding:60px 20px;
    background:rgba(255,255,255,0.96);
    border:1px solid rgba(200,116,138,0.10);
    border-radius:28px;
    box-shadow:0 14px 36px rgba(36,18,25,0.05);
}
.empty-icon  { font-size:3.5rem; margin-bottom:16px; }
.empty-title { font-family:'Cormorant Garamond',serif; font-size:2rem; color:var(--text); margin-bottom:10px; }
.empty-sub   { color:var(--text-light); margin-bottom:24px; }

.pagination-wrap { margin-top:28px; display:flex; justify-content:center; }

.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:22px;
}
.back-link:hover { text-decoration:underline; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@media (max-width:600px) {
    .seller-hero { flex-direction:column; }
}
</style>

<div class="seller-page">
    <a href="{{ route('profile.index') }}" class="back-link">← Mon profil</a>

    <div class="seller-hero">
        <div class="seller-hero-left">
            <div class="hero-kicker">Espace vendeur</div>
            <h1 class="hero-title">Mes annonces</h1>
            <p class="hero-sub">{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} en ligne</p>
        </div>
        <a href="{{ route('user.products.create') }}" class="btn-add">+ Ajouter un produit</a>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">✗ {{ session('error') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🛍</div>
            <div class="empty-title">Aucun produit pour le moment</div>
            <p class="empty-sub">Commencez à vendre en ajoutant votre premier produit.</p>
            <a href="{{ route('user.products.create') }}" class="btn-add" style="display:inline-flex;">
                + Ajouter mon premier produit
            </a>
        </div>
    @else
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-img-wrap">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-img-ph">🌸</div>
                        @endif
                        <span class="status-badge {{ $product->active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $product->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <div class="product-body">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-cat">{{ $product->category->name ?? '—' }}</div>
                        <div class="product-price">{{ number_format($product->price, 2) }} TND</div>
                        <div class="product-stock">Stock : {{ $product->stock }}</div>
                        <div class="card-actions">
                            <a href="{{ route('user.products.edit', $product) }}" class="act-btn act-edit">Modifier</a>
                            <form method="POST" action="{{ route('user.products.destroy', $product) }}"
                                  onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn act-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $products->links('pagination.custom') }}
        </div>
    @endif
</div>
@endsection
