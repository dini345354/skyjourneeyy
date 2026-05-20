@extends('layouts.user.app')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Success Card -->
            <div class="card border-0 shadow-lg text-center p-5" style="border-radius:20px">
                <div style="width:90px;height:90px;background:linear-gradient(135deg,#28A745,#20C997);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 10px 30px rgba(40,167,69,.3)">
                    <i class="ri-check-line" style="font-size:44px;color:white"></i>
                </div>
                <h3 class="fw-bold mb-1" style="color:#1A1A2E">Pesanan Berhasil! 🎉</h3>
                <p class="text-muted mb-4">Terima kasih telah memesan tiket di SkyJourney. Pesanan Anda sedang diproses.</p>

                <!-- Kode Pesanan -->
                <div class="p-3 rounded-3 mb-4" style="background:#F8FAFC;border:2px dashed #B3D4FF">
                    <div class="text-muted mb-1" style="font-size:.8rem">Kode Pesanan</div>
                    <div class="fw-bold" style="font-size:1.3rem;color:var(--sky-primary);letter-spacing:2px">
                        {{ $order->kode_pesanan }}
                    </div>
                    <div class="mt-1">
                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                    </div>
                </div>

                <!-- Detail Tiket -->
                <div class="text-start mb-4">
                    <h6 class="fw-semibold mb-3">Detail Tiket yang Dipesan:</h6>
                    @foreach($order->orderItems as $item)
                    <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background:#F8FAFC">
                        <span style="font-size:24px">✈️</span>
                        <div class="flex-fill">
                            <div class="fw-medium" style="font-size:.875rem">{{ $item->product->nama_tiket }}</div>
                            <div class="text-muted" style="font-size:.78rem">
                                {{ $item->product->asal }} → {{ $item->product->tujuan }}
                                · {{ $item->jumlah }} tiket
                            </div>
                        </div>
                        <div class="fw-semibold" style="font-size:.875rem;color:var(--sky-primary)">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-between mt-3 pt-3 border-top fw-bold">
                        <span>Total Pembayaran</span>
                        <span style="color:var(--sky-primary)">Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Info -->
                <div class="alert alert-info text-start mb-4" style="border-radius:12px;font-size:.875rem">
                    <i class="ri-information-line me-1"></i>
                    Pesanan Anda sudah diterima. Admin akan segera memproses dan mengkonfirmasi pembayaran Anda.
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('orders.index') }}" class="btn btn-book">
                        <i class="ri-file-list-3-line me-2"></i>Lihat Semua Pesanan
                    </a>
                    <a href="{{ route('user.home') }}" class="btn btn-outline-primary" style="border-radius:10px">
                        <i class="ri-plane-line me-2"></i>Cari Tiket Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
