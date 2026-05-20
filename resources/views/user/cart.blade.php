@extends('layouts.user.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">🛒 Keranjang Belanja</h2>
    <p class="text-muted mb-4">{{ $carts->count() }} tiket dalam keranjang</p>

    @if($carts->count())
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            @foreach($carts as $cart)
            <div class="card border-0 shadow-sm mb-3" style="border-radius:16px">
                <div class="card-body p-4">
                    <div class="row align-items-center g-3">
                        <!-- Gambar -->
                        <div class="col-auto">
                            @if($cart->product->gambar)
                            <img src="{{ asset('storage/' . $cart->product->gambar) }}" alt=""
                                style="width:90px;height:70px;object-fit:cover;border-radius:12px">
                            @else
                            <div style="width:90px;height:70px;background:linear-gradient(135deg,#E8F4FF,#B3D4FF);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:30px">✈️</div>
                            @endif
                        </div>

                        <!-- Info Tiket -->
                        <div class="col">
                            <div class="fw-semibold" style="font-size:.95rem;color:#1A1A2E">{{ $cart->product->nama_tiket }}</div>
                            <div class="text-muted" style="font-size:.8rem">
                                <i class="ri-plane-fill me-1" style="color:var(--sky-primary)"></i>{{ $cart->product->maskapai }}
                                &nbsp;·&nbsp;
                                {{ $cart->product->asal }} → {{ $cart->product->tujuan }}
                            </div>
                            <div class="text-muted" style="font-size:.78rem">
                                <i class="ri-calendar-line me-1"></i>
                                {{ \Carbon\Carbon::parse($cart->product->tanggal_keberangkatan)->isoFormat('D MMM Y, HH:mm') }} WIB
                            </div>
                            <div class="fw-bold mt-1" style="color:var(--sky-primary)">
                                Rp {{ number_format($cart->product->harga, 0, ',', '.') }} / orang
                            </div>
                        </div>

                        <!-- Qty Update -->
                        <div class="col-auto">
                            <form action="{{ route('cart.update', $cart) }}" method="POST" class="d-flex align-items-center gap-2">
                                @csrf @method('PATCH')
                                <button type="button" class="btn btn-outline-secondary btn-sm qty-dec"
                                    data-form="{{ $cart->id }}" style="width:32px;height:32px;padding:0;border-radius:8px">
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <input type="number" name="jumlah" class="form-control text-center qty-input"
                                    value="{{ $cart->jumlah }}" min="1" max="{{ $cart->product->stok_kursi }}"
                                    style="width:56px;padding:4px;border-radius:8px;font-weight:600"
                                    data-price="{{ $cart->product->harga }}"
                                    onchange="this.form.submit()">
                                <button type="button" class="btn btn-outline-secondary btn-sm qty-inc"
                                    data-form="{{ $cart->id }}" style="width:32px;height:32px;padding:0;border-radius:8px">
                                    <i class="ri-add-line"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Subtotal & Hapus -->
                        <div class="col-auto text-end">
                            <div class="fw-bold" style="color:#1A1A2E;font-size:1rem">
                                Rp {{ number_format($cart->jumlah * $cart->product->harga, 0, ',', '.') }}
                            </div>
                            <form action="{{ route('cart.destroy', $cart) }}" method="POST" class="mt-1"
                                onsubmit="return confirm('Hapus tiket dari keranjang?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-0" style="font-size:.8rem">
                                    <i class="ri-delete-bin-line me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-2">
                <a href="{{ route('user.home') }}" class="btn btn-outline-primary" style="border-radius:10px">
                    <i class="ri-arrow-left-line me-1"></i>Tambah Tiket Lain
                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius:16px;position:sticky;top:90px">
                <h5 class="fw-bold mb-4">📋 Ringkasan Pesanan</h5>

                @foreach($carts as $cart)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted" style="font-size:.825rem;max-width:60%">
                        {{ Str::limit($cart->product->nama_tiket, 25) }} × {{ $cart->jumlah }}
                    </span>
                    <span style="font-size:.825rem;font-weight:500">
                        Rp {{ number_format($cart->jumlah * $cart->product->harga, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Biaya layanan</span>
                    <span class="text-success fw-semibold">Gratis</span>
                </div>

                <div class="p-3 rounded-3 mb-4" style="background:linear-gradient(135deg,#E8F4FF,#F0F8FF)">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Pembayaran</span>
                        <span class="fw-bold" style="font-size:1.2rem;color:var(--sky-primary)">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-book mb-2">
                    <i class="ri-secure-payment-line me-2"></i>Lanjut Checkout
                </a>

                <div class="d-flex gap-3 justify-content-center mt-2">
                    <small class="text-muted"><i class="ri-shield-check-line me-1 text-success"></i>Aman</small>
                    <small class="text-muted"><i class="ri-lock-line me-1 text-info"></i>Terenkripsi</small>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="empty-state py-5">
        <div style="font-size:80px">🛒</div>
        <h4 class="fw-semibold text-muted mt-3">Keranjang Masih Kosong</h4>
        <p class="text-muted">Belum ada tiket yang ditambahkan ke keranjang</p>
        <a href="{{ route('user.home') }}" class="btn btn-primary mt-2" style="border-radius:10px">
            <i class="ri-plane-line me-2"></i>Cari Tiket Sekarang
        </a>
    </div>
    @endif
</div>
@endsection

@section('extra-js')
<script>
document.querySelectorAll('.qty-inc, .qty-dec').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('form');
        const input = form.querySelector('.qty-input');
        const max = parseInt(input.max);
        let val = parseInt(input.value);
        val = this.classList.contains('qty-inc') ? Math.min(max, val + 1) : Math.max(1, val - 1);
        input.value = val;
        form.submit();
    });
});
</script>
@endsection
