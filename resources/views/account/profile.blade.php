@extends('layouts.app')

@section('content')
<style>
.profile-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 52px 48px 100px;
}

.profile-head {
    margin-bottom: 30px;
}

.profile-kicker {
    color: var(--rose);
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.profile-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.8rem, 5vw, 4rem);
    line-height: 1;
    color: var(--text);
    font-weight: 300;
}

.profile-subtitle {
    margin-top: 12px;
    color: var(--text-light);
    line-height: 1.8;
}

.profile-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 24px;
}

.profile-side,
.profile-main {
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.84));
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 28px;
    box-shadow: 0 18px 44px rgba(36,18,25,0.05);
}

.profile-side {
    padding: 28px 24px;
    text-align: center;
}

.profile-avatar {
    width: 110px;
    height: 110px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: linear-gradient(135deg, #cf8ca0, #dcb177);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 18px 34px rgba(200,116,138,0.18);
}

.profile-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 6px;
}

.profile-email {
    color: var(--text-light);
    font-size: 0.92rem;
    margin-bottom: 22px;
    word-break: break-word;
}

.profile-stat {
    padding: 14px 16px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(200,116,138,0.08), rgba(201,169,110,0.08));
    border: 1px solid rgba(200,116,138,0.10);
}

.profile-stat-label {
    display: block;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--rose-deep);
    margin-bottom: 8px;
}

.profile-stat-value {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text);
}

.profile-main {
    padding: 28px;
}

.profile-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 18px;
}

.profile-info-grid {
    display: grid;
    gap: 16px;
}

.info-box {
    padding: 18px 20px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(200,116,138,0.08), rgba(201,169,110,0.08));
    border: 1px solid rgba(200,116,138,0.10);
}

.info-label {
    display: block;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--rose-deep);
    margin-bottom: 8px;
}

.info-value {
    color: var(--text);
    font-size: 1rem;
    line-height: 1.7;
}

.profile-actions {
    margin-top: 24px;
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
}

.profile-btn {
    display: inline-block;
    padding: 12px 18px;
    border-radius: 14px;
    text-decoration: none;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-size: 0.72rem;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}

.profile-btn.primary {
    background: linear-gradient(135deg, var(--rose), var(--rose-deep));
    color: #fff;
}

.profile-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(200,116,138,0.18);
}

.profile-btn.secondary {
    background: rgba(255,255,255,0.8);
    color: var(--text);
    border: 1px solid rgba(200,116,138,0.14);
}

.profile-btn.secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(36,18,25,0.06);
}

.reveal-up {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.reveal-up.show {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 900px) {
    .profile-page {
        padding: 38px 24px 80px;
    }

    .profile-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-page">
    <div class="profile-head reveal-up">
        <div class="profile-kicker">Compte</div>
        <h1 class="profile-title">Mon profil</h1>
        <p class="profile-subtitle">
            Retrouvez vos informations personnelles dans un espace élégant, clair et cohérent avec l’univers Glowi.
        </p>
    </div>

    <div class="profile-layout">
        <div class="profile-side reveal-up">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>

            <div class="profile-stat">
                <span class="profile-stat-label">Commandes</span>
                <div class="profile-stat-value">{{ $ordersCount }}</div>
            </div>
        </div>

        <div class="profile-main reveal-up">
            <div class="profile-section-title">Informations personnelles</div>

            <div class="profile-info-grid">
                <div class="info-box">
                    <span class="info-label">Nom complet</span>
                    <div class="info-value">{{ $user->name }}</div>
                </div>

                <div class="info-box">
                    <span class="info-label">Adresse email</span>
                    <div class="info-value">{{ $user->email }}</div>
                </div>

                <div class="info-box">
                    <span class="info-label">Statut du compte</span>
                    <div class="info-value">Compte actif</div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('orders') }}" class="profile-btn primary">Mes commandes</a>
                <a href="{{ route('products.index') }}" class="profile-btn secondary">Continuer mes achats</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) entry.target.classList.add('show');
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal-up').forEach((el) => observer.observe(el));
});
</script>
@endsection