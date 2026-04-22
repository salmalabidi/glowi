@extends('layouts.app')

@section('content')
<style>
.admin-page {
    max-width: 1360px;
    margin: 0 auto;
    padding: 56px 32px 100px;
}

.admin-hero {
    position: relative;
    overflow: hidden;
    border-radius: 30px;
    padding: 34px 34px;
    margin-bottom: 28px;
    background:
        radial-gradient(circle at 12% 18%, rgba(200,116,138,0.16), transparent 25%),
        radial-gradient(circle at 90% 30%, rgba(201,169,110,0.14), transparent 28%),
        linear-gradient(135deg, rgba(255,255,255,0.92), rgba(255,255,255,0.82));
    border: 1px solid rgba(200,116,138,0.10);
    box-shadow: 0 24px 50px rgba(36,18,25,0.07);
    animation: fadeSlideUp 0.7s ease both;
}

.admin-kicker {
    color: var(--rose);
    font-size: 0.72rem;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.admin-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5vw, 4.3rem);
    color: var(--text);
    line-height: 1;
    margin-bottom: 12px;
}

.admin-subtitle {
    color: var(--text-light);
    max-width: 760px;
    line-height: 1.8;
}

.admin-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 24px;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 18px;
    border-radius: 999px;
    text-decoration: none;
    font-size: 0.78rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
}

.admin-btn.primary {
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
}

.admin-btn.secondary {
    background: rgba(200,116,138,0.08);
    color: var(--rose-deep);
    border: 1px solid rgba(200,116,138,0.12);
}

.admin-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(200,116,138,0.18);
}

.admin-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin: 30px 0;
}

.admin-card {
    position: relative;
    overflow: hidden;
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 24px;
    padding: 22px;
    box-shadow: 0 18px 42px rgba(36,18,25,0.06);
    animation: fadeSlideUp 0.8s ease both;
    transition: transform .28s ease, box-shadow .28s ease;
}

.admin-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 24px 54px rgba(36,18,25,0.10);
}

.admin-card::after {
    content: '';
    position: absolute;
    top: -30px;
    right: -30px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,116,138,0.12), transparent 70%);
}

.admin-card:nth-child(2) { animation-delay: .05s; }
.admin-card:nth-child(3) { animation-delay: .10s; }
.admin-card:nth-child(4) { animation-delay: .15s; }
.admin-card:nth-child(5) { animation-delay: .20s; }
.admin-card:nth-child(6) { animation-delay: .25s; }
.admin-card:nth-child(7) { animation-delay: .30s; }
.admin-card:nth-child(8) { animation-delay: .35s; }

.admin-card-label {
    color: var(--text-light);
    font-size: 0.72rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.admin-card-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.1rem;
    color: var(--text);
    line-height: 1;
}

.admin-card-note {
    margin-top: 10px;
    color: var(--rose-deep);
    font-size: 0.82rem;
}

.admin-panels {
    display: grid;
    grid-template-columns: 1.25fr 1fr;
    gap: 22px;
}

.admin-panel {
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 28px;
    padding: 26px;
    box-shadow: 0 20px 46px rgba(36,18,25,0.06);
    animation: fadeSlideUp 0.9s ease both;
}

.admin-panel-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 16px;
}

.admin-table {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.admin-row {
    display: grid;
    grid-template-columns: 1.2fr 1fr auto;
    gap: 14px;
    align-items: center;
    padding: 14px 16px;
    border-radius: 18px;
    background: rgba(200,116,138,0.05);
    border: 1px solid rgba(200,116,138,0.08);
    transition: transform .22s ease, background .22s ease;
}

.admin-row:hover {
    transform: translateX(4px);
    background: rgba(200,116,138,0.08);
}

.admin-row strong {
    color: var(--text);
}

.admin-row span {
    color: var(--text-light);
    font-size: 0.92rem;
}

.status-pill {
    padding: 9px 14px;
    border-radius: 999px;
    font-size: 0.7rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    font-weight: 600;
}

.status-pending {
    background: rgba(230, 185, 120, 0.14);
    color: #a86d12;
}

.status-validated {
    background: rgba(98, 184, 128, 0.14);
    color: #2f7a47;
}

.status-cancelled {
    background: rgba(212, 98, 98, 0.14);
    color: #a63d3d;
}

.dashboard-mini-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 18px;
}

.dashboard-mini-link {
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(200,116,138,0.08);
    color: var(--rose-deep);
    text-decoration: none;
    font-size: 0.74rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    border: 1px solid rgba(200,116,138,0.10);
    transition: transform .22s ease, background .22s ease;
}

.dashboard-mini-link:hover {
    transform: translateY(-2px);
    background: rgba(200,116,138,0.14);
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(18px);
        filter: blur(4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}

@media (max-width: 1100px) {
    .admin-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .admin-panels {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 700px) {
    .admin-page {
        padding: 40px 18px 80px;
    }

    .admin-grid {
        grid-template-columns: 1fr;
    }

    .admin-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="admin-page">
    <div class="admin-hero">
        <div class="admin-kicker">Dashboard administrateur</div>
        <h1 class="admin-title">Pilotage du site</h1>
        <p class="admin-subtitle">
            Vue analytique complète du site. Gérez les utilisateurs, les produits et les commandes depuis un seul espace élégant et dynamique.
        </p>

        <div class="admin-actions">
            <a href="#" class="admin-btn primary">Utilisateurs</a>
            <a href="#" class="admin-btn secondary">Produits</a>
            <a href="#" class="admin-btn secondary">Commandes</a>
        </div>

        <div class="dashboard-mini-links">
            <a href="{{ route('profile.index') }}" class="dashboard-mini-link">Mon profil</a>
            <a href="{{ route('orders') }}" class="dashboard-mini-link">Mes commandes</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="dashboard-mini-link" style="background:none; cursor:none;">Déconnexion</button>
            </form>
        </div>
    </div>

    <div class="admin-grid">
        <div class="admin-card">
            <div class="admin-card-label">Utilisateurs</div>
            <div class="admin-card-value">{{ $usersCount }}</div>
            <div class="admin-card-note">{{ $adminsCount }} admin(s)</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Produits</div>
            <div class="admin-card-value">{{ $productsCount }}</div>
            <div class="admin-card-note">{{ $activeProductsCount }} actifs</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Commandes</div>
            <div class="admin-card-value">{{ $ordersCount }}</div>
            <div class="admin-card-note">{{ $pendingOrders }} en attente</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Revenu validé</div>
            <div class="admin-card-value">{{ number_format($totalRevenue, 2) }} TND</div>
            <div class="admin-card-note">Total confirmé</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">En attente</div>
            <div class="admin-card-value">{{ $pendingOrders }}</div>
            <div class="admin-card-note">À confirmer</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Validées</div>
            <div class="admin-card-value">{{ $validatedOrders }}</div>
            <div class="admin-card-note">Commandes confirmées</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Annulées</div>
            <div class="admin-card-value">{{ $cancelledOrders }}</div>
            <div class="admin-card-note">Commandes rejetées</div>
        </div>

        <div class="admin-card">
            <div class="admin-card-label">Montant pending</div>
            <div class="admin-card-value">{{ number_format($pendingRevenue, 2) }} TND</div>
            <div class="admin-card-note">Valeur non validée</div>
        </div>
    </div>

    <div class="admin-panels">
        <div class="admin-panel">
            <div class="admin-panel-title">Dernières commandes</div>

            <div class="admin-table">
                @forelse($latestOrders as $order)
                    <div class="admin-row">
                        <div>
                            <strong>Commande #{{ $order->id }}</strong><br>
                            <span>{{ $order->user->name ?? 'Utilisateur supprimé' }}</span>
                        </div>

                        <span>{{ number_format($order->total ?? 0, 2) }} TND</span>

                        <span class="status-pill status-{{ $order->status }}">
                            {{ $order->status }}
                        </span>
                    </div>
                @empty
                    <div class="admin-row">
                        <span>Aucune commande récente.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-title">Derniers utilisateurs</div>

            <div class="admin-table">
                @forelse($latestUsers as $user)
                    <div class="admin-row">
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <span>{{ $user->email }}</span>
                        </div>

                        <span>{{ $user->is_admin ? 'Admin' : 'User' }}</span>

                        <span class="status-pill {{ $user->is_admin ? 'status-validated' : 'status-pending' }}">
                            {{ $user->is_admin ? 'admin' : 'client' }}
                        </span>
                    </div>
                @empty
                    <div class="admin-row">
                        <span>Aucun utilisateur.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection