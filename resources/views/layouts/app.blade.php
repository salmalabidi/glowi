<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glowi – Beauté Authentique & Luxe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&display=swap" rel="stylesheet">

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
            --dark-soft: #24131a;
            --text: #3d2030;
            --text-light: #7a5c68;
            --line: rgba(255,255,255,0.08);
            --line-soft: rgba(200,116,138,0.14);
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

        a, button, select, input, textarea {
            cursor: none;
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
            transform: translate3d(-100px, -100px, 0);
            transition: opacity 0.2s ease, background 0.2s ease;
            opacity: 1;
            will-change: transform;
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
            transform: translate3d(-100px, -100px, 0);
            transition: opacity 0.2s ease, border-color 0.2s ease;
            opacity: 0.55;
            will-change: transform;
        }

        @media (max-width: 900px), (hover: none), (pointer: coarse) {
            body,
            a, button, input, select, textarea {
                cursor: auto !important;
            }

            #cursor,
            #cursor-ring {
                display: none !important;
            }
        }

        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1300;
            height: 78px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(26, 15, 20, 0.84);
            backdrop-filter: blur(18px) saturate(1.35);
            -webkit-backdrop-filter: blur(18px) saturate(1.35);
            border-bottom: 1px solid rgba(201,169,110,0.10);
            transition: transform 0.4s ease, background 0.35s ease, box-shadow 0.35s ease, height 0.35s ease;
        }

        #navbar.scrolled {
            background: rgba(26, 15, 20, 0.94);
            box-shadow: 0 14px 40px rgba(0,0,0,0.18);
        }

        #navbar.nav-hidden { transform: translateY(-100%); }
        #navbar.nav-compact { height: 72px; }

        .nav-left {
            display: flex; align-items: center; gap: 16px;
            min-width: 210px;
        }

        .back-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 10px 16px;
            border: 1px solid rgba(201,169,110,0.22);
            background: linear-gradient(135deg, rgba(200,116,138,0.16), rgba(201,169,110,0.14));
            color: #fff; border-radius: 999px;
            font-family: 'Jost', sans-serif; font-size: 0.72rem;
            letter-spacing: 0.14em; text-transform: uppercase;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease, background 0.25s ease;
            box-shadow: 0 8px 22px rgba(0,0,0,0.16);
        }

        .back-btn:hover {
            transform: translateX(-3px) translateY(-1px);
            border-color: rgba(201,169,110,0.45);
            background: linear-gradient(135deg, rgba(200,116,138,0.28), rgba(201,169,110,0.22));
            box-shadow: 0 14px 28px rgba(0,0,0,0.22);
        }

        .back-arrow { font-size: 1rem; line-height: 1; color: var(--gold); transition: transform 0.25s ease; }
        .back-btn:hover .back-arrow { transform: translateX(-3px); }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem; font-weight: 300;
            letter-spacing: 0.08em; color: #fff;
            text-decoration: none;
            display: flex; align-items: center; gap: 4px;
            position: relative;
        }

        .nav-logo span { color: var(--gold); font-style: italic; }
        .nav-logo::before { content: '•'; color: var(--rose); margin-right: 6px; font-size: 0.7rem; }

        .nav-center {
            display: flex; align-items: center; gap: 10px;
            position: absolute; left: 50%; transform: translateX(-50%);
            background: transparent;
            z-index: 1;
        }

        .nav-link {
            color: rgba(255,255,255,0.76); text-decoration: none;
            font-size: 0.74rem; font-weight: 400; letter-spacing: 0.16em;
            text-transform: uppercase; padding: 10px 16px;
            border-radius: 999px;
            transition: color 0.3s ease, background 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active { color: #fff; }

        .nav-link::after {
            content: ''; position: absolute;
            bottom: 6px; left: 16px; right: 16px;
            height: 1px;
            background: linear-gradient(90deg, var(--gold), var(--rose));
            transform: scaleX(0); transform-origin: center;
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after, .nav-link.active::after { transform: scaleX(1); }

        .nav-dropdown { position: relative; }

        .nav-dropdown-btn {
            color: rgba(255,255,255,0.76); background: none; border: none;
            font-family: 'Jost', sans-serif; font-size: 0.74rem;
            font-weight: 400; letter-spacing: 0.16em; text-transform: uppercase;
            padding: 10px 16px;
            display: flex; align-items: center; gap: 6px;
            transition: color 0.3s ease;
        }

        .nav-dropdown-btn:hover { color: #fff; }

        .nav-dropdown-btn svg {
            width: 10px; height: 10px;
            transition: transform 0.3s ease;
            stroke: var(--gold);
        }

        .nav-dropdown:hover .nav-dropdown-btn svg { transform: rotate(180deg); }

        .dropdown-menu {
            position: absolute; top: calc(100% + 8px); left: 50%;
            transform: translateX(-50%) translateY(-8px);
            background: rgba(26,15,20,0.97);
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 14px; padding: 8px 0; min-width: 180px;
            opacity: 0; pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            backdrop-filter: blur(20px); z-index: 1400;
            box-shadow: 0 18px 50px rgba(0,0,0,0.24);
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1; pointer-events: all;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-menu a {
            display: block; padding: 11px 20px;
            color: rgba(255,255,255,0.72); text-decoration: none;
            font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase;
            transition: color 0.2s ease, padding-left 0.2s ease, background 0.2s ease;
        }

        .dropdown-menu a:hover { color: var(--gold); padding-left: 26px; background: rgba(255,255,255,0.03); }
        .dropdown-menu a + a { border-top: 1px solid rgba(255,255,255,0.05); }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1500;
        }

        .nav-search-wrap {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 9999;
        }

        .nav-search-btn {
            position: relative;
            width: 44px; height: 44px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.82);
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            transition: transform 0.25s ease, color 0.25s ease, background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            overflow: hidden;
            flex-shrink: 0;
        }

        .nav-search-btn::before {
            content: '';
            position: absolute; inset: -40%;
            background: conic-gradient(from 0deg, transparent, rgba(201,169,110,0.35), transparent 50%);
            opacity: 0;
            transition: opacity 0.25s ease;
            animation: spinRing 3s linear infinite;
        }

        .nav-search-btn:hover {
            transform: translateY(-2px) scale(1.03);
            color: var(--gold);
            background: rgba(200,116,138,0.10);
            border-color: rgba(200,116,138,0.26);
            box-shadow: 0 12px 26px rgba(200,116,138,0.16);
        }

        .nav-search-btn:hover::before { opacity: 1; }

        .nav-search-btn svg {
            width: 19px; height: 19px;
            position: relative; z-index: 1;
            stroke: currentColor; fill: none; stroke-width: 1.8;
            transition: transform 0.25s ease;
        }

        .nav-search-btn:hover svg { transform: scale(1.08) rotate(-6deg); }

        .nav-search-input-wrap {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            overflow: visible;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            opacity: 0;
            pointer-events: none;
            z-index: 9999;
        }

        .nav-search-input-wrap.open {
            width: 280px;
            opacity: 1;
            pointer-events: all;
        }

        .nav-search-input {
            width: 100%;
            background: rgba(26,15,20,0.95);
            border: 1px solid rgba(201,169,110,0.3);
            border-right: none;
            border-radius: 999px 0 0 999px;
            padding: 10px 18px;
            color: #fff;
            font-family: 'Jost', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            outline: none;
            transition: border-color 0.3s;
            clip-path: inset(0 0 0 0 round 999px 0 0 999px);
        }

        .nav-search-input::placeholder { color: rgba(255,255,255,0.35); }
        .nav-search-input:focus { border-color: rgba(200,116,138,0.5); }

        .search-results-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 340px;
            max-height: 380px;
            overflow-y: auto;
            background: rgba(26,15,20,0.98);
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 14px;
            z-index: 99999;
            box-shadow: 0 18px 50px rgba(0,0,0,0.4);
            backdrop-filter: blur(20px);
            display: none;
        }

        .search-results-dropdown.show {
            display: block;
            animation: fadeSlide 0.2s ease;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .search-result-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            transition: background 0.2s;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .search-result-item:last-child { border-bottom: none; }
        .search-result-item:hover { background: rgba(255,255,255,0.04); }

        .search-result-img {
            width: 42px; height: 42px;
            border-radius: 8px;
            object-fit: cover;
            background: var(--rose-pale);
            flex-shrink: 0;
        }

        .search-result-info { flex: 1; min-width: 0; }

        .search-result-name {
            color: rgba(255,255,255,0.88);
            font-size: 0.78rem; font-weight: 500;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .search-result-brand { color: rgba(255,255,255,0.4); font-size: 0.68rem; margin-top: 2px; }

        .search-result-price {
            color: var(--gold);
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.95rem; font-weight: 500;
            flex-shrink: 0;
        }

        .search-no-results {
            padding: 20px; text-align: center;
            color: rgba(255,255,255,0.4); font-size: 0.78rem;
        }

        .search-loading {
            padding: 16px; text-align: center;
            color: rgba(255,255,255,0.4); font-size: 0.75rem;
            letter-spacing: 0.1em;
        }

        @keyframes spinRing { to { transform: rotate(360deg); } }

        .nav-cart {
            position: relative; color: rgba(255,255,255,0.82);
            text-decoration: none; display: flex;
            align-items: center; justify-content: center;
            transition: transform 0.25s ease, color 0.25s ease;
        }

        .nav-cart:hover { color: var(--gold); transform: translateY(-2px); }

        .cart-icon-wrap {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            transition: transform 0.25s ease, background 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .nav-cart:hover .cart-icon-wrap {
            background: rgba(200,116,138,0.14);
            border-color: rgba(200,116,138,0.28);
            box-shadow: 0 12px 26px rgba(200,116,138,0.16);
            transform: scale(1.06);
        }

        .nav-cart svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; transition: transform 0.25s ease; }
        .nav-cart:hover svg { transform: rotate(-6deg); }

        .cart-badge {
            position: absolute; top: -4px; right: -4px;
            background: linear-gradient(135deg, var(--rose), var(--gold));
            color: #fff; font-size: 0.62rem; font-weight: 600;
            min-width: 18px; height: 18px; padding: 0 5px;
            border-radius: 999px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 16px rgba(200,116,138,0.28);
            animation: pulse-badge 2s infinite;
        }

        #wish-badge {
            background: linear-gradient(135deg, var(--rose), var(--rose-deep));
            font-size: 0.68rem;
            padding: 0 6px;
            animation: none;
        }

        @keyframes pulse-badge { 0%,100% { transform: scale(1); } 50% { transform: scale(1.12); } }

        .cart-badge.bump { animation: cartBadgeBump 0.35s ease; }
        @keyframes cartBadgeBump { 0% { transform: scale(1); } 50% { transform: scale(1.28); } 100% { transform: scale(1); } }

        .user-menu {
            position: relative;
            z-index: 1500;
        }

        .user-menu-trigger {
            background: transparent;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            position: relative;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #cf8ca0, #dcb177);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            border: 1px solid rgba(255,255,255,0.16);
            box-shadow: 0 14px 30px rgba(200,116,138,0.18);
            overflow: hidden;
            transition: transform 0.32s ease, box-shadow 0.32s ease;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
            border-radius: 50%;
            z-index: 3;
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            inset: -35%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.42), transparent 55%);
            animation: spinRing 4s linear infinite;
            opacity: 0.85;
        }

        .user-avatar::after {
            content: '';
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
            backdrop-filter: blur(8px);
        }

        .user-avatar span {
            position: relative;
            z-index: 2;
        }

        .user-menu:hover .user-avatar,
        .user-menu.open .user-avatar {
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 20px 38px rgba(200,116,138,0.24);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 14px);
            right: 0;
            min-width: 295px;
            background: rgba(20, 12, 17, 0.98);
            border: 1px solid rgba(201,169,110,0.16);
            border-radius: 22px;
            padding: 0;
            opacity: 0;
            pointer-events: none;
            transform: translateY(14px) scale(0.96);
            transition: opacity 0.32s ease, transform 0.32s ease;
            z-index: 2000;
            box-shadow: 0 26px 60px rgba(0,0,0,0.34);
            backdrop-filter: blur(20px);
            overflow: hidden;
        }

        .user-dropdown::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -20px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(200,116,138,0.16), transparent 70%);
            pointer-events: none;
        }

        .user-menu.open .user-dropdown {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }

        .user-dropdown-header {
            position: relative;
            padding: 20px 22px 16px;
            background: linear-gradient(135deg, rgba(200,116,138,0.14), rgba(201,169,110,0.10));
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .user-dropdown-name {
            color: #fff;
            font-size: 0.98rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .user-dropdown-email {
            color: rgba(255,255,255,0.45);
            font-size: 0.76rem;
        }

        .user-dropdown-links {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .user-dropdown-links a,
        .user-dropdown-links button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 15px;
            border-radius: 16px;
            text-decoration: none;
            background: none;
            border: none;
            color: rgba(255,255,255,0.80);
            font-family: 'Jost', sans-serif;
            font-size: 0.84rem;
            text-align: left;
            transition: background 0.24s ease, color 0.24s ease, transform 0.24s ease, border-color 0.24s ease;
            border: 1px solid transparent;
        }

        .user-dropdown-links a:hover,
        .user-dropdown-links button:hover {
            background: rgba(255,255,255,0.05);
            color: var(--gold);
            transform: translateX(5px);
            border-color: rgba(255,255,255,0.04);
        }

        .dropdown-link-text {
            display: inline-flex;
            align-items: center;
        }

        .dropdown-link-arrow {
            color: rgba(255,255,255,0.28);
            font-size: 0.92rem;
            transition: transform 0.24s ease, color 0.24s ease;
        }

        .user-dropdown-links a:hover .dropdown-link-arrow,
        .user-dropdown-links button:hover .dropdown-link-arrow {
            transform: translateX(3px);
            color: var(--gold);
        }

        .user-dropdown-links .admin-link {
            background: linear-gradient(135deg, rgba(200,116,138,0.12), rgba(201,169,110,0.08));
            border: 1px solid rgba(200,116,138,0.10);
            color: #fff;
        }

        .user-dropdown-links .admin-link:hover {
            background: linear-gradient(135deg, rgba(200,116,138,0.18), rgba(201,169,110,0.14));
            color: var(--gold);
        }

        .logout-btn {
            cursor: none;
        }

        .marquee-bar {
            position: fixed;
            top: 78px;
            left: 0;
            width: 100%;
            z-index: 1200;
            background: linear-gradient(90deg, #cfa06d 0%, #c4748b 34%, #c99974 68%, #b96d8c 100%);
            background-size: 200% auto;
            animation: gradientMove 6s linear infinite;
            padding: 12px 0;
            overflow: hidden;
            transition: top 0.4s ease;
        }

        #navbar.nav-compact ~ .marquee-bar { top: 72px; }
        #navbar.nav-hidden ~ .marquee-bar { top: 0; }

        @keyframes gradientMove { to { background-position: 200% center; } }

        .marquee-inner {
            display: flex; gap: 0; white-space: nowrap;
            animation: marquee 24s linear infinite;
        }

        .marquee-inner span {
            color: rgba(255,255,255,0.95);
            font-size: 0.66rem; letter-spacing: 0.24em; text-transform: uppercase;
            padding: 0 34px;
        }

        .marquee-inner span::before { content: '✦'; margin-right: 34px; opacity: 0.66; }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        main {
            padding-top: 120px;
            min-height: 100vh;
            position: relative;
        }

        main > *:first-child { margin-top: 0 !important; }

        #toast-success {
            position: fixed; bottom: 32px; right: 32px; z-index: 9999;
            background: var(--dark); color: #fff;
            padding: 14px 24px; border-radius: 12px;
            border-left: 3px solid var(--rose);
            font-size: 0.82rem; letter-spacing: 0.05em;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            animation: slideIn 0.4s ease;
        }

        @keyframes slideIn { from { transform: translateX(60px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        footer {
            position: relative; overflow: hidden;
            background:
                radial-gradient(circle at 14% 18%, rgba(200,116,138,0.10), transparent 18%),
                radial-gradient(circle at 84% 30%, rgba(201,169,110,0.10), transparent 18%),
                linear-gradient(180deg, #1a0f14 0%, #140a0f 100%);
            padding: 70px 48px 42px;
            margin-top: 80px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        footer::before {
            content: ''; position: absolute; inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,0.26), transparent 90%);
            pointer-events: none;
        }

        .footer-grid {
            position: relative; z-index: 1;
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px; max-width: 1200px; margin: 0 auto 40px;
        }

        .footer-brand, .footer-col { transition: transform 0.3s ease; }
        .footer-brand:hover, .footer-col:hover { transform: translateY(-4px); }

        .footer-brand .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; color: #fff; margin-bottom: 14px; }
        .footer-brand .logo-text span { color: var(--gold); font-style: italic; }
        .footer-brand p { color: rgba(255,255,255,0.48); font-size: 0.84rem; line-height: 1.85; max-width: 320px; }

        .footer-col h4 {
            position: relative; color: var(--gold);
            font-size: 0.68rem; letter-spacing: 0.22em; text-transform: uppercase;
            margin-bottom: 18px; padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: ''; position: absolute; left: 0; bottom: 0;
            width: 34px; height: 1px;
            background: linear-gradient(90deg, var(--gold), transparent);
        }

        .footer-col a, .footer-col span {
            display: inline-block; color: rgba(255,255,255,0.50);
            text-decoration: none; font-size: 0.84rem; margin-bottom: 10px;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .footer-col a:hover { color: var(--rose); transform: translateX(3px); }

        .footer-bottom {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 24px;
            display: flex; justify-content: space-between; align-items: center;
            gap: 18px; flex-wrap: wrap;
        }

        .footer-bottom p { color: rgba(255,255,255,0.26); font-size: 0.72rem; }

        .footer-glow-line {
            position: absolute; top: 0; left: 50%; width: 240px; height: 1px;
            transform: translateX(-50%);
            background: linear-gradient(90deg, transparent, rgba(201,169,110,0.7), transparent);
            filter: blur(0.5px);
        }

        .reveal-up { opacity: 0; transform: translateY(22px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-up.show { opacity: 1; transform: translateY(0); }

        .btn-connexion {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--rose), var(--rose-deep));
            color: #fff;
            text-decoration: none;
            font-size: 0.74rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .btn-connexion:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(200,116,138,0.20);
        }

        @media (max-width: 900px) {
            #navbar { padding: 0 18px; }
            .nav-left { min-width: auto; gap: 10px; }
            .back-btn { padding: 8px 12px; font-size: 0.64rem; letter-spacing: 0.1em; }
            .back-btn span:last-child { display: none; }
            .nav-center { display: none; }
            .marquee-bar { top: 78px; }
            main { padding-top: 120px; }
            footer { padding: 58px 24px 36px; }
            .footer-grid { grid-template-columns: 1fr; gap: 28px; }
            .nav-search-input-wrap.open { width: 160px; }
            .search-results-dropdown { width: 280px; right: -20px; }
        }
    </style>
</head>
<body>
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <nav id="navbar">
        <div class="nav-left">
            @if(!request()->routeIs('home'))
                <button type="button" class="back-btn" onclick="window.history.back()" aria-label="Retour">
                    <span class="back-arrow">←</span>
                    <span>Retour</span>
                </button>
            @endif
            <a href="{{ route('home') }}" class="nav-logo">Glo<span>wi</span></a>
        </div>

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
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Yeux']) }}">Yeux</a>
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Teint']) }}">Teint</a>
                    <a href="{{ route('products.index', ['category' => 'maquillage', 'type' => 'Gloss']) }}">Lèvres</a>
                </div>
            </div>

            <a href="{{ route('products.index', ['category' => 'accessoires']) }}" class="nav-link {{ request('category') === 'accessoires' ? 'active' : '' }}">Accessoires</a>
        </div>

        <div class="nav-right">
            <div class="nav-search-wrap" id="searchWrap">
                <div class="nav-search-input-wrap" id="searchInputWrap">
                    <input
                        type="text"
                        class="nav-search-input"
                        id="navSearchInput"
                        placeholder="Rechercher un produit..."
                        autocomplete="off"
                    >
                </div>
                <button class="nav-search-btn" id="searchToggleBtn" aria-label="Rechercher" type="button">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L16.65 16.65" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.8 18.1C14.8317 18.1 18.1 14.8317 18.1 10.8C18.1 6.76832 14.8317 3.5 10.8 3.5C6.76832 3.5 3.5 6.76832 3.5 10.8C3.5 14.8317 6.76832 18.1 10.8 18.1Z"/>
                    </svg>
                </button>
                <div class="search-results-dropdown" id="searchResultsDropdown"></div>
            </div>

            @auth
                <a href="{{ route('wishlist.index') }}" class="nav-cart" aria-label="Wishlist" title="Ma wishlist">
                    <span class="cart-icon-wrap">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </span>
                    <span class="cart-badge" id="wish-badge" style="{{ Auth::check() ? '' : 'display:none' }}">
                        ♡
                    </span>
                </a>

                <a href="{{ route('cart.index') }}" class="nav-cart" aria-label="Panier">
                    <span class="cart-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 01-8 0"/>
                        </svg>
                    </span>
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="cart-badge" id="cart-badge">{{ $cartCount }}</span>
                    @else
                        <span class="cart-badge" id="cart-badge" style="display:none;">0</span>
                    @endif
                </a>

                <div class="user-menu" id="userMenu">
                    <button type="button" class="user-menu-trigger" id="userMenuTrigger" aria-expanded="false" aria-haspopup="true">
                        <div class="user-avatar">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                    </button>

                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                            <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="user-dropdown-links">
                            <a href="{{ route('profile.index') }}">
                                <span class="dropdown-link-text">Mon profil</span>
                                <span class="dropdown-link-arrow">↗</span>
                            </a>

                            <a href="{{ route('orders') }}">
                                <span class="dropdown-link-text">Mes commandes</span>
                                <span class="dropdown-link-arrow">↗</span>
                            </a>

                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="admin-link">
                                    <span class="dropdown-link-text">Dashboard admin</span>
                                    <span class="dropdown-link-arrow">↗</span>
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <span class="dropdown-link-text">Déconnexion</span>
                                    <span class="dropdown-link-arrow">↗</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-connexion">Connexion</a>
            @endauth
        </div>
    </nav>

    <div class="marquee-bar" id="marqueeBar">
        <div class="marquee-inner">
            @php
                $items = [
                    'Skincare de Prestige','Maquillage Raffiné','Accessoires Curatés',
                    'Beauté Authentique','Glowi Paris','Livraison Offerte','Produits Sélectionnés',
                    'Skincare de Prestige','Maquillage Raffiné','Accessoires Curatés',
                    'Beauté Authentique','Glowi Paris','Livraison Offerte','Produits Sélectionnés'
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

    <footer class="reveal-up">
        <div class="footer-glow-line"></div>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo-text">Glo<span>wi</span></div>
                <p>Une curation soignée de beauté authentique.<br>Skincare de prestige, maquillage raffiné,<br>accessoires curatés — pour sublimer chaque femme.</p>
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
                    <a href="{{ route('profile.index') }}">Mon profil</a>
                    <a href="{{ route('orders') }}">Mes commandes</a>
                    <a href="{{ route('cart.index') }}">Mon panier</a>
                @else
                    <a href="{{ route('login') }}">Connexion</a>
                    <a href="{{ route('register') }}">Créer un compte</a>
                @endauth
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Glowi. Tous droits réservés.</p>
            <p style="color:rgba(255,255,255,0.16);font-size:0.65rem;letter-spacing:0.1em;">BEAUTÉ AUTHENTIQUE & LUXE</p>
        </div>
    </footer>

    @yield('scripts')

    <script>
    (function () {
        const cursor = document.getElementById('cursor');
        const ring   = document.getElementById('cursor-ring');

        const enableCustomCursor =
            window.matchMedia('(hover: hover)').matches &&
            window.matchMedia('(pointer: fine)').matches &&
            window.innerWidth > 900;

        if (enableCustomCursor && cursor && ring) {
            let mouseX = window.innerWidth  / 2;
            let mouseY = window.innerHeight / 2;
            let ringX  = mouseX;
            let ringY  = mouseY;

            function setCursorPos(x, y) {
                cursor.style.transform = `translate3d(${x - 6}px, ${y - 6}px, 0)`;
            }
            function setRingPos(x, y) {
                ring.style.transform = `translate3d(${x - 18}px, ${y - 18}px, 0)`;
            }

            setCursorPos(mouseX, mouseY);
            setRingPos(ringX, ringY);

            function onPointerMove(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                setCursorPos(mouseX, mouseY);
                try {
                    sessionStorage.setItem('glowi_cursor_x', mouseX);
                    sessionStorage.setItem('glowi_cursor_y', mouseY);
                } catch (_) {}
            }

            document.addEventListener('mousemove', onPointerMove, { passive: true });
            document.addEventListener('pointermove', onPointerMove, { passive: true });

            (function animateRing() {
                ringX += (mouseX - ringX) * 0.18;
                ringY += (mouseY - ringY) * 0.18;
                setRingPos(ringX, ringY);
                requestAnimationFrame(animateRing);
            })();

            window.addEventListener('pageshow', () => {
                try {
                    const sx = parseFloat(sessionStorage.getItem('glowi_cursor_x'));
                    const sy = parseFloat(sessionStorage.getItem('glowi_cursor_y'));
                    if (!isNaN(sx) && !isNaN(sy)) {
                        mouseX = ringX = sx;
                        mouseY = ringY = sy;
                        setCursorPos(mouseX, mouseY);
                        setRingPos(ringX, ringY);
                    }
                } catch (_) {}
            });

            document.addEventListener('mousedown', () => {
                cursor.style.transform = `translate3d(${mouseX - 6}px, ${mouseY - 6}px, 0) scale(1.6)`;
                ring.style.opacity = '0.18';
            });
            document.addEventListener('mouseup', () => {
                cursor.style.transform = `translate3d(${mouseX - 6}px, ${mouseY - 6}px, 0) scale(1)`;
                ring.style.opacity = '0.55';
            });

            document.querySelectorAll('a, button, input, select, textarea').forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursor.style.transform = `translate3d(${mouseX - 6}px, ${mouseY - 6}px, 0) scale(2.15)`;
                    ring.style.opacity = '0.15';
                });
                el.addEventListener('mouseleave', () => {
                    cursor.style.transform = `translate3d(${mouseX - 6}px, ${mouseY - 6}px, 0) scale(1)`;
                    ring.style.opacity = '0.55';
                });
            });
        }

        const navbar     = document.getElementById('navbar');
        const marqueeBar = document.getElementById('marqueeBar');
        let lastScrollY  = window.scrollY;

        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            navbar.classList.toggle('scrolled', y > 20);
            navbar.classList.toggle('nav-compact', y > 80);

            if (y > 180 && y > lastScrollY) {
                navbar.classList.add('nav-hidden');
                marqueeBar.style.top = '0';
            } else {
                navbar.classList.remove('nav-hidden');
                marqueeBar.style.top = (navbar.classList.contains('nav-compact') ? 72 : 78) + 'px';
            }
            lastScrollY = y;
        });

        const toast = document.getElementById('toast-success');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.4s';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }

        const userMenu = document.getElementById('userMenu');
        const userMenuTrigger = document.getElementById('userMenuTrigger');

        if (userMenu && userMenuTrigger) {
            userMenuTrigger.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = userMenu.classList.toggle('open');
                userMenuTrigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (e) {
                if (!userMenu.contains(e.target)) {
                    userMenu.classList.remove('open');
                    userMenuTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }

        const searchToggleBtn   = document.getElementById('searchToggleBtn');
        const searchInputWrap   = document.getElementById('searchInputWrap');
        const navSearchInput    = document.getElementById('navSearchInput');
        const searchResultsDrop = document.getElementById('searchResultsDropdown');
        let searchOpen = false;
        let _navSearchTimeout = null;

        if (searchToggleBtn) {
            searchToggleBtn.addEventListener('click', e => {
                e.stopPropagation();
                searchOpen = !searchOpen;
                if (searchOpen) {
                    searchInputWrap.classList.add('open');
                    setTimeout(() => navSearchInput.focus(), 350);
                } else {
                    searchInputWrap.classList.remove('open');
                    searchResultsDrop.classList.remove('show');
                    navSearchInput.value = '';
                }
            });
        }

        if (navSearchInput) {
            navSearchInput.addEventListener('input', function () {
                clearTimeout(_navSearchTimeout);
                const q = this.value.trim();
                if (q.length < 2) {
                    searchResultsDrop.classList.remove('show');
                    return;
                }
                searchResultsDrop.innerHTML = '<div class="search-loading">Recherche…</div>';
                searchResultsDrop.classList.add('show');
                _navSearchTimeout = setTimeout(() => doNavSearch(q), 300);
            });

            navSearchInput.addEventListener('keydown', e => {
                if (e.key === 'Escape') searchToggleBtn.click();
            });
        }

        async function doNavSearch(q) {
            try {
                const res = await fetch(`/products/search?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                if (!data.length) {
                    searchResultsDrop.innerHTML = '<div class="search-no-results">Aucun résultat trouvé</div>';
                    return;
                }
                searchResultsDrop.innerHTML = data.map(p => `
                    <a href="/products/${p.id}" class="search-result-item">
                        <img class="search-result-img"
                             src="${p.image_url || ''}" alt="${escHtml(p.name)}"
                             onerror="this.src='https://via.placeholder.com/42x42/f5e6ea/c8748a?text=G'">
                        <div class="search-result-info">
                            <div class="search-result-name">${escHtml(p.name)}</div>
                            <div class="search-result-brand">${escHtml(p.brand || p.category || '')}</div>
                        </div>
                        <div class="search-result-price">${parseFloat(p.price).toFixed(2)} TND</div>
                    </a>
                `).join('');
            } catch (_) {
                searchResultsDrop.innerHTML = '<div class="search-no-results">Erreur de connexion</div>';
            }
        }

        function escHtml(str) {
            return (str || '').replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
        }

        document.addEventListener('click', e => {
            const wrap = document.getElementById('searchWrap');
            if (wrap && !wrap.contains(e.target)) {
                searchInputWrap && searchInputWrap.classList.remove('open');
                searchResultsDrop && searchResultsDrop.classList.remove('show');
                navSearchInput && (navSearchInput.value = '');
                searchOpen = false;
            }
        });

        window.updateCartBadge = function (count, animate = true) {
            const badge = document.getElementById('cart-badge');
            if (!badge) return;
            const n = Math.max(0, parseInt(count || 0));
            badge.style.display = n > 0 ? 'flex' : 'none';
            badge.textContent = n;
            if (animate && n > 0) {
                badge.classList.remove('bump');
                void badge.offsetWidth;
                badge.classList.add('bump');
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const obs = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('show'); });
            }, { threshold: 0.12 });
            document.querySelectorAll('.reveal-up').forEach(el => obs.observe(el));
        });
    })();
    </script>
</body>
</html>