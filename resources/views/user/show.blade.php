@extends('layouts.user.app')
@section('title', $product->nama_tiket)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.home') }}" style="color:var(--sky-primary)">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.home') }}" style="color:var(--sky-primary)">Tiket Pesawat</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width:200px">{{ $product->nama_tiket }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- LEFT: Gambar & Info Utama -->
        <div class="col-lg-8">
            <!-- Hero Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;overflow:hidden">
                @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_tiket }}"
                    style="width:100%;height:320px;object-fit:cover">
                @else
                <div style="width:100%;height:280px;background:linear-gradient(135deg,#E8F4FF,#B3D4FF);display:flex;align-items:center;justify-content:center;font-size:80px">✈️</div>
                @endif
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge-category">{{ $product->category->nama_kategori }}</span>
                        <span class="badge {{ $product->stok_kursi < 10 ? 'bg-warning text-dark' : 'bg-success' }}">
                            {{ $product->stok_kursi < 10 ? '⚠️ Hampir Habis' : '✅ Tersedia' }}
                        </span>
                    </div>
                    <h2 class="fw-bold mb-1" style="color:#1A1A2E">{{ $product->nama_tiket }}</h2>
                    <p class="text-muted mb-0"><i class="ri-plane-fill me-1" style="color:var(--sky-primary)"></i>{{ $product->maskapai }}</p>
                </div>
            </div>

            <!-- Route Card -->
            <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius:16px">
                <h5 class="fw-semibold mb-3">🗺️ Informasi Penerbangan</h5>
                <div class="d-flex align-items-center justify-content-between py-3" style="background:#F8FAFC;border-radius:12px;padding:20px !important">
                    <div class="text-center">
                        <div class="fw-bold" style="font-size:1.5rem;color:#1A1A2E">{{ explode(' ', $product->asal)[0] }}</div>
                        <div class="text-muted" style="font-size:.8rem">{{ $product->asal }}</div>
                    </div>
                    <div class="text-center flex-fill px-3">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div style="height:2px;flex:1;background:linear-gradient(to right,var(--sky-primary),var(--sky-secondary))"></div>
                            <span style="font-size:1.5rem">✈️</span>
                            <div style="height:2px;flex:1;background:linear-gradient(to right,var(--sky-secondary),var(--sky-primary))"></div>
                        </div>
                        <div class="text-muted mt-1" style="font-size:.78rem">Langsung</div>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold" style="font-size:1.5rem;color:#1A1A2E">{{ explode(' ', $product->tujuan)[0] }}</div>
                        <div class="text-muted" style="font-size:.8rem">{{ $product->tujuan }}</div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#E8F4FF;border-radius:8px;display:flex;align-items:center;justify-content:center">
                                <i class="ri-calendar-event-line" style="color:var(--sky-primary)"></i>
                            </div>
                            <div>
                                <div style="font-size:.72rem;color:#9CA3AF">Tanggal</div>
                                <div class="fw-semibold" style="font-size:.85rem">{{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->isoFormat('D MMM Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#E8F4FF;border-radius:8px;display:flex;align-items:center;justify-content:center">
                                <i class="ri-time-line" style="color:var(--sky-primary)"></i>
                            </div>
                            <div>
                                <div style="font-size:.72rem;color:#9CA3AF">Jam</div>
                                <div class="fw-semibold" style="font-size:.85rem">{{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->format('H:i') }} WIB</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#E8F4FF;border-radius:8px;display:flex;align-items:center;justify-content:center">
                                <i class="ri-seat-line" style="color:var(--sky-primary)"></i>
                            </div>
                            <div>
                                <div style="font-size:.72rem;color:#9CA3AF">Sisa Kursi</div>
                                <div class="fw-semibold" style="font-size:.85rem">{{ $product->stok_kursi }} Kursi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            @if($product->deskripsi)
            <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius:16px">
                <h5 class="fw-semibold mb-3">📋 Deskripsi</h5>
                <p class="text-muted mb-0" style="line-height:1.8">{{ $product->deskripsi }}</p>
            </div>
            @endif
        </div>

        <!-- RIGHT: Order Box -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius:16px;top:90px">
                <div class="mb-3">
                    <div style="font-size:0.8rem;color:#9CA3AF">Harga per orang</div>
                    <div class="fw-bold" style="font-size:2rem;color:var(--sky-primary)">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                </div>

                <hr>

                @if($product->stok_kursi > 0)
                    @auth
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium" style="font-size:.875rem">Jumlah Tiket</label>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="changeQty(-1)" style="width:36px;height:36px;padding:0">
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <input type="number" name="jumlah" id="qty" class="form-control text-center"
                                    value="1" min="1" max="{{ $product->stok_kursi }}"
                                    style="width:70px;border-radius:10px">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="changeQty(1)" style="width:36px;height:36px;padding:0">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <small class="text-muted">Maks. {{ $product->stok_kursi }} kursi</small>
                        </div>

                        <div class="mb-3 p-3 rounded-3" style="background:#F8FAFC;border:1.5px solid #E4E7EC">
                            <div class="d-flex justify-content-between">
                                <span style="font-size:.875rem;color:#667085">Harga</span>
                                <span style="font-size:.875rem">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <span style="font-size:.875rem;color:#667085">Jumlah</span>
                                <span style="font-size:.875rem" id="qty-display">1</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Subtotal</span>
                                <span style="color:var(--sky-primary)" id="subtotal">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-book mb-2">
                            <i class="ri-shopping-cart-2-line me-2"></i>Tambah ke Keranjang
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary w-100" style="border-radius:8px;font-weight:600;font-size:.875rem">
                            <i class="ri-shopping-bag-3-line me-2"></i>Lihat Keranjang
                        </a>
                    </form>
                    @else
                    <div class="text-center">
                        <p class="text-muted mb-3" style="font-size:.875rem">Silakan login untuk memesan tiket ini</p>
                        <a href="{{ route('login') }}" class="btn btn-book mb-2">
                            <i class="ri-login-box-line me-2"></i>Login untuk Pesan
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100" style="border-radius:8px;font-size:.875rem">
                            Belum punya akun? Daftar
                        </a>
                    </div>
                    @endauth
                @else
                <div class="text-center py-3">
                    <i class="ri-close-circle-line" style="font-size:40px;color:#DC3545"></i>
                    <p class="fw-semibold text-danger mt-2 mb-0">Tiket Habis</p>
                    <small class="text-muted">Stok kursi sudah tidak tersedia</small>
                </div>
                @endif

                <div class="mt-3 d-flex gap-2 justify-content-center">
                    <small class="text-muted"><i class="ri-shield-check-line me-1 text-success"></i>Pembayaran Aman</small>
                    <small class="text-muted"><i class="ri-customer-service-2-line me-1 text-info"></i>24/7 Support</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Tickets -->
    @if($relatedProducts->count())
    <div class="mt-5">
        <h4 class="fw-bold mb-4">🎯 Tiket Serupa</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-md-6 col-lg-3">
                <div class="ticket-card">
                    @if($related->gambar)
                    <img src="{{ asset('storage/' . $related->gambar) }}" class="ticket-card-img" alt="">
                    @else
                    <div class="ticket-card-img-placeholder">✈️</div>
                    @endif
                    <div class="ticket-card-body">
                        <div class="ticket-route">{{ $related->asal }} <i class="ri-arrow-right-line"></i> {{ $related->tujuan }}</div>
                        <div class="ticket-airline"><i class="ri-plane-fill me-1"></i>{{ $related->maskapai }}</div>
                        <div class="ticket-price mb-2">Rp {{ number_format($related->harga, 0, ',', '.') }}</div>
                        <a href="{{ route('user.show', $related) }}" class="btn btn-book">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('extra-js')
<script>
const harga = {{ $product->harga }};
function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    val = Math.max(1, Math.min({{ $product->stok_kursi }}, val));
    input.value = val;
    updateDisplay(val);
}
document.getElementById('qty')?.addEventListener('input', function() {
    updateDisplay(parseInt(this.value) || 1);
});
function updateDisplay(qty) {
    document.getElementById('qty-display').textContent = qty;
    const subtotal = harga * qty;
    document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
}
</script>
@endsection
