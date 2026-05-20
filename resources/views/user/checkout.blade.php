@extends('layouts.user.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">💳 Checkout</h2>
    <p class="text-muted mb-4">Lengkapi data pemesanan Anda</p>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Form Data Pembeli -->
            <div class="col-lg-7">
                @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px">
                    <h5 class="fw-bold mb-4">👤 Data Pemesan</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pembeli" class="form-control @error('nama_pembeli') is-invalid @enderror"
                                value="{{ old('nama_pembeli', $user->name) }}"
                                placeholder="Nama sesuai KTP" required style="border-radius:10px">
                            @error('nama_pembeli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                placeholder="email@contoh.com" required style="border-radius:10px">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp', $user->phone) }}"
                                placeholder="08xxxxxxxxxx" required style="border-radius:10px">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                rows="3" placeholder="Jl. ... No. ..., Kota, Provinsi"
                                required style="border-radius:10px">{{ old('alamat', $user->address) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Tiket yang dipesan -->
                <div class="card border-0 shadow-sm p-4" style="border-radius:16px">
                    <h5 class="fw-bold mb-4">✈️ Detail Tiket</h5>
                    @foreach($carts as $cart)
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        @if($cart->product->gambar)
                        <img src="{{ asset('storage/' . $cart->product->gambar) }}" alt=""
                            style="width:70px;height:55px;object-fit:cover;border-radius:10px;flex-shrink:0">
                        @else
                        <div style="width:70px;height:55px;background:#E8F4FF;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0">✈️</div>
                        @endif
                        <div class="flex-fill">
                            <div class="fw-semibold" style="font-size:.9rem">{{ $cart->product->nama_tiket }}</div>
                            <div class="text-muted" style="font-size:.78rem">
                                {{ $cart->product->maskapai }} · {{ $cart->product->asal }} → {{ $cart->product->tujuan }}
                            </div>
                            <div class="text-muted" style="font-size:.78rem">
                                {{ \Carbon\Carbon::parse($cart->product->tanggal_keberangkatan)->isoFormat('D MMM Y, HH:mm') }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted" style="font-size:.78rem">{{ $cart->jumlah }} tiket</div>
                            <div class="fw-bold" style="color:var(--sky-primary);font-size:.9rem">
                                Rp {{ number_format($cart->jumlah * $cart->product->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4" style="border-radius:16px;position:sticky;top:90px">
                    <h5 class="fw-bold mb-4">📋 Ringkasan Pembayaran</h5>

                    @foreach($carts as $cart)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" style="font-size:.825rem">
                            {{ Str::limit($cart->product->nama_tiket, 22) }} ×{{ $cart->jumlah }}
                        </span>
                        <span style="font-size:.825rem">Rp {{ number_format($cart->jumlah * $cart->product->harga, 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Biaya Layanan</span>
                        <span class="text-success fw-semibold">GRATIS</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Pajak</span>
                        <span class="text-success fw-semibold">Sudah termasuk</span>
                    </div>

                    <div class="p-3 rounded-3 mb-4" style="background:linear-gradient(135deg,#E8F4FF,#F0F8FF);border:1.5px solid #B3D4FF">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size:1rem">Total Pembayaran</span>
                            <span class="fw-bold" style="font-size:1.3rem;color:var(--sky-primary)">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-book" style="padding:14px;font-size:1rem">
                            <i class="ri-secure-payment-line me-2"></i>Konfirmasi Pesanan
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary" style="border-radius:10px">
                            <i class="ri-arrow-left-line me-1"></i>Kembali ke Keranjang
                        </a>
                    </div>

                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="ri-shield-check-line me-1 text-success"></i>Pembayaran aman &amp; terenkripsi
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
