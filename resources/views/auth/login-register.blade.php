<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'login' ? 'Connexion' : 'Créer un compte' }} — Glowi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@200;300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose: #c8748a; --rose-deep: #a85070; --rose-pale: #f5e6ea;
            --gold: #c9a96e; --cream: #fdf6f0; --dark: #1a0f14;
            --text: #3d2030; --text-light: #7a5c68;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            overflow: hidden;
            cursor: none;
        }

        /* CURSOR */
        #cursor { width: 10px; height: 10px; background: var(--rose); border-radius: 50%; position: fixed; top:0; left:0; pointer-events:none; z-index:99999; transform:translate(-50%,-50%); mix-blend-mode: screen; transition: width .3s, height .3s; }
        #cursor-ring { width: 32px; height: 32px; border: 1px solid rgba(200,116,138,0.5); border-radius: 50%; position: fixed; top:0; left:0; pointer-events:none; z-index:99998; transform:translate(-50%,-50%); transition: transform .12s ease; }

        /* PARTICLES CANVAS */
        #particles-canvas {
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none;
        }

        /* BACKGROUND ORBS */
        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(80px); opacity: 0.25;
            pointer-events: none; z-index: 0;
            animation: orbFloat 8s ease-in-out infinite;
        }
        .orb-1 { width: 500px; height: 500px; background: var(--rose); top: -150px; left: -150px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: var(--gold); bottom: -100px; right: -100px; animation-delay: 3s; }
        .orb-3 { width: 300px; height: 300px; background: var(--rose-deep); top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 1.5s; }
        @keyframes orbFloat {
            0%,100% { transform: translate(0,0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.05); }
        }
        .orb-3 { animation: orbFloat3 6s ease-in-out infinite; }
        @keyframes orbFloat3 {
            0%,100% { transform: translate(-50%,-50%) scale(1); }
            50% { transform: translate(-48%,-52%) scale(1.08); }
        }

        /* GRID OVERLAY */
        .grid-overlay {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* PAGE LAYOUT */
        .page {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: grid; grid-template-columns: 1fr 1fr;
        }

        /* LEFT SIDE — BRAND */
        .brand-side {
            display: flex; flex-direction: column; justify-content: center;
            padding: 80px;
            position: relative;
        }
        .back-link {
            position: absolute; top: 32px; left: 40px;
            color: rgba(255,255,255,0.4); text-decoration: none;
            font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase;
            display: flex; align-items: center; gap: 8px;
            transition: color 0.3s;
        }
        .back-link:hover { color: var(--gold); }
        .brand-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem; font-weight: 300; color: #fff;
            margin-bottom: 8px;
        }
        .brand-logo span { color: var(--gold); font-style: italic; }
        .brand-logo::before { content: '• '; color: var(--rose); font-size: 1.2rem; vertical-align: middle; }
        .brand-tagline {
            color: rgba(255,255,255,0.35);
            font-size: 0.75rem; letter-spacing: 0.25em; text-transform: uppercase;
            margin-bottom: 60px;
        }
        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 4vw, 4rem);
            font-weight: 300; line-height: 1.1; color: #fff;
            margin-bottom: 20px;
        }
        .brand-title em { color: var(--rose); font-style: italic; display: block; }
        .brand-desc {
            color: rgba(255,255,255,0.4); font-size: 0.85rem; line-height: 1.8;
            max-width: 380px; margin-bottom: 48px;
        }
        .brand-features { list-style: none; display: flex; flex-direction: column; gap: 14px; }
        .brand-features li {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.5); font-size: 0.78rem;
        }
        .brand-features li::before {
            content: '✦'; color: var(--gold); font-size: 0.6rem; flex-shrink: 0;
        }

        /* DECORATIVE PILLS */
        .floating-pills {
            position: absolute; right: -20px; top: 50%;
            transform: translateY(-50%);
            display: flex; flex-direction: column; gap: 10px;
        }
        .pill {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 8px 16px;
            color: rgba(255,255,255,0.4);
            font-size: 0.65rem; letter-spacing: 0.12em; white-space: nowrap;
            animation: pillFloat 4s ease-in-out infinite;
        }
        .pill:nth-child(2) { animation-delay: 1.3s; }
        .pill:nth-child(3) { animation-delay: 2.6s; }
        @keyframes pillFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }

        /* RIGHT SIDE — FORM */
        .form-side {
            display: flex; align-items: center; justify-content: center;
            padding: 60px 64px;
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255,255,255,0.06);
        }
        .form-container {
            width: 100%; max-width: 420px;
        }

        /* TAB SWITCH */
        .tab-switch {
            display: flex; margin-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .tab-btn {
            flex: 1; padding: 14px 16px; background: none; border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.72rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: rgba(255,255,255,0.3); cursor: none;
            position: relative; transition: color 0.3s;
        }
        .tab-btn.active { color: #fff; }
        .tab-btn.active::after {
            content: ''; position: absolute; bottom: -1px; left: 0; right: 0;
            height: 2px; background: var(--rose);
        }
        .tab-btn:hover { color: rgba(255,255,255,0.7); }

        /* FORMS */
        .auth-form { display: none; animation: formSlide 0.4s ease; }
        .auth-form.active { display: block; }
        @keyframes formSlide { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem; font-weight: 300; color: #fff;
            margin-bottom: 6px;
        }
        .form-subtitle { color: rgba(255,255,255,0.35); font-size: 0.8rem; margin-bottom: 36px; }

        .field { margin-bottom: 20px; position: relative; }
        .field label {
            display: block; font-size: 0.65rem; letter-spacing: 0.2em;
            text-transform: uppercase; color: rgba(255,255,255,0.4);
            margin-bottom: 8px;
        }
        .field input {
            width: 100%; padding: 14px 18px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 2px; color: #fff;
            font-family: 'Jost', sans-serif; font-size: 0.88rem;
            outline: none; transition: border-color 0.3s, background 0.3s;
        }
        .field input:focus {
            border-color: var(--rose);
            background: rgba(200,116,138,0.06);
        }
        .field input::placeholder { color: rgba(255,255,255,0.2); }
        .field-error {
            color: #e07070; font-size: 0.72rem; margin-top: 6px;
        }

        .btn-submit {
            width: 100%; padding: 16px;
            background: var(--rose); color: #fff; border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.72rem; letter-spacing: 0.25em; text-transform: uppercase;
            cursor: none; border-radius: 2px;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            margin-top: 8px; position: relative; overflow: hidden;
        }
        .btn-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%); transition: transform 0.5s;
        }
        .btn-submit:hover { background: var(--rose-deep); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(200,116,138,0.4); }
        .btn-submit:hover::before { transform: translateX(100%); }

        .divider-or {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0; color: rgba(255,255,255,0.2); font-size: 0.7rem;
        }
        .divider-or::before, .divider-or::after {
            content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.1);
        }

        .switch-mode {
            text-align: center; margin-top: 28px;
            color: rgba(255,255,255,0.3); font-size: 0.78rem;
        }
        .switch-mode button {
            background: none; border: none; color: var(--rose);
            font-family: 'Jost', sans-serif; font-size: 0.78rem;
            cursor: none; text-decoration: underline;
            transition: color 0.2s;
        }
        .switch-mode button:hover { color: var(--gold); }

        /* ERROR ALERT */
        .alert-error {
            background: rgba(224,112,112,0.12); border: 1px solid rgba(224,112,112,0.3);
            border-radius: 2px; padding: 12px 16px; margin-bottom: 20px;
            color: #e07070; font-size: 0.78rem;
        }

        /* REMEMBER */
        .remember-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }
        .remember-row label {
            display: flex; align-items: center; gap: 8px;
            color: rgba(255,255,255,0.4); font-size: 0.75rem; cursor: none;
        }
        .remember-row input[type=checkbox] { accent-color: var(--rose); }
        .forgot-link { color: rgba(255,255,255,0.3); font-size: 0.72rem; text-decoration: none; transition: color .2s; }
        .forgot-link:hover { color: var(--gold); }
    </style>
</head>
<body>
    <div id="cursor"></div>
    <div id="cursor-ring"></div>
    <canvas id="particles-canvas"></canvas>

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="grid-overlay"></div>

    <div class="page">
        <!-- BRAND SIDE -->
        <div class="brand-side">
            <a href="{{ route('home') }}" class="back-link">← Retour</a>
            <div class="brand-logo">Glo<span>wi</span></div>
            <div class="brand-tagline">Beauté Authentique & Luxe</div>
            <h2 class="brand-title">
                Votre univers
                <em>beauté</em>
                vous attend
            </h2>
            <p class="brand-desc">Rejoignez la communauté Glowi et accédez à une sélection exclusive de produits skincare et maquillage de prestige.</p>
            <ul class="brand-features">
                <li>Accès à plus de 60 produits sélectionnés</li>
                <li>Panier & commandes personnalisées</li>
                <li>Offres exclusives membres</li>
                <li>Conseils beauté personnalisés</li>
            </ul>
            <div class="floating-pills">
                <div class="pill">✦ Skincare Premium</div>
                <div class="pill">✦ Maquillage Raffiné</div>
                <div class="pill">✦ Livraison Offerte</div>
            </div>
        </div>

        <!-- FORM SIDE -->
        <div class="form-side">
            <div class="form-container">
                <!-- TABS -->
                <div class="tab-switch">
                    <button class="tab-btn {{ $mode === 'login' ? 'active' : '' }}" onclick="switchTab('login')" id="tab-login">Connexion</button>
                    <button class="tab-btn {{ $mode === 'register' ? 'active' : '' }}" onclick="switchTab('register')" id="tab-register">Créer un compte</button>
                </div>

                <!-- LOGIN FORM -->
                <div class="auth-form {{ $mode === 'login' ? 'active' : '' }}" id="form-login">
                    <h2 class="form-title">Bon retour ✦</h2>
                    <p class="form-subtitle">Connectez-vous pour accéder à votre espace beauté.</p>

                    @if($errors->any() && $mode === 'login')
                        <div class="alert-error">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="field">
                            <label>Adresse email</label>
                            <input type="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="field">
                            <label>Mot de passe</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div class="remember-row">
                            <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                            <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" class="btn-submit">Se connecter</button>
                    </form>

                    <div class="divider-or">ou</div>
                    <div class="switch-mode">
                        Pas encore de compte ?
                        <button onclick="switchTab('register')">Créer un compte</button>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div class="auth-form {{ $mode === 'register' ? 'active' : '' }}" id="form-register">
                    <h2 class="form-title">Bienvenue 🌸</h2>
                    <p class="form-subtitle">Créez votre compte et rejoignez l'univers Glowi.</p>

                    @if($errors->any() && $mode === 'register')
                        <div class="alert-error">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="field">
                            <label>Votre prénom</label>
                            <input type="text" name="name" placeholder="Marie..." value="{{ old('name') }}" required>
                        </div>
                        <div class="field">
                            <label>Adresse email</label>
                            <input type="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="field">
                            <label>Mot de passe</label>
                            <input type="password" name="password" placeholder="Min. 6 caractères" required>
                        </div>
                        <div class="field">
                            <label>Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn-submit">Créer mon compte</button>
                    </form>

                    <div class="divider-or">ou</div>
                    <div class="switch-mode">
                        Déjà un compte ?
                        <button onclick="switchTab('login')">Se connecter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Custom cursor
    const cursor = document.getElementById('cursor');
    const ring = document.getElementById('cursor-ring');
    let mx=0,my=0,rx=0,ry=0;
    document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; });
    (function anim() {
        cursor.style.left=mx+'px'; cursor.style.top=my+'px';
        rx+=(mx-rx)*.1; ry+=(my-ry)*.1;
        ring.style.left=rx+'px'; ring.style.top=ry+'px';
        requestAnimationFrame(anim);
    })();
    document.querySelectorAll('a,button,input').forEach(el => {
        el.addEventListener('mouseenter', () => { cursor.style.width='18px'; cursor.style.height='18px'; });
        el.addEventListener('mouseleave', () => { cursor.style.width='10px'; cursor.style.height='10px'; });
    });

    // Tab switch with smooth animation
    function switchTab(tab) {
        document.getElementById('form-login').classList.remove('active');
        document.getElementById('form-register').classList.remove('active');
        document.getElementById('tab-login').classList.remove('active');
        document.getElementById('tab-register').classList.remove('active');
        document.getElementById('form-' + tab).classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
        // Update URL without reload
        const url = tab === 'login' ? '/login' : '/register';
        history.pushState({}, '', url);
    }

    // PARTICLES
    const canvas = document.getElementById('particles-canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    window.addEventListener('resize', () => { canvas.width=window.innerWidth; canvas.height=window.innerHeight; });

    const particles = Array.from({length: 60}, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 1.5 + 0.3,
        vx: (Math.random() - 0.5) * 0.3,
        vy: (Math.random() - 0.5) * 0.3,
        alpha: Math.random() * 0.4 + 0.1,
        color: Math.random() > 0.5 ? '200,116,138' : '201,169,110'
    }));

    function drawParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.x += p.vx; p.y += p.vy;
            if (p.x < 0) p.x = canvas.width;
            if (p.x > canvas.width) p.x = 0;
            if (p.y < 0) p.y = canvas.height;
            if (p.y > canvas.height) p.y = 0;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color},${p.alpha})`;
            ctx.fill();
        });
        // Draw connections
        particles.forEach((a, i) => {
            particles.slice(i+1).forEach(b => {
                const d = Math.hypot(a.x-b.x, a.y-b.y);
                if (d < 100) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(200,116,138,${0.08*(1-d/100)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y);
                    ctx.stroke();
                }
            });
        });
        requestAnimationFrame(drawParticles);
    }
    drawParticles();
    </script>
</body>
</html>
