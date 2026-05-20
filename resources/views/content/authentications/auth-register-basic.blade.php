@extends('layouts.auth.app')
@section('title', 'Register')

@section('content')
<h5 class="fw-semibold mb-1 text-center">Buat Akun Baru 🚀</h5>
<p class="text-muted text-center mb-4" style="font-size:.85rem">Bergabung dengan SkyJourney sekarang</p>

@if($errors->any())
<div class="alert alert-danger py-2 mb-3">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li style="font-size:.875rem">{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <div class="input-icon-wrapper">
            <i class="ri ri-user-line"></i>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-icon-wrapper">
            <i class="ri ri-mail-line"></i>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">No. HP <span class="text-muted fw-normal">(opsional)</span></label>
        <div class="input-icon-wrapper">
            <i class="ri ri-phone-line"></i>
            <input type="text" name="phone" class="form-control"
                value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-icon-wrapper" style="position:relative">
            <i class="ri ri-lock-line"></i>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required
                style="padding-left:40px;padding-right:42px">
            <button type="button" class="toggle-password"><i class="ri ri-eye-off-line"></i></button>
        </div>
    </div>
    <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <div class="input-icon-wrapper" style="position:relative">
            <i class="ri ri-lock-2-line"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required
                style="padding-left:40px;padding-right:42px">
            <button type="button" class="toggle-password"><i class="ri ri-eye-off-line"></i></button>
        </div>
    </div>
    <button type="submit" class="btn btn-sky w-100 mb-3">
        <i class="ri ri-user-add-line me-2"></i>Daftar Sekarang
    </button>
</form>
<div class="divider">atau</div>
<div class="text-center">
    <span style="font-size:.875rem;color:#667085">Sudah punya akun? </span>
    <a href="{{ route('login') }}">Masuk di sini</a>
</div>
@endsection

@section('footer')
<div class="auth-footer">
    <p class="mb-0">© {{ date('Y') }} SkyJourney. All rights reserved.</p>
</div>
@endsection
