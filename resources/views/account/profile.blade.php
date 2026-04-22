@extends('layouts.app')

@section('content')
<style>
.profile-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 52px 48px 100px;
}

.profile-head { margin-bottom: 30px; }
.profile-kicker {
    color: var(--rose); font-size:.72rem; letter-spacing:.22em;
    text-transform:uppercase; margin-bottom:10px;
}
.profile-title {
    font-family:'Cormorant Garamond',serif; font-size:clamp(2.8rem,5vw,4rem);
    line-height:1; color:var(--text); font-weight:300;
}
.profile-subtitle { margin-top:12px; color:var(--text-light); line-height:1.8; }

/* Layout */
.profile-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 22px;
    align-items: start;
}

/* Sidebar */
.profile-side {
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 28px;
    box-shadow: 0 18px 44px rgba(36,18,25,0.05);
    padding: 28px 22px;
    text-align: center;
}

.profile-avatar-wrap { position:relative; display:inline-block; margin-bottom:16px; }
.profile-avatar {
    width:110px; height:110px; border-radius:50%;
    background: linear-gradient(135deg, #cf8ca0, #dcb177);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:2.2rem; font-weight:700;
    box-shadow:0 18px 34px rgba(200,116,138,0.18);
    overflow:hidden;
}
.profile-avatar img { width:100%; height:100%; object-fit:cover; }
.avatar-edit-btn {
    position:absolute; bottom:2px; right:2px;
    width:28px; height:28px; border-radius:50%;
    background: var(--rose); color:#fff; font-size:.75rem;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; border:2px solid #fff;
    transition:transform .2s;
}
.avatar-edit-btn:hover { transform:scale(1.1); }

.profile-name  { font-family:'Cormorant Garamond',serif; font-size:1.9rem; color:var(--text); margin-bottom:4px; }
.profile-email { color:var(--text-light); font-size:.88rem; margin-bottom:18px; word-break:break-word; }

.profile-stats { display:grid; gap:10px; margin-bottom:20px; }
.profile-stat {
    padding:13px 16px; border-radius:16px;
    background:linear-gradient(135deg,rgba(200,116,138,0.07),rgba(201,169,110,0.07));
    border:1px solid rgba(200,116,138,0.10); text-align:left;
}
.profile-stat-label { display:block; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; color:var(--rose-deep); margin-bottom:4px; }
.profile-stat-value { font-size:1.4rem; font-weight:600; color:var(--text); font-family:'Cormorant Garamond',serif; }

.seller-btn {
    display:flex; align-items:center; justify-content:center; gap:8px;
    width:100%; padding:12px; border-radius:999px; text-decoration:none;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; font-size:.76rem; letter-spacing:.14em; text-transform:uppercase;
    transition:transform .22s, box-shadow .22s; margin-bottom:10px;
}
.seller-btn:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(200,116,138,0.26); }

.side-link {
    display:block; padding:10px 14px; border-radius:14px; text-decoration:none;
    color:var(--text-light); font-size:.78rem; letter-spacing:.10em; text-transform:uppercase;
    transition:background .2s, color .2s; text-align:center;
    border:1px solid rgba(200,116,138,0.10); margin-bottom:8px;
}
.side-link:hover { background:rgba(200,116,138,0.08); color:var(--rose-deep); }

/* Main content */
.profile-main { display:flex; flex-direction:column; gap:20px; }

.profile-panel {
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.86));
    border: 1px solid rgba(200,116,138,0.12);
    border-radius: 26px;
    box-shadow: 0 16px 40px rgba(36,18,25,0.05);
    padding: 28px;
}
.panel-title {
    font-family:'Cormorant Garamond',serif; font-size:1.8rem; color:var(--text);
    margin-bottom:20px; display:flex; align-items:center; gap:10px;
}

/* Forms */
.form-group { margin-bottom:18px; }
.form-label { display:block; color:var(--text-light); font-size:.68rem; letter-spacing:.16em; text-transform:uppercase; margin-bottom:7px; }
.form-input {
    width:100%; padding:12px 16px; border-radius:13px;
    border:1px solid rgba(200,116,138,0.18); background:rgba(253,246,240,0.60);
    color:var(--text); font-family:'Jost',sans-serif; font-size:.92rem; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.form-input:focus { border-color:var(--rose); box-shadow:0 0 0 3px rgba(200,116,138,0.10); }
.form-error { color:#a03030; font-size:.80rem; margin-top:4px; }
.form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

.btn-save {
    padding:11px 24px; border-radius:999px;
    background:linear-gradient(135deg, var(--rose), var(--rose-deep));
    color:#fff; border:none; font-size:.76rem; letter-spacing:.14em; text-transform:uppercase;
    cursor:pointer; transition:transform .2s, box-shadow .2s;
}
.btn-save:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(200,116,138,0.24); }

/* Alerts */
.alert {
    padding:13px 18px; border-radius:14px; margin-bottom:16px; font-size:.88rem;
}
.alert-success { background:rgba(98,184,128,0.12); color:#2f7a47; border:1px solid rgba(98,184,128,0.22); }
.alert-error   { background:rgba(212,98,98,0.10);  color:#a03030; border:1px solid rgba(212,98,98,0.18); }

/* Password strength */
.pwd-strength { height:4px; border-radius:4px; margin-top:6px; background:rgba(200,116,138,0.12); overflow:hidden; }
.pwd-strength-bar { height:100%; border-radius:4px; transition:width .3s, background .3s; width:0%; }

/* Danger zone */
.danger-zone {
    border:1px solid rgba(212,98,98,0.18);
    border-radius:26px; padding:24px 28px;
    background:rgba(212,98,98,0.04);
}
.danger-title { font-family:'Cormorant Garamond',serif; font-size:1.5rem; color:#a03030; margin-bottom:10px; }
.danger-sub   { color:var(--text-light); font-size:.88rem; margin-bottom:16px; }

/* Hidden avatar input */
#avatarInput { display:none; }

@media (max-width:900px) {
    .profile-page   { padding:38px 20px 80px; }
    .profile-layout { grid-template-columns:1fr; }
    .form-row-2     { grid-template-columns:1fr; }
}
</style>

<div class="profile-page">

    <div class="profile-head reveal-up">
        <div class="profile-kicker">Compte</div>
        <h1 class="profile-title">Mon profil</h1>
        <p class="profile-subtitle">Gérez vos informations, votre mot de passe et vos annonces depuis un seul espace.</p>
    </div>

    <div class="profile-layout">

        {{-- ── SIDEBAR ── --}}
        <div class="profile-side reveal-up">

            {{-- Avatar --}}
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
                @csrf @method('PATCH')
                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                       onchange="document.getElementById('avatarForm').submit()">
            </form>

            <div class="profile-avatar-wrap">
                <div class="profile-avatar">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="avatar">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <label for="avatarInput" class="avatar-edit-btn" title="Changer la photo">✏️</label>
            </div>

            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>

            <div class="profile-stats">
                <div class="profile-stat">
                    <span class="profile-stat-label">Commandes</span>
                    <div class="profile-stat-value">{{ $ordersCount }}</div>
                </div>
                <div class="profile-stat">
                    <span class="profile-stat-label">Mes annonces</span>
                    <div class="profile-stat-value">{{ $productsCount }}</div>
                </div>
            </div>

            <a href="{{ route('user.products.index') }}" class="seller-btn">🛍 Espace vendeur</a>
            <a href="{{ route('orders') }}" class="side-link">Mes commandes</a>
            <a href="{{ route('wishlist.index') }}" class="side-link">Ma wishlist</a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px">
                @csrf
                <button type="submit" class="side-link" style="width:100%;background:none;border:1px solid rgba(212,98,98,0.18);color:#a03030">
                    Déconnexion
                </button>
            </form>
        </div>

        {{-- ── MAIN ── --}}
        <div class="profile-main">

            {{-- Infos générales --}}
            <div class="profile-panel reveal-up">
                <div class="panel-title">👤 Informations personnelles</div>

                @if(session('success'))
                    <div class="alert alert-success">✓ {{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-input"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Adresse email</label>
                            <input type="email" name="email" class="form-input"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn-save">Enregistrer</button>
                </form>
            </div>

            {{-- Mot de passe --}}
            <div class="profile-panel reveal-up">
                <div class="panel-title">🔒 Changer le mot de passe</div>

                @if(session('success_password'))
                    <div class="alert alert-success">✓ {{ session('success_password') }}</div>
                @endif
                @if($errors->has('current_password'))
                    <div class="alert alert-error">✗ {{ $errors->first('current_password') }}</div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}" id="pwdForm">
                    @csrf @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-input"
                               placeholder="••••••••" required>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-input"
                                   placeholder="Min. 8 caractères" id="newPwd" required>
                            <div class="pwd-strength">
                                <div class="pwd-strength-bar" id="pwdBar"></div>
                            </div>
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-input"
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Modifier le mot de passe</button>
                </form>
            </div>

            {{-- Danger zone --}}
            @if($user->avatar)
            <div class="danger-zone reveal-up">
                <div class="danger-title">Supprimer la photo de profil</div>
                <p class="danger-sub">Votre avatar sera remplacé par votre initiale.</p>
                <form method="POST" action="{{ route('profile.avatar.delete') }}"
                      onsubmit="return confirm('Supprimer votre photo de profil ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-save" style="background:rgba(212,98,98,0.85)">
                        Supprimer l'avatar
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
// Reveal on scroll
document.addEventListener('DOMContentLoaded', function () {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('show'); });
    }, { threshold: 0.10 });
    document.querySelectorAll('.reveal-up').forEach(el => obs.observe(el));
});

// Password strength indicator
const pwdInput = document.getElementById('newPwd');
const pwdBar   = document.getElementById('pwdBar');
if (pwdInput) {
    pwdInput.addEventListener('input', function () {
        const v = this.value;
        let score = 0;
        if (v.length >= 8)  score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        const colors = ['#d46262','#e6a855','#62b880','#2f7a47'];
        const widths  = ['25%','50%','75%','100%'];
        pwdBar.style.width      = score > 0 ? widths[score-1] : '0%';
        pwdBar.style.background = score > 0 ? colors[score-1] : 'transparent';
    });
}
</script>
@endsection
