<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Tiket Pesawat') - SkyJourney</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✈️</text></svg>"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        * { font-family: 'Inter', sans-serif; }
        :root {
            --sky-primary: #0066CC;
            --sky-secondary: #0099FF;
            --sky-dark: #003380;
            --sky-light: #E8F4FF;
        }

        /* NAVBAR */
        .sky-navbar {
            background: rgba(0, 51, 128, 0.97);
            backdrop-filter: blur(10px);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }
        .sky-navbar .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: white !important;
            letter-spacing: -0.5px;
        }
        .sky-navbar .navbar-brand span { color: #66CCFF; }
        .sky-navbar .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 1.2rem 1rem !important;
            transition: color .2s;
        }
        .sky-navbar .nav-link:hover, .sky-navbar .nav-link.active { color: #66CCFF !important; }
        .sky-navbar .btn-nav-login {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.5);
            color: white;
            border-radius: 8px;
            padding: 6px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all .2s;
        }
        .sky-navbar .btn-nav-login:hover { background: rgba(255,255,255,0.1); border-color: white; color: white; }
        .sky-navbar .btn-nav-register {
            background: linear-gradient(135deg, #0099FF, #66CCFF);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 6px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all .2s;
        }
        .sky-navbar .btn-nav-register:hover { opacity: 0.9; color: white; }
        .cart-badge {
            background: #FF4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 8px;
            right: 4px;
            font-weight: 700;
        }

        /* HERO */
        .sky-hero {
            background: linear-gradient(135deg, #003380 0%, #0066CC 50%, #0099FF 100%);
            padding: 70px 0 50px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .sky-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .sky-hero h1 { font-size: 2.5rem; font-weight: 800; line-height: 1.2; }
        .sky-hero p { font-size: 1.05rem; opacity: 0.85; }

        /* SEARCH BAR */
        .search-bar {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        .search-bar .form-control, .search-bar .form-select {
            border: 1.5px solid #E4E7EC;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
        }
        .search-bar .form-control:focus, .search-bar .form-select:focus {
            border-color: var(--sky-primary);
            box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
        }
        .btn-search {
            background: linear-gradient(135deg, #0066CC, #0099FF);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
        }
        .btn-search:hover { opacity: 0.9; color: white; }

        /* CARD TIKET */
        .ticket-card {
            border: 1.5px solid #E4E7EC;
            border-radius: 16px;
            overflow: hidden;
            transition: all .3s;
            height: 100%;
            background: white;
        }
        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,102,204,0.15);
            border-color: #B3D4FF;
        }
        .ticket-card-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        .ticket-card-img-placeholder {
            height: 180px;
            background: linear-gradient(135deg, #E8F4FF, #B3D4FF);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }
        .ticket-card-body { padding: 18px; }
        .ticket-route {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 1rem;
            color: #1A1A2E;
            margin-bottom: 4px;
        }
        .ticket-route .ri-arrow-right-line { color: var(--sky-primary); }
        .ticket-airline {
            font-size: 0.8rem;
            color: #667085;
            margin-bottom: 10px;
        }
        .ticket-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--sky-primary);
        }
        .ticket-price small { font-size: 0.7rem; font-weight: 400; color: #9CA3AF; }
        .ticket-stok { font-size: 0.75rem; color: #9CA3AF; }
        .ticket-date { font-size: 0.8rem; color: #667085; }
        .btn-book {
            background: linear-gradient(135deg, #0066CC, #0099FF);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all .2s;
            width: 100%;
        }
        .btn-book:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
        .badge-category {
            background: var(--sky-light);
            color: var(--sky-primary);
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid #B3D4FF;
        }

        /* FOOTER */
        .sky-footer {
            background: #001A4D;
            color: rgba(255,255,255,0.75);
            padding: 50px 0 24px;
            margin-top: 80px;
        }
        .sky-footer h5 { color: white; font-weight: 700; margin-bottom: 16px; }
        .sky-footer a { color: rgba(255,255,255,0.65); text-decoration: none; display: block; margin-bottom: 8px; font-size: 0.875rem; }
        .sky-footer a:hover { color: #66CCFF; }
        .sky-footer .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 40px;
            font-size: 0.85rem;
        }
        .sky-footer .social-link {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: background .2s;
            margin-right: 8px;
        }
        .sky-footer .social-link:hover { background: var(--sky-primary); color: white; }

        /* ALERTS */
        .alert { border-radius: 10px; border: none; }

        /* MISC */
        .section-title { font-size: 1.6rem; font-weight: 800; color: #1A1A2E; }
        .section-sub { color: #667085; font-size: 0.95rem; }
        .empty-state { text-align: center; padding: 60px 20px; color: #9CA3AF; }
        .empty-state i { font-size: 64px; margin-bottom: 16px; display: block; }

        @media(max-width: 768px) {
            .sky-hero h1 { font-size: 1.8rem; }
            .sky-hero { padding: 50px 0 30px; }
        }
    </style>
    @yield('extra-css')
</head>
<body style="background:#F8FAFC">

<!-- NAVBAR -->
<nav class="sky-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.home') }}">
            ✈️ Sky<span>Journey</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <i class="ri-menu-3-line" style="color:white;font-size:22px"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}" href="{{ route('user.home') }}">
                        <i class="ri-home-2-line me-1"></i>Beranda
                    </a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="#semua-tiket" onclick="scrollToTiket()">
                         <i class="ri-plane-line me-1"></i>Tiket Pesawat
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="ri-file-list-3-line me-1"></i>Pesanan Saya
                    </a>
                </li>
                @endauth
            </ul>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('cart.index') }}" class="btn btn-nav-login position-relative">
                        <i class="ri-shopping-cart-2-line"></i>
                        @php $cartCount = auth()->user()->carts()->count(); @endphp
                        @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-nav-register dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="ri-user-3-line me-1"></i>{{ Str::limit(auth()->user()->name, 12) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="ri-file-list-3-line me-2"></i>Pesanan Saya</a></li>
                            @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="ri-dashboard-line me-2"></i>Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="ri-logout-box-r-line me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-nav-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-nav-register">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success') || session('error'))
<div class="container mt-3">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
        <i class="ri-check-double-line me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
        <i class="ri-error-warning-line me-2 fs-5"></i>
        <div>{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
</div>
@endif

<!-- MAIN CONTENT -->
@yield('content')

<!-- FOOTER -->
<footer class="sky-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5>✈️ SkyJourney</h5>
                <p style="font-size:.875rem;line-height:1.7">Platform reservasi dan jual beli tiket pesawat terpercaya. Temukan harga terbaik untuk perjalanan Anda.</p>
                <div class="mt-3">
                   <div class="d-flex gap-3">
    <a href="https://wa.me/6282386676088" class="social-link" target="_blank" rel="noopener noreferrer">
        <i class="ri-whatsapp-line"></i>
    </a>
    <a href="https://www.instagram.com/hadniinid_ep?igsh=MWZ2aG9kbTZ4M2djeQ==" class="social-link" target="_blank" rel="noopener noreferrer">
        <i class="ri-instagram-line"></i>
    </a>
    <a href="https://github.com/dini345354" class="social-link" target="_blank" rel="noopener noreferrer">
        <i class="ri-github-fill"></i>
    </a>
   <a href="mailto:abb627202@gmail.com" class="social-link" target="_blank" title="Email Kami">
    <i class="ri-mail-line"></i>
</a>
</div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h5>Layanan</h5>
                 <a href="#semua-tiket" onclick="scrollToTiketWithFilter('')">Tiket Domestik</a>
                  <a href="#semua-tiket" onclick="scrollToTiketWithFilter('2')">Tiket Internasional</a>
                  <a href="#semua-tiket" onclick="scrollToTiketWithFilter('3')">Promo Tiket</a>
                  <a href="#semua-tiket" onclick="scrollToTiketWithFilter('4')">Kelas Bisnis</a>
            </div>
            <div class="col-lg-2 col-6">
                <h5>Akun</h5>
                @auth
                <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                <a href="{{ route('cart.index') }}">Keranjang</a>
                @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
            <div class="col-lg-4">
                <h5>Kontak</h5>
                <p style="font-size:.875rem"><i class="ri-mail-line me-2"></i>info@skyjourney.com</p>
                <p style="font-size:.875rem"><i class="ri-phone-line me-2"></i>+62 21-1234-5678</p>
                <p style="font-size:.875rem"><i class="ri-map-pin-2-line me-2"></i>Jakarta, Indonesia</p>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
            <p class="mb-0">© {{ date('Y') }} SkyJourney. All rights reserved.</p>
            <p class="mb-0">UAS Web Programming kelompok 1</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('extra-js')
</body>
</html>
