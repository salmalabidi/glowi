@extends('layouts.app')

@section('content')
<style>
/* ═══════════════════════════════════════════════
   ADMIN DASHBOARD — GLOWI
═══════════════════════════════════════════════ */
.admin-page {
    max-width: 1380px;
    margin: 0 auto;
    padding: 52px 32px 100px;
}

/* ── Hero ── */
.admin-hero {
    position: relative;
    overflow: hidden;
    border-radius: 30px;
    padding: 36px 40px;
    margin-bottom: 28px;
    background:
        radial-gradient(circle at 12% 18%, rgba(200,116,138,0.18), transparent 30%),
        radial-gradient(circle at 90% 30%, rgba(201,169,110,0.14), transparent 28%),
        linear-gradient(135deg, rgba(255,255,255,0.96), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.12);
    box-shadow: 0 24px 50px rgba(36,18,25,0.07);
    animation: fadeSlideUp 0.6s ease both;
}

.admin-kicker {
    color: var(--rose);
    font-size: 0.70rem;
    letter-spacing: 0.26em;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.admin-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.6rem, 4.5vw, 4rem);
    color: var(--text);
    line-height: 1;
    margin-bottom: 10px;
}

.admin-subtitle {
    color: var(--text-light);
    max-width: 680px;
    line-height: 1.8;
}

.admin-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 22px;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 20px;
    border-radius: 999px;
    text-decoration: none;
    font-size: 0.74rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    transition: transform .22s, box-shadow .22s, background .22s;
    border: none;
    cursor: pointer;
}
.admin-btn.primary {
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
}
.admin-btn.secondary {
    background: rgba(200,116,138,0.08);
    color: var(--rose-deep);
    border: 1px solid rgba(200,116,138,0.14);
}
.admin-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(200,116,138,0.20);
}

.dashboard-mini-links {
    display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px;
}
.dashboard-mini-link {
    padding: 9px 14px;
    border-radius: 999px;
    background: rgba(200,116,138,0.07);
    color: var(--rose-deep);
    text-decoration: none;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    border: 1px solid rgba(200,116,138,0.10);
    transition: transform .2s, background .2s;
}
.dashboard-mini-link:hover { transform: translateY(-2px); background: rgba(200,116,138,0.13); }

/* ── Stat cards ── */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin: 26px 0;
}

.admin-card {
    position: relative;
    overflow: hidden;
    background: linear-gradient(170deg, rgba(255,255,255,0.97), rgba(255,255,255,0.88));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 22px;
    padding: 22px 24px;
    box-shadow: 0 14px 36px rgba(36,18,25,0.06);
    animation: fadeSlideUp 0.7s ease both;
    transition: transform .25s, box-shadow .25s;
}
.admin-card:hover { transform: translateY(-5px); box-shadow: 0 22px 48px rgba(36,18,25,0.10); }
.admin-card::after {
    content: '';
    position: absolute; top: -28px; right: -28px;
    width: 90px; height: 90px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,116,138,0.13), transparent 70%);
}
.admin-card:nth-child(2) { animation-delay:.05s }
.admin-card:nth-child(3) { animation-delay:.10s }
.admin-card:nth-child(4) { animation-delay:.15s }
.admin-card:nth-child(5) { animation-delay:.20s }
.admin-card:nth-child(6) { animation-delay:.25s }
.admin-card:nth-child(7) { animation-delay:.30s }
.admin-card:nth-child(8) { animation-delay:.35s }

.admin-card-label {
    color: var(--text-light);
    font-size: 0.68rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.admin-card-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    line-height: 1;
}
.admin-card-note {
    margin-top: 8px;
    color: var(--rose-deep);
    font-size: 0.80rem;
}

/* ── Charts ── */
.charts-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
    margin: 24px 0;
}
.charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
.chart-panel {
    background: linear-gradient(170deg, rgba(255,255,255,0.97), rgba(255,255,255,0.88));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 24px;
    padding: 26px;
    box-shadow: 0 16px 40px rgba(36,18,25,0.06);
    animation: fadeSlideUp 0.9s ease both;
}
.chart-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem;
    color: var(--text);
    margin-bottom: 18px;
}
.chart-wrap {
    position: relative;
    height: 240px;
}

/* ── Tables ── */
.admin-panels {
    display: grid;
    grid-template-columns: 1.25fr 1fr;
    gap: 20px;
}
.admin-panel {
    background: linear-gradient(170deg, rgba(255,255,255,0.97), rgba(255,255,255,0.88));
    border: 1px solid rgba(200,116,138,0.10);
    border-radius: 26px;
    padding: 26px;
    box-shadow: 0 18px 42px rgba(36,18,25,0.06);
    animation: fadeSlideUp 0.95s ease both;
}
.admin-panel-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    color: var(--text);
    margin-bottom: 14px;
}
.admin-panel-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}
.admin-table { display: flex; flex-direction: column; gap: 10px; }
.admin-row {
    display: grid;
    grid-template-columns: 1.2fr 1fr auto;
    gap: 12px;
    align-items: center;
    padding: 12px 16px;
    border-radius: 16px;
    background: rgba(200,116,138,0.04);
    border: 1px solid rgba(200,116,138,0.08);
    transition: transform .2s, background .2s;
}
.admin-row:hover { transform: translateX(4px); background: rgba(200,116,138,0.08); }
.admin-row strong { color: var(--text); font-size: 0.92rem; }
.admin-row span { color: var(--text-light); font-size: 0.88rem; }

.status-pill {
    padding: 6px 13px;
    border-radius: 999px;
    font-size: 0.66rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    font-weight: 600;
    white-space: nowrap;
}
.status-pending   { background: rgba(230,185,120,0.14); color: #a86d12; }
.status-validated { background: rgba(98,184,128,0.14);  color: #2f7a47; }
.status-cancelled { background: rgba(212,98,98,0.14);   color: #a63d3d; }

@keyframes fadeSlideUp {
    from { opacity:0; transform:translateY(16px); filter:blur(3px); }
    to   { opacity:1; transform:translateY(0);    filter:blur(0);   }
}

@media (max-width: 1100px) {
    .admin-grid     { grid-template-columns: repeat(2,1fr); }
    .admin-panels   { grid-template-columns: 1fr; }
    .charts-grid    { grid-template-columns: 1fr; }
    .charts-row     { grid-template-columns: 1fr; }
}
@media (max-width: 700px) {
    .admin-page     { padding: 36px 16px 80px; }
    .admin-grid     { grid-template-columns: 1fr; }
    .admin-row      { grid-template-columns: 1fr; }
}
</style>

<div class="admin-page">

    {{-- ── HERO ── --}}
    <div class="admin-hero">
        <div class="admin-kicker">Dashboard administrateur</div>
        <h1 class="admin-title">Pilotage du site</h1>
        <p class="admin-subtitle">
            Vue analytique complète · Gérez les utilisateurs, produits et commandes depuis un seul espace.
        </p>

        <div class="admin-actions">
            <a href="{{ route('admin.users.index') }}"    class="admin-btn primary">👤 Utilisateurs</a>
            <a href="{{ route('admin.products.index') }}" class="admin-btn secondary">🛍 Produits</a>
            <a href="{{ route('admin.orders.index') }}"   class="admin-btn secondary">📦 Commandes</a>
        </div>

        <div class="dashboard-mini-links">
            <a href="{{ route('profile.index') }}" class="dashboard-mini-link">Mon profil</a>
            <a href="{{ route('orders') }}"        class="dashboard-mini-link">Mes commandes</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="dashboard-mini-link" style="background:none">Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
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
            <div class="admin-card-value">{{ number_format($totalRevenue, 2) }}</div>
            <div class="admin-card-note">TND confirmé</div>
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
            <div class="admin-card-value">{{ number_format($pendingRevenue, 2) }}</div>
            <div class="admin-card-note">TND non validé</div>
        </div>
    </div>

    {{-- ── CHARTS LIGNE 1 ── --}}
    <div class="charts-grid">
        <div class="chart-panel">
            <div class="chart-title">Revenus mensuels</div>
            <div class="chart-wrap">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="chart-panel">
            <div class="chart-title">Statuts des commandes</div>
            <div class="chart-wrap">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── CHARTS LIGNE 2 ── --}}
    <div class="charts-row">
        <div class="chart-panel">
            <div class="chart-title">Nouveaux clients / mois</div>
            <div class="chart-wrap">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
        <div class="chart-panel">
            <div class="chart-title">Top 5 produits commandés</div>
            <div class="chart-wrap">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── TABLES ── --}}
    <div class="admin-panels">
        <div class="admin-panel">
            <div class="admin-panel-actions">
                <div class="admin-panel-title">Dernières commandes</div>
                <a href="{{ route('admin.orders.index') }}" class="admin-btn secondary" style="font-size:.68rem; padding:8px 14px">Voir tout →</a>
            </div>
            <div class="admin-table">
                @forelse($latestOrders as $order)
                    <div class="admin-row">
                        <div>
                            <strong>Commande #{{ $order->id }}</strong><br>
                            <span>{{ $order->user->name ?? 'Utilisateur supprimé' }}</span>
                        </div>
                        <span>{{ number_format($order->total ?? 0, 2) }} TND</span>
                        <span class="status-pill status-{{ $order->status }}">{{ $order->status }}</span>
                    </div>
                @empty
                    <div class="admin-row"><span>Aucune commande récente.</span></div>
                @endforelse
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-actions">
                <div class="admin-panel-title">Derniers utilisateurs</div>
                <a href="{{ route('admin.users.index') }}" class="admin-btn secondary" style="font-size:.68rem; padding:8px 14px">Voir tout →</a>
            </div>
            <div class="admin-table">
                @forelse($latestUsers as $user)
                    <div class="admin-row">
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <span>{{ $user->email }}</span>
                        </div>
                        <span>{{ $user->is_admin ? 'Admin' : 'Client' }}</span>
                        <span class="status-pill {{ $user->is_admin ? 'status-validated' : 'status-pending' }}">
                            {{ $user->is_admin ? 'admin' : 'client' }}
                        </span>
                    </div>
                @empty
                    <div class="admin-row"><span>Aucun utilisateur.</span></div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ── CHART.JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const rose      = '#c8748a';
const roseLight = 'rgba(200,116,138,0.15)';
const gold      = '#c9a96e';
const goldLight = 'rgba(201,169,110,0.15)';
const green     = '#62b880';
const greenL    = 'rgba(98,184,128,0.15)';
const red       = '#d46262';
const redL      = 'rgba(212,98,98,0.15)';

Chart.defaults.font.family = "'Jost', sans-serif";
Chart.defaults.color       = '#7a5c68';

// ── 1) Revenus mensuels ──────────────────────────────────────
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: @json($revenueLabels),
        datasets: [{
            label: 'Revenus (TND)',
            data: @json($revenueData),
            borderColor: rose,
            backgroundColor: roseLight,
            borderWidth: 2.5,
            tension: 0.45,
            fill: true,
            pointBackgroundColor: rose,
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: 'rgba(200,116,138,0.08)' }, ticks: { callback: v => v + ' TND' } },
            x: { grid: { display: false } }
        }
    }
});

// ── 2) Statuts (donut) ────────────────────────────────────────
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['En attente', 'Validées', 'Annulées'],
        datasets: [{
            data: [
                {{ $orderStatusData['pending'] }},
                {{ $orderStatusData['validated'] }},
                {{ $orderStatusData['cancelled'] }}
            ],
            backgroundColor: [gold, green, red],
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '62%',
        plugins: {
            legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
        }
    }
});

// ── 3) Nouveaux clients / mois ────────────────────────────────
new Chart(document.getElementById('usersChart'), {
    type: 'bar',
    data: {
        labels: @json($usersLabels),
        datasets: [{
            label: 'Nouveaux clients',
            data: @json($usersData),
            backgroundColor: goldLight,
            borderColor: gold,
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(200,116,138,0.08)' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});

// ── 4) Top produits (horizontal bar) ─────────────────────────
new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: @json($topProductLabels),
        datasets: [{
            label: 'Quantité commandée',
            data: @json($topProductData),
            backgroundColor: [rose, gold, green, roseLight, goldLight].map((c,i) => [rose,gold,green,'#9b7ab8','#7ab8a9'][i]),
            borderRadius: 8,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, grid: { color: 'rgba(200,116,138,0.08)' } },
            y: { grid: { display: false } }
        }
    }
});
</script>
@endsection
