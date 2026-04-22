@extends('layouts.app')

@section('content')
<style>
.admin-page { max-width: 1280px; margin: 0 auto; padding: 52px 32px 100px; }

.page-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
}
.page-kicker { color: var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); }

.admin-btn {
    display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px;
    border-radius: 999px; text-decoration: none; font-size: .74rem; letter-spacing: .14em;
    text-transform: uppercase; transition: transform .22s, box-shadow .22s; border: none; cursor: pointer;
}
.admin-btn.primary { background: linear-gradient(135deg, var(--rose), var(--rose-deep)); color: #fff; }
.admin-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(200,116,138,0.20); }

.filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 22px; }
.filter-bar input, .filter-bar select {
    padding: 10px 16px; border-radius: 999px;
    border: 1px solid rgba(200,116,138,0.18); background: rgba(255,255,255,0.92);
    color: var(--text); font-family:'Jost',sans-serif; font-size:.86rem; outline:none;
}
.filter-bar input:focus, .filter-bar select:focus { border-color: var(--rose); }
.filter-btn {
    padding: 10px 20px; border-radius: 999px;
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff; border: none; font-size:.78rem; letter-spacing:.12em; text-transform:uppercase;
    cursor:pointer; transition: transform .2s;
}
.filter-btn:hover { transform: translateY(-2px); }

.data-table {
    background: rgba(255,255,255,0.97); border: 1px solid rgba(200,116,138,0.10);
    border-radius: 24px; overflow: hidden; box-shadow: 0 18px 42px rgba(36,18,25,0.06);
}
.data-table table { width:100%; border-collapse:collapse; }
.data-table th {
    background: rgba(200,116,138,0.07); color: var(--text-light); font-size:.68rem;
    letter-spacing:.18em; text-transform:uppercase; padding:14px 18px; text-align:left;
    border-bottom: 1px solid rgba(200,116,138,0.10);
}
.data-table td {
    padding: 12px 18px; border-bottom: 1px solid rgba(200,116,138,0.06);
    font-size:.88rem; color:var(--text); vertical-align:middle;
}
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td { background: rgba(200,116,138,0.04); }

.product-img {
    width: 46px; height: 46px; border-radius: 10px;
    object-fit: cover; border: 1px solid rgba(200,116,138,0.15);
}
.product-img-ph {
    width: 46px; height: 46px; border-radius: 10px;
    background: rgba(200,116,138,0.10); display:flex; align-items:center; justify-content:center;
    font-size: 1.2rem;
}

.badge {
    padding: 5px 12px; border-radius: 999px; font-size:.64rem; letter-spacing:.12em;
    text-transform:uppercase; font-weight:600;
}
.badge-active   { background: rgba(98,184,128,0.14); color:#2f7a47; }
.badge-inactive { background: rgba(212,98,98,0.12);  color:#a03030; }
.badge-low      { background: rgba(230,185,120,0.14); color:#a86d12; }

.action-group { display:flex; gap:7px; align-items:center; flex-wrap:wrap; }
.act-btn {
    padding: 5px 12px; border-radius: 999px; font-size:.66rem; letter-spacing:.10em;
    text-transform:uppercase; text-decoration:none; border:none; cursor:pointer;
    transition:transform .2s; display:inline-flex; align-items:center;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit   { background: rgba(201,169,110,0.14); color:#7a5a1a; border:1px solid rgba(201,169,110,0.20); }
.act-danger { background: rgba(212,98,98,0.12);   color:#a03030; border:1px solid rgba(212,98,98,0.18); }
.act-toggle { background: rgba(200,116,138,0.10); color:var(--rose-deep); border:1px solid rgba(200,116,138,0.18); }

.alert-success {
    padding:14px 20px; border-radius:16px; margin-bottom:18px;
    background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.20); font-size:.90rem;
}
.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:24px;
}
.back-link:hover { text-decoration:underline; }
.pagination-wrap { margin-top:22px; display:flex; justify-content:center; }
</style>

<div class="admin-page">
    <a href="{{ route('admin.dashboard') }}" class="back-link">← Retour au dashboard</a>

    <div class="page-header">
        <div>
            <div class="page-kicker">Administration</div>
            <h1 class="page-title">Gestion des produits</h1>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-btn primary">+ Nouveau produit</a>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.products.index') }}">
        <div class="filter-bar">
            <input type="text" name="search" placeholder="Rechercher par nom ou marque…" value="{{ request('search') }}">
            <select name="category">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="stock">
                <option value="">Tous les stocks</option>
                <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Rupture</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Stock faible (≤5)</option>
            </select>
            <button type="submit" class="filter-btn">Filtrer</button>
            @if(request()->hasAny(['search','category','stock']))
                <a href="{{ route('admin.products.index') }}" class="act-btn act-edit">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Marque</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="product-img" alt="">
                            @else
                                <div class="product-img-ph">🛍</div>
                            @endif
                        </td>
                        <td><strong>{{ Str::limit($product->name, 40) }}</strong></td>
                        <td>{{ $product->brand ?? '—' }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>{{ number_format($product->price, 2) }} TND</td>
                        <td>
                            @if($product->stock <= 0)
                                <span class="badge badge-inactive">Rupture</span>
                            @elseif($product->stock <= 5)
                                <span class="badge badge-low">{{ $product->stock }} restants</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $product->active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $product->active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.products.edit', $product) }}" class="act-btn act-edit">Éditer</a>

                                <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="act-btn act-toggle">
                                        {{ $product->active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:var(--text-light)">
                            Aucun produit trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $products->links('pagination.custom') }}
    </div>
</div>
@endsection
