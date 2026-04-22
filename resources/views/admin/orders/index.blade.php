@extends('layouts.app')

@section('content')
<style>
.admin-page { max-width: 1200px; margin: 0 auto; padding: 52px 32px 100px; }
.page-header {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:28px; flex-wrap:wrap; gap:16px;
}
.page-kicker { color:var(--rose); font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; margin-bottom:6px; }
.page-title  { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,4vw,3rem); color:var(--text); }
.back-link {
    display:inline-flex; align-items:center; gap:6px; color:var(--rose-deep);
    font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; text-decoration:none; margin-bottom:24px;
}
.back-link:hover { text-decoration:underline; }
.filter-bar { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:22px; }
.filter-bar input, .filter-bar select {
    padding:10px 16px; border-radius:999px; border:1px solid rgba(200,116,138,0.18);
    background:rgba(255,255,255,0.92); color:var(--text); font-family:'Jost',sans-serif; font-size:.86rem; outline:none;
}
.filter-btn {
    padding:10px 20px; border-radius:999px;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; border:none; font-size:.78rem; letter-spacing:.12em; text-transform:uppercase;
    cursor:pointer; transition:transform .2s;
}
.filter-btn:hover { transform:translateY(-2px); }
.data-table {
    background:rgba(255,255,255,0.97); border:1px solid rgba(200,116,138,0.10);
    border-radius:24px; overflow:hidden; box-shadow:0 18px 42px rgba(36,18,25,0.06);
}
.data-table table { width:100%; border-collapse:collapse; }
.data-table th {
    background:rgba(200,116,138,0.07); color:var(--text-light); font-size:.68rem;
    letter-spacing:.18em; text-transform:uppercase; padding:14px 18px; text-align:left;
    border-bottom:1px solid rgba(200,116,138,0.10);
}
.data-table td {
    padding:13px 18px; border-bottom:1px solid rgba(200,116,138,0.06);
    font-size:.88rem; color:var(--text); vertical-align:middle;
}
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td { background:rgba(200,116,138,0.04); }
.status-pill {
    padding:5px 13px; border-radius:999px; font-size:.64rem; letter-spacing:.14em;
    text-transform:uppercase; font-weight:600;
}
.status-pending   { background:rgba(230,185,120,0.14); color:#a86d12; }
.status-validated { background:rgba(98,184,128,0.14);  color:#2f7a47; }
.status-cancelled { background:rgba(212,98,98,0.14);   color:#a03030; }
.action-group { display:flex; gap:7px; align-items:center; }
.act-btn {
    padding:5px 12px; border-radius:999px; font-size:.66rem; letter-spacing:.10em;
    text-transform:uppercase; text-decoration:none; border:none; cursor:pointer;
    transition:transform .2s; display:inline-flex; align-items:center;
}
.act-btn:hover { transform:translateY(-1px); }
.act-view   { background:rgba(201,169,110,0.14); color:#7a5a1a; border:1px solid rgba(201,169,110,0.20); }
.act-danger { background:rgba(212,98,98,0.12); color:#a03030; border:1px solid rgba(212,98,98,0.18); }
.alert-success {
    padding:14px 20px; border-radius:16px; margin-bottom:18px;
    background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.20); font-size:.90rem;
}
.pagination-wrap { margin-top:22px; display:flex; justify-content:center; }
</style>

<div class="admin-page">
    <a href="{{ route('admin.dashboard') }}" class="back-link">← Retour au dashboard</a>

    <div class="page-header">
        <div>
            <div class="page-kicker">Administration</div>
            <h1 class="page-title">Gestion des commandes</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.orders.index') }}">
        <div class="filter-bar">
            <input type="text" name="search" placeholder="N° commande ou nom client…" value="{{ request('search') }}">
            <select name="status">
                <option value="">Tous les statuts</option>
                <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
                <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>Validées</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
            </select>
            <button type="submit" class="filter-btn">Filtrer</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="act-btn act-view">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <div>
                                <strong>{{ $order->user->name ?? 'Utilisateur supprimé' }}</strong><br>
                                <span style="color:var(--text-light);font-size:.82rem">{{ $order->user->email ?? '' }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($order->total ?? 0, 2) }} TND</td>
                        <td>
                            <span class="status-pill status-{{ $order->status }}">{{ $order->status }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Détails</a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                      onsubmit="return confirm('Supprimer cette commande ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--text-light)">
                            Aucune commande trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $orders->links('pagination.custom') }}
    </div>
</div>
@endsection
