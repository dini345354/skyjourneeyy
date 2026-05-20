<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title') - SkyJourney</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✈️</text></svg>"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #0066CC 0%, #004499 50%, #002266 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .auth-header {
            background: linear-gradient(135deg, #0066CC, #0099FF);
            padding: 35px 40px 30px;
            text-align: center;
            color: white;
        }
        .auth-header .brand-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 12px;
        }
        .auth-header h1 { font-size: 1.6rem; font-weight: 700; margin: 0 0 4px; }
        .auth-header p { font-size: 0.85rem; opacity: 0.85; margin: 0; }
        .auth-body { padding: 35px 40px; }
        .form-label { font-weight: 500; font-size: 0.875rem; color: #344054; }
        .form-control, .form-select {
            border: 1.5px solid #D0D5DD;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0066CC;
            box-shadow: 0 0 0 3px rgba(0,102,204,0.12);
        }
        .btn-sky {
            background: linear-gradient(135deg, #0066CC, #0099FF);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all .2s;
        }
        .btn-sky:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
        .auth-footer { text-align: center; padding: 0 40px 30px; font-size: 0.875rem; color: #667085; }
        .auth-footer a { color: #0066CC; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper .ri { position: absolute; top: 50%; transform: translateY(-50%); left: 14px; color: #9CA3AF; font-size: 18px; }
        .input-icon-wrapper .form-control { padding-left: 40px; }
        .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 0; }
        .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; color: #9CA3AF; font-size: 0.8rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #E4E7EC; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="brand-icon">✈️</div>
            <h1>SkyJourney</h1>
            <p>Reservasi & Jual Beli Tiket Pesawat</p>
        </div>
        <div class="auth-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible py-2 mb-3" role="alert">
                <i class="ri-check-line me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible py-2 mb-3" role="alert">
                <i class="ri-error-warning-line me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @yield('content')
        </div>
        @yield('footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (!input) return;
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                this.querySelector('i').className = isPass ? 'ri ri-eye-line' : 'ri ri-eye-off-line';
            });
        });
    </script>
    <script>
function scrollToTiket() {
    const tiketSection = document.getElementById('semua-tiket');
    const navbar = document.querySelector('.navbar');
    const navbarHeight = navbar ? navbar.offsetHeight : 70;
    
    if (tiketSection) {
        const elementPosition = tiketSection.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - navbarHeight;
        
        window.scrollTo({
            top: offsetPosition,
            behavior: "smooth"
        });
    }
}
</script>
</body>
</html>
