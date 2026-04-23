@extends('layouts.app')

@section('content')
<style>
:root { --rose:#c8748a; --rose-deep:#a85070; --text:#3d2030; --text-light:#7a5c68; --cream:#fdf6f0; }

.seller-page {
    max-width: 1200px; margin: 0 auto;
    padding: 40px 24px 100px;
}

/* ── PROFIL VENDEUR STYLE DABCHY ── */
.seller-profile-banner {
    position: relative;
    height: 180px;
    border-radius: 24px 24px 0 0;
    background: linear-gradient(135deg, #c8748a 0%, #a85070 40%, #c9a96e 100%);
    margin-bottom: 0;
    overflow: hidden;
}
.seller-profile-banner::after {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.seller-profile-card {
    background: rgba(255,255,255,0.98);
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 0 0 24px 24px;
    border-top: none;
    box-shadow: 0 20px 50px rgba(36,18,25,0.08);
    padding: 0 32px 28px;
    margin-bottom: 28px;
    position: relative;
}

.seller-avatar-wrap {
    position: absolute;
    top: -56px; left: 32px;
}
.seller-avatar {
    width: 110px; height: 110px; border-radius: 50%;
    border: 4px solid #fff;
    background: linear-gradient(135deg, #cf8ca0, #dcb177);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 2.4rem; font-weight: 700;
    box-shadow: 0 8px 24px rgba(36,18,25,0.14);
    overflow: hidden; cursor: pointer;
    transition: opacity .2s;
    position: relative;
}
.seller-avatar img { width:100%; height:100%; object-fit:cover; }
.seller-avatar:hover .avatar-overlay { opacity: 1; }
.avatar-overlay {
    position: absolute; inset: 0; border-radius: 50%;
    background: rgba(36,18,25,0.45);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .72rem; letter-spacing:.10em; text-transform:uppercase;
    opacity: 0; transition: opacity .2s;
}
#avatarFileInput { display:none; }

.seller-profile-info {
    padding-top: 72px;
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}
.seller-name  { font-family:'Cormorant Garamond',serif; font-size:2rem; color:var(--text); margin-bottom:4px; }
.seller-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(98,184,128,0.12); color:#2f7a47;
    border: 1px solid rgba(98,184,128,0.22);
    border-radius: 999px; padding: 4px 12px; font-size:.70rem; letter-spacing:.14em; text-transform:uppercase;
}
.seller-stats { display:flex; gap:28px; margin-top:12px; flex-wrap:wrap; }
.seller-stat  { text-align:center; }
.seller-stat-val   { font-family:'Cormorant Garamond',serif; font-size:1.6rem; color:var(--text); line-height:1; }
.seller-stat-label { color:var(--text-light); font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; }

.seller-profile-actions { display:flex; gap:10px; flex-wrap:wrap; }
.btn-primary {
    display:inline-flex; align-items:center; gap:7px; padding:11px 22px; border-radius:999px;
    background:linear-gradient(135deg,var(--rose),var(--rose-deep)); color:#fff;
    text-decoration:none; font-size:.76rem; letter-spacing:.14em; text-transform:uppercase;
    border:none; cursor:pointer; transition:transform .2s, box-shadow .2s;
}
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(200,116,138,0.28); }
.btn-secondary {
    display:inline-flex; align-items:center; gap:7px; padding:11px 22px; border-radius:999px;
    background:transparent; color:var(--rose-deep);
    border:1px solid rgba(200,116,138,0.25);
    text-decoration:none; font-size:.76rem; letter-spacing:.14em; text-transform:uppercase;
    transition:background .2s, transform .2s;
}
.btn-secondary:hover { background:rgba(200,116,138,0.07); transform:translateY(-1px); }

/* ── Alerts ── */
.alert { padding:13px 18px; border-radius:14px; margin-bottom:20px; font-size:.88rem; }
.alert-success { background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.22); }
.alert-error   { background:rgba(212,98,98,0.10); color:#a03030; border:1px solid rgba(212,98,98,0.18); }

/* ── Section title ── */
.section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
.section-title  { font-family:'Cormorant Garamond',serif; font-size:1.8rem; color:var(--text); }

/* ── Grid annonces ── */
.annonces-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 18px;
}

.annonce-card {
    background: rgba(255,255,255,0.98);
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 20px; overflow:hidden;
    box-shadow: 0 10px 28px rgba(36,18,25,0.06);
    transition: transform .25s, box-shadow .25s;
    position: relative;
}
.annonce-card:hover { transform:translateY(-5px); box-shadow:0 20px 44px rgba(36,18,25,0.10); }

.annonce-img { position:relative; height:200px; overflow:hidden; background:rgba(200,116,138,0.06); }
.annonce-img img { width:100%; height:100%; object-fit:cover; transition:transform .4s ease; }
.annonce-card:hover .annonce-img img { transform:scale(1.04); }
.annonce-img-ph { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:3rem; color:rgba(200,116,138,0.25); }

.annonce-status {
    position:absolute; top:10px; right:10px; padding:4px 10px;
    border-radius:999px; font-size:.60rem; letter-spacing:.14em; text-transform:uppercase; font-weight:600;
}
.badge-on  { background:rgba(98,184,128,0.90); color:#fff; }
.badge-off { background:rgba(212,98,98,0.85);  color:#fff; }

.annonce-body { padding:16px 18px; }
.annonce-name  { font-family:'Cormorant Garamond',serif; font-size:1.18rem; color:var(--text); margin-bottom:4px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.annonce-cat   { color:var(--text-light); font-size:.72rem; letter-spacing:.12em; text-transform:uppercase; margin-bottom:8px; }
.annonce-price { color:var(--rose-deep); font-size:1.05rem; font-weight:600; margin-bottom:4px; }
.annonce-stock { color:var(--text-light); font-size:.80rem; margin-bottom:14px; }

.annonce-actions { display:flex; gap:7px; }
.act { flex:1; padding:8px 0; border-radius:999px; font-size:.66rem; letter-spacing:.10em; text-transform:uppercase;
       text-decoration:none; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center;
       transition:transform .2s; }
.act:hover { transform:translateY(-1px); }
.act-edit   { background:rgba(201,169,110,0.14); color:#7a5a1a; border:1px solid rgba(201,169,110,0.22); }
.act-delete { background:rgba(212,98,98,0.10); color:#a03030; border:1px solid rgba(212,98,98,0.18); }

/* Empty */
.empty-state {
    text-align:center; padding:60px 20px;
    background:rgba(255,255,255,0.97); border:1px solid rgba(200,116,138,0.10);
    border-radius:24px; box-shadow:0 14px 36px rgba(36,18,25,0.05);
}
.empty-icon  { font-size:3.5rem; margin-bottom:14px; }
.empty-title { font-family:'Cormorant Garamond',serif; font-size:1.9rem; color:var(--text); margin-bottom:8px; }
.empty-sub   { color:var(--text-light); margin-bottom:22px; }

.pagination-wrap { margin-top:28px; display:flex; justify-content:center; }

.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.76rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:20px;
}
.back-link:hover { text-decoration:underline; }

@media (max-width:700px) {
    .seller-page { padding:24px 14px 80px; }
    .seller-profile-card { padding:0 16px 22px; }
    .seller-profile-info { padding-top:66px; }
}
</style>

<div class="seller-page">
    <a href="{{ route('profile.index') }}" class="back-link">← Mon profil</a>

    {{-- ── PROFIL VENDEUR STYLE DABCHY ── --}}
    <div class="seller-profile-banner"></div>

    <div class="seller-profile-card">

        {{-- Avatar uploadable --}}
        <div class="seller-avatar-wrap">
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
                @csrf @method('PATCH')
                <input type="file" id="avatarFileInput" name="avatar" accept="image/*"
                       onchange="document.getElementById('avatarForm').submit()">
            </form>
            <label for="avatarFileInput">
                <div class="seller-avatar">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="avatar">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                    <div class="avatar-overlay">📷 Changer</div>
                </div>
            </label>
        </div>

        <div class="seller-profile-info">
            <div>
                <div class="seller-name">{{ auth()->user()->name }}</div>
                <span class="seller-badge">✓ Vendeur actif</span>
                <div class="seller-stats">
                    <div class="seller-stat">
                        <div class="seller-stat-val">{{ $products->total() }}</div>
                        <div class="seller-stat-label">Annonces</div>
                    </div>
                    <div class="seller-stat">
                        <div class="seller-stat-val">{{ auth()->user()->orders()->count() }}</div>
                        <div class="seller-stat-label">Commandes</div>
                    </div>
                </div>
            </div>

            <div class="seller-profile-actions">
                <a href="{{ route('user.products.create') }}" class="btn-primary">+ Ajouter un produit</a>
                <a href="{{ route('chat.index') }}" class="btn-secondary">💬 Chat</a>
                <a href="{{ route('profile.index') }}" class="btn-secondary">⚙ Paramètres</a>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">✗ {{ session('error') }}</div>
    @endif

    {{-- Annonces --}}
    <div class="section-header">
        <div class="section-title">Mes annonces</div>
    </div>

    @if($products->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🛍</div>
            <div class="empty-title">Aucun produit pour le moment</div>
            <p class="empty-sub">Commencez à vendre en ajoutant votre premier produit.</p>
            <a href="{{ route('user.products.create') }}" class="btn-primary" style="display:inline-flex;">
                + Ajouter mon premier produit
            </a>
        </div>
    @else
        <div class="annonces-grid">
            @foreach($products as $product)
                <div class="annonce-card">
                    <div class="annonce-img">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="annonce-img-ph">🌸</div>
                        @endif
                        <span class="annonce-status {{ $product->active ? 'badge-on' : 'badge-off' }}">
                            {{ $product->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <div class="annonce-body">
                        <div class="annonce-name" title="{{ $product->name }}">{{ $product->name }}</div>
                        <div class="annonce-cat">{{ $product->category->name ?? '—' }}</div>
                        <div class="annonce-price">{{ number_format($product->price, 2) }} TND</div>
                        <div class="annonce-stock">{{ $product->stock }} en stock</div>
                        <div class="annonce-actions">
                            <a href="{{ route('user.products.edit', $product) }}" class="act act-edit">✏ Modifier</a>
                            <form method="POST" action="{{ route('user.products.destroy', $product) }}"
                                  onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act act-delete">🗑 Supprimer</button>
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
