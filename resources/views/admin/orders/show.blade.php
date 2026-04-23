@extends('layouts.app')

@section('content')
<style>
.admin-page { max-width: 900px; margin: 0 auto; padding: 52px 32px 100px; }
.page-kicker { color:var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); margin-bottom:28px; }
.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:24px;
}
.back-link:hover { text-decoration:underline; }

.order-panel {
    background:rgba(255,255,255,0.97); border:1px solid rgba(200,116,138,0.12);
    border-radius:26px; padding:32px; box-shadow:0 18px 42px rgba(36,18,25,0.07);
    margin-bottom:20px;
}

.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px 28px; margin-bottom:24px; }
.info-item {}
.info-label { color:var(--text-light); font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; margin-bottom:4px; }
.info-value { color:var(--text); font-size:.96rem; font-weight:500; }

.status-pill {
    padding:6px 14px; border-radius:999px; font-size:.68rem; letter-spacing:.14em;
    text-transform:uppercase; font-weight:600;
}
.status-pending   { background:rgba(230,185,120,0.16); color:#a86d12; }
.status-validated { background:rgba(98,184,128,0.16);  color:#2f7a47; }
.status-cancelled { background:rgba(212,98,98,0.16);   color:#a03030; }

.section-title { font-family:'Cormorant Garamond',serif; font-size:1.6rem; color:var(--text); margin-bottom:16px; }

.items-table { width:100%; border-collapse:collapse; }
.items-table th {
    background:rgba(200,116,138,0.07); color:var(--text-light); font-size:.66rem;
    letter-spacing:.16em; text-transform:uppercase; padding:12px 16px; text-align:left;
    border-bottom:1px solid rgba(200,116,138,0.10);
}
.items-table td {
    padding:12px 16px; border-bottom:1px solid rgba(200,116,138,0.07);
    font-size:.90rem; color:var(--text); vertical-align:middle;
}
.items-table tr:last-child td { border-bottom:none; }
.product-img {
    width:44px; height:44px; border-radius:9px;
    object-fit:cover; border:1px solid rgba(200,116,138,0.14);
}
.total-row { display:flex; justify-content:flex-end; margin-top:16px; gap:40px; }
.total-label { color:var(--text-light); font-size:.82rem; }
.total-value { font-family:'Cormorant Garamond',serif; font-size:1.5rem; color:var(--text); }

.status-form {
    display:flex; align-items:center; gap:12px; flex-wrap:wrap;
}
.form-select {
    padding:10px 16px; border-radius:14px; border:1px solid rgba(200,116,138,0.18);
    background:rgba(253,246,240,0.70); color:var(--text); font-family:'Jost',sans-serif;
    font-size:.90rem; outline:none; transition:border-color .2s;
}
.form-select:focus { border-color:var(--rose); }
.btn-save {
    padding:11px 22px; border-radius:999px;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; border:none; font-size:.78rem; letter-spacing:.14em; text-transform:uppercase;
    cursor:pointer; transition:transform .2s, box-shadow .2s;
}
.btn-save:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(200,116,138,0.22); }

.alert-success {
    padding:14px 20px; border-radius:16px; margin-bottom:18px;
    background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.20); font-size:.90rem;
}
@media (max-width:600px) { .info-grid { grid-template-columns:1fr; } }
</style>

<div class="admin-page">
    <a href="{{ route('admin.orders.index') }}" class="back-link">← Retour aux commandes</a>

    <div class="page-kicker">Administration</div>
    <h1 class="page-title">Commande #{{ $order->id }}</h1>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    {{-- Infos générales --}}
    <div class="order-panel">
        <div class="section-title">Informations générales</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Client</div>
                <div class="info-value">{{ $order->user->name ?? 'Utilisateur supprimé' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $order->user->email ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Statut actuel</div>
                <div class="info-value">
                    <span class="status-pill status-{{ $order->status }}">{{ $order->status }}</span>
                </div>
            </div>
        </div>

        {{-- Changer le statut --}}
        <div class="section-title" style="font-size:1.2rem;margin-bottom:12px">Modifier le statut</div>
        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="status-form">
            @csrf @method('PUT')
            <select name="status" class="form-select">
                <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>En attente</option>
                <option value="validated" {{ $order->status === 'validated' ? 'selected' : '' }}>Validée</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
            </select>
            <button type="submit" class="btn-save">Enregistrer</button>
        </form>

        {{-- Étape de livraison --}}
        <div class="section-title" style="font-size:1.2rem;margin-bottom:12px;margin-top:22px;">Étape de livraison</div>
        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="status-form">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="{{ $order->status }}">
            <select name="delivery_step" class="form-select">
                <option value="0" {{ ($order->delivery_step??0)==0 ? 'selected' : '' }}>0 — Commande confirmée</option>
                <option value="1" {{ ($order->delivery_step??0)==1 ? 'selected' : '' }}>1 — En préparation</option>
                <option value="2" {{ ($order->delivery_step??0)==2 ? 'selected' : '' }}>2 — Prête pour collecte</option>
                <option value="3" {{ ($order->delivery_step??0)==3 ? 'selected' : '' }}>3 — Collectée par le livreur</option>
                <option value="4" {{ ($order->delivery_step??0)==4 ? 'selected' : '' }}>4 — En cours de livraison</option>
                <option value="5" {{ ($order->delivery_step??0)==5 ? 'selected' : '' }}>5 — Livrée ✓</option>
            </select>
            <button type="submit" class="btn-save">Mettre à jour</button>
        </form>
    </div>

    {{-- Articles --}}
    <div class="order-panel">
        <div class="section-title">Articles commandés</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="product-img" alt="">
                            @else
                                <div style="width:44px;height:44px;border-radius:9px;background:rgba(200,116,138,0.10);display:flex;align-items:center;justify-content:center;font-size:1.1rem">🛍</div>
                            @endif
                        </td>
                        <td><strong>{{ $item->product->name ?? 'Produit supprimé' }}</strong></td>
                        <td>{{ number_format($item->price ?? 0, 2) }} TND</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format(($item->price ?? 0) * $item->quantity, 2) }} TND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-row">
            <div>
                <div class="total-label">Total commande</div>
                <div class="total-value">{{ number_format($order->total ?? 0, 2) }} TND</div>
            </div>
        </div>
    </div>
</div>
@endsection
