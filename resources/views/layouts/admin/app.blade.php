<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Admin') - SkyJourney</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✈️</text></svg>"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        * { font-family: 'Inter', sans-serif; }
        :root { --sky-primary:#0066CC; --sky-dark:#003380; --sky-light:#E8F4FF; }

        body { background:#F4F5FB; }

        /* SIDEBAR */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #001A4D 0%, #003380 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 999;
            transition: transform .3s;
            overflow-y: auto;
        }
        #sidebar .brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .brand-name {
            font-size: 1.2rem;
            font-weight: 800;
            color: white;
            letter-spacing: -.5px;
        }
        #sidebar .brand-name span { color: #66CCFF; }
        #sidebar .menu-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,.35);
            padding: 20px 20px 6px;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.7) !important;
            padding: 10px 20px;
            border-radius: 0;
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 3px solid transparent;
        }
        #sidebar .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,.07);
            border-left-color: rgba(255,255,255,.3);
        }
        #sidebar .nav-link.active {
            color: white !important;
            background: rgba(102,204,255,.15);
            border-left-color: #66CCFF;
        }
        #sidebar .nav-link i { font-size: 18px; width: 22px; }
        #sidebar .nav-link .badge { margin-left: auto; }

        /* MAIN */
        .main-wrapper { margin-left: 260px; transition: margin .3s; }

        /* TOPBAR */
        .topbar {
            background: white;
            border-bottom: 1px solid #E4E7EC;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,.06);
        }
        .topbar .menu-toggle { background:none;border:none;color:#667085;font-size:22px;display:none;cursor:pointer; }

        /* CONTENT */
        .content-area { padding: 28px 28px; }

        /* CARDS */
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            border: 1.5px solid #E4E7EC;
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,.08); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }

        .card { border: 1.5px solid #E4E7EC !important; border-radius: 14px !important; box-shadow: none !important; }
        .card-header { background: white !important; border-bottom: 1.5px solid #E4E7EC !important; }
        .form-control, .form-select { border-radius: 10px !important; border: 1.5px solid #D0D5DD; font-size:.9rem; }
        .form-control:focus, .form-select:focus { border-color: var(--sky-primary) !important; box-shadow: 0 0 0 3px rgba(0,102,204,.1) !important; }
        .btn { border-radius: 8px !important; font-weight: 500; font-size: .875rem; }
        .btn-primary { background: linear-gradient(135deg,#0066CC,#0099FF) !important; border: none !important; }
        .table th { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #9CA3AF; border-bottom: 2px solid #E4E7EC !important; }
        .table td { vertical-align: middle; font-size: .875rem; }
        .badge { font-size: .72rem !important; padding: 4px 10px !important; border-radius: 20px !important; }
        .alert { border-radius: 10px !important; }
        .page-link { border-radius: 8px !important; margin: 0 2px; }

        @media(max-width:992px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar .menu-toggle { display: block; }
        }
    </style>
    @yield('extra-css')
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <span style="font-size:26px">✈️</span>
        <div>
            <div class="brand-name">Sky<span>Journey</span></div>
            <div style="font-size:.68rem;color:rgba(255,255,255,.4)">Admin Panel</div>
        </div>
    </div>

    <div class="menu-label">Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="ri-home-smile-line"></i> Dashboard
    </a>

    <div class="menu-label">Manajemen</div>
    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="ri-list-check"></i> Kategori
    </a>
    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="ri-plane-fill"></i> Tiket Pesawat
    </a>
    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="ri-shopping-bag-3-line"></i> Transaksi
    </a>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="ri-group-line"></i> Pelanggan
    </a>

    <div class="menu-label">Akun</div>
    <a href="{{ route('user.home') }}" class="nav-link" target="_blank">
        <i class="ri-store-2-line"></i> Lihat Website
    </a>
    <form action="{{ route('logout') }}" method="POST" id="admin-logout">@csrf</form>
    <a href="#" class="nav-link" onclick="document.getElementById('admin-logout').submit()">
        <i class="ri-logout-box-r-line"></i> Logout
    </a>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="ri-menu-3-line"></i>
            </button>
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-0" style="font-size:.8rem">
                    <li class="breadcrumb-item text-muted">Admin</li>
                    <li class="breadcrumb-item active">@yield('title', 'Dashboard')</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown"
                    style="border:1.5px solid #E4E7EC;font-size:.875rem">
                    <div style="width:30px;height:30px;background:linear-gradient(135deg,#0066CC,#0099FF);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.8rem">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-sm-inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="document.getElementById('admin-logout').submit()">
                        <i class="ri-logout-box-r-line me-2"></i>Logout
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content-area">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4">
            <i class="ri-check-double-line me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4">
            <i class="ri-error-warning-line me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <div class="text-center py-3 text-muted" style="font-size:.8rem;border-top:1px solid #E4E7EC;margin:0 28px">
        © {{ date('Y') }} SkyJourney Admin Panel
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('extra-js')
</body>
</html>
