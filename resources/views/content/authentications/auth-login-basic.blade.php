@extends('layouts.auth.app')
@section('title', 'Login')

@section('content')
<h5 class="fw-semibold mb-1 text-center">Selamat Datang Kembali! 👋</h5>
<p class="text-muted text-center mb-4" style="font-size:.85rem">Masuk ke akun SkyJourney Anda</p>

@if($errors->any())
<div class="alert alert-danger py-2 mb-3">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li style="font-size:.875rem">{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-icon-wrapper">
            <i class="ri ri-mail-line"></i>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="admin@skyjourney.com" autofocus required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label mb-0">Password</label>
        <div class="input-icon-wrapper mt-1" style="position:relative">
            <i class="ri ri-lock-line"></i>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required
                style="padding-left:40px;padding-right:42px">
            <button type="button" class="toggle-password"><i class="ri ri-eye-off-line"></i></button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:.85rem">Ingat saya</label>
        </div>
    </div>
    <button type="submit" class="btn btn-sky w-100 mb-3">
        <i class="ri ri-login-box-line me-2"></i>Masuk
    </button>
</form>
<div class="divider">atau</div>
<div class="text-center">
    <span style="font-size:.875rem;color:#667085">Belum punya akun? </span>
    <a href="{{ route('register') }}">Daftar sekarang</a>
</div>
<div class="mt-4 p-3 rounded-3" style="background:#F0F7FF;border:1px solid #B3D4FF">
    <p class="mb-1" style="font-size:.78rem;font-weight:600;color:#0066CC">Demo Login:</p>
    <p class="mb-0" style="font-size:.78rem;color:#0066CC">Admin: admin@skyjourney.com / admin123<br>User: budi@example.com / password</p>
</div>
@endsection

@section('footer')
<div class="auth-footer">
    <p class="mb-0">© {{ date('Y') }} SkyJourney. All rights reserved.</p>
</div>
@endsection
