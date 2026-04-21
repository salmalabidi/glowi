<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glowi – Beauté Authentique & Luxe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Jost:wght@200;300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --rose: #c8748a;
            --rose-deep: #a85070;
            --rose-pale: #f5e6ea;
            --gold: #c9a96e;
            --gold-light: #e8d5b0;
            --cream: #fdf6f0;
            --dark: #1a0f14;
            --dark-mid: #2d1a22;
            --text: #3d2030;
            --text-light: #7a5c68;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--text);
            cursor: none;
            overflow-x: hidden;
        }

        #cursor {
            width: 12px;
            height: 12px;
            background: var(--rose);
            border-radius: 50%;
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s, width 0.3s, height 0.3s, background 0.3s;
            mix-blend-mode: multiply;
        }

        #cursor-ring {
            width: 36px;
            height: 36px;
            border: 1.5px solid var(--rose);
            border-radius: 50%;
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: transform 0.15s ease, width 0.3s, height 0.3s, opacity 0.3s;
            opacity: 0.6;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1200;
            padding: 0 48px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(26, 15, 20, 0.88);
            backdrop-filter: blur(18px) saturate(1.4);
            -webkit-backdrop-filter: blur(18px) saturate(1.4);
            border-bottom: 1px solid rgba(201,169,110,0.15);
            transition: background 0.4s;
        }

        nav.scrolled {
            background: rgba(26, 15, 20, 0.97);
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 300;
            letter-spacing: 0.08em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-logo span {
            color: var(--gold);
            font-style: italic;
        }

        .nav-logo::before {
            content: '•';
            color: var(--rose);
            margin-right: 6px;
            font-size: 0.7rem;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 10px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-link {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.72rem;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 2px;
            transition: color 0.3s, background 0.3s;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 16px;
            right: 16px;
            height: 1px;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
        }

        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown-btn {
            color: rgba(255,255,255,0.75);
            background: none;
            border: none;
            cursor: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.72rem;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .nav-dropdown-btn:hover {
            color: #fff;
        }

        .nav-dropdown-btn svg {
            width: 10px;
            height: 10px;
            transition: transform 0.3s;
            stroke: var(--gold);
        }

        .nav-dropdown:hover .nav-dropdown-btn svg {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
            background: rgba(26,15,20,0.97);
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 4px;
            padding: 8px 0;
            min-width: 160px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s, transform 0.25s;
            backdrop-filter: blur(20px);
            z-index: 1300;
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1;
            pointer-events: all;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: color 0.2s, padding-left 0.2s;
        }

        .dropdown-menu a:hover {
            color: var(--gold);
            padding-left: 26px;
        }

        .dropdown-menu a + a {
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-cart {
            position: relative;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: color 0.3s;
        }

        .nav-cart:hover {
            color: var(--gold);
        }

        .nav-cart svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: var(--rose);
            color: #fff;
            font-size: 0.6rem;
            font-weight: 500;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%,100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .btn-connexion {
            background: var(--rose);
            color: #fff;
            border: none;
            cursor: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            padding: 10px 22px;
            border-radius: 2px;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
            display: inline-block;
        }

        .btn-connexion:hover {
            background: var(--rose-deep);
            transform: translateY(-1px);
        }

        .user-menu {
            position: relative;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rose), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.78rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.15);
            cursor: none;
        }

        .user-menu-trigger {
            background: transparent;
            border: none;
            padding: 0;
            cursor: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            min-width: 220px;
            background: rgba(26,15,20,0.98);
            border: 1px solid rgba(201,169,110,0.18);
            border-radius: 10px;
            padding: 10px 0;
            opacity: 0;
            pointer-events: none;
            transform: translateY(8px);
            transition: opacity 0.25s ease, transform 0.25s ease;
            z-index: 1400;
            box-shadow: 0 18px 50px rgba(0,0,0,0.28);
            backdrop-filter: blur(20px);
        }

        .user-menu.open .user-dropdown {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .user-dropdown a,
        .user-dropdown button,
        .user-dropdown .dropdown-disabled {
            display: block;
            width: 100%;
            padding: 12px 20px;
            text-align: left;
            color: rgba(255,255,255,0.78);
            text-decoration: none;
            background: none;
            border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.76rem;
            letter-spacing: 0.08em;
            cursor: none;
            transition: color 0.2s, background 0.2s;
        }

        .user-dropdown a:hover,
        .user-dropdown button:hover {
            color: var(--gold);
            background: rgba(255,255,255,0.03);
        }

        .user-dropdown form {
            margin: 0;
        }

        .dropdown-disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        main {
            padding-top: 122px;
            min-height: 100vh;
        }

        #toast-success {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 9999;
            background: var(--dark);
            color: #fff;
            padding: 14px 24px;
            border-radius: 4px;
            border-left: 3px solid var(--rose);
            font-size: 0.82rem;
            letter-spacing: 0.05em;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            animation: slideIn 0.4s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(60px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .marquee-bar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            z-index: 1100;
            background: linear-gradient(90deg, var(--rose-deep), var(--rose), var(--gold), var(--rose), var(--rose-deep));
            background-size: 200% auto;
            animation: gradientMove 4s linear infinite;
            padding: 10px 0;
            overflow: hidden;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        @keyframes gradientMove {
            to { background-position: 200% center; }
        }

        .marquee-inner {
            display: flex;
            gap: 0;
            white-space: nowrap;
            animation: marquee 20s linear infinite;
        }

        .marquee-inner span {
            color: #fff;
            font-size: 0.65rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            padding: 0 32px;
        }

        .marquee-inner span::before {
            content: '✦';
            margin-right: 32px;
            opacity: 0.6;
        }

        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        footer {
            background: var(--dark);
            padding: 60px 48px 40px;
            margin-top: 80px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .footer-brand .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 12px;
        }

        .footer-brand .logo-text span {
            color: var(--gold);
            font-style: italic;
        }

        .footer-brand p {
            color: rgba(255,255,255,0.45);
            font-size: 0.8rem;
            line-height: 1.7;
        }

        .footer-col h4 {
            color: var(--gold);
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .footer-col a,
        .footer-col span {
            display: block;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            font-size: 0.8rem;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .footer-col a:hover {
            color: var(--rose);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            color: rgba(255,255,255,0.25);
            font-size: 0.72rem;
        }

        @media (max-width: 768px) {
            nav {
                padding: 0 20px;
            }

            .nav-center {
                display: none;
            }

            .marquee-bar {
                top: 70px;
            }

            main {
                padding-top: 122px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <nav id="navbar">
        <a href="{{ route('home') }}" class="nav-logo">Glo<span>wi</span></a>

        <div class="nav-center">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') && !request('category') ? 'active' : '' }}">Catalogue</a>
            <a href="{{ route('products.index', ['category' => 'skincare']) }}" class="nav-link {{ request('category') === 'skincare' ? 'active' : '' }}">Skincare</a>

            <div class="nav-dropdown">
                <button class="nav-dropdown-btn" type="button">
                    Maquillage
                    <svg viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L9 1" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('products.index', ['category' => 'maquillage']) }}">Tout le maquillage</a>
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Yeux']) }}">✦ Yeux</a>
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Teint']) }}">✦ Teint</a>
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Gloss']) }}">✦ Lèvres</a>
                </div>
            </div>

            <a href="{{ route('products.index', ['category' => 'accessoires']) }}" class="nav-link {{ request('category') === 'accessoires' ? 'active' : '' }}">Accessoires</a>
        </div>

        <div class="nav-right">
            @auth
                <a href="{{ route('cart.index') }}" class="nav-cart" aria-label="Panier">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="user-menu" id="userMenu">
                    <button type="button" class="user-menu-trigger" id="userMenuTrigger" aria-expanded="false" aria-haspopup="true">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    </button>

                   <div class="user-dropdown" id="userDropdown">
    <a href="{{ route('profile') }}">Mon profil</a>
    <a href="{{ route('orders') }}">Mes commandes</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
</div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-connexion">Connexion</a>
            @endauth
        </div>
    </nav>

    <div class="marquee-bar">
        <div class="marquee-inner">
            @php
                $items = [
                    'Skincare de Prestige',
                    'Maquillage Raffiné',
                    'Accessoires Curatés',
                    'Beauté Authentique',
                    'Glowi Paris',
                    'Livraison Offerte',
                    'Produits Sélectionnés',
                    'Skincare de Prestige',
                    'Maquillage Raffiné',
                    'Accessoires Curatés',
                    'Beauté Authentique',
                    'Glowi Paris',
                    'Livraison Offerte',
                    'Produits Sélectionnés'
                ];
            @endphp

            @foreach($items as $item)
                <span>{{ $item }}</span>
            @endforeach
        </div>
    </div>

    @if(session('success'))
        <div id="toast-success">✓ {{ session('success') }}</div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo-text">Glo<span>wi</span></div>
                <p>
                    Une curation soignée de beauté authentique.<br>
                    Skincare de prestige, maquillage raffiné,<br>
                    accessoires curatés — pour sublimer chaque femme.
                </p>
            </div>

            <div class="footer-col">
                <h4>Collections</h4>
                <a href="{{ route('products.index', ['category' => 'skincare']) }}">Skincare</a>
                <a href="{{ route('products.index', ['category' => 'maquillage']) }}">Maquillage</a>
                <a href="{{ route('products.index', ['category' => 'accessoires']) }}">Accessoires</a>
                <a href="{{ route('products.index') }}">Tout voir</a>
            </div>

            <div class="footer-col">
                <h4>Informations</h4>
                <a href="#">À propos</a>
                <a href="#">Livraison</a>
                <a href="#">Retours</a>
                <a href="#">Contact</a>
            </div>

            <div class="footer-col">
                <h4>Compte</h4>
                @auth
                    <span>Mon profil</span>
                    <span>Mes commandes</span>
                    <a href="{{ route('cart.index') }}">Mon panier</a>
                @else
                    <a href="{{ route('login') }}">Connexion</a>
                    <a href="{{ route('register') }}">Créer un compte</a>
                @endauth
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Glowi. Tous droits réservés.</p>
            <p style="color:rgba(255,255,255,0.15);font-size:0.65rem;letter-spacing:0.1em;">BEAUTÉ AUTHENTIQUE & LUXE</p>
        </div>
    </footer>

    @yield('scripts')

    <script>
        const cursor = document.getElementById('cursor');
        const ring = document.getElementById('cursor-ring');

        let mx = 0;
        let my = 0;
        let rx = 0;
        let ry = 0;

        document.addEventListener('mousemove', e => {
            mx = e.clientX;
            my = e.clientY;
        });

        function animateCursor() {
            cursor.style.left = mx + 'px';
            cursor.style.top = my + 'px';

            rx += (mx - rx) * 0.12;
            ry += (my - ry) * 0.12;

            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';

            requestAnimationFrame(animateCursor);
        }

        animateCursor();

        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.transform = 'translate(-50%,-50%) scale(2.5)';
                ring.style.opacity = '0.15';
            });

            el.addEventListener('mouseleave', () => {
                cursor.style.transform = 'translate(-50%,-50%) scale(1)';
                ring.style.opacity = '0.6';
            });
        });

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        const toast = document.getElementById('toast-success');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.4s';
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }

        const userMenu = document.getElementById('userMenu');
        const userMenuTrigger = document.getElementById('userMenuTrigger');

        if (userMenu && userMenuTrigger) {
            userMenuTrigger.addEventListener('click', function (e) {
                e.stopPropagation();
                userMenu.classList.toggle('open');

                const expanded = userMenu.classList.contains('open');
                userMenuTrigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            });

            document.addEventListener('click', function (e) {
                if (!userMenu.contains(e.target)) {
                    userMenu.classList.remove('open');
                    userMenuTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }
    </script>
</body>
</html>