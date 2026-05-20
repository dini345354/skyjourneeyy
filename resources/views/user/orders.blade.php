@extends('layouts.user.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">📋 Pesanan Saya</h2>
    <p class="text-muted mb-4">Riwayat semua transaksi Anda</p>

    @if($orders->count())
    @foreach($orders as $order)
    <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;overflow:hidden">
        <!-- Order Header -->
        <div class="card-header border-0 px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2"
            style="background:#F8FAFC">
            <div>
                <div class="fw-bold" style="color:#1A1A2E">{{ $order->kode_pesanan }}</div>
                <small class="text-muted">{{ $order->created_at->isoFormat('D MMMM Y, HH:mm') }}</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                @php
                    $s = $order->status_pesanan;
                    $cls = match($s) { 'pending'=>'bg-warning text-dark','dibayar'=>'bg-info','selesai'=>'bg-success','dibatalkan'=>'bg-danger',default=>'bg-secondary' };
                    $icon = match($s) { 'pending'=>'ri-time-line','dibayar'=>'ri-bank-card-line','selesai'=>'ri-check-double-line','dibatalkan'=>'ri-close-circle-line',default=>'ri-question-line' };
                    $label = match($s) { 'pending'=>'Menunggu Pembayaran','dibayar'=>'Sudah Dibayar','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan',default=>ucfirst($s) };
                @endphp
                <span class="badge {{ $cls }} px-3 py-2" style="font-size:.8rem">
                    <i class="{{ $icon }} me-1"></i>{{ $label }}
                </span>
            </div>
        </div>
        <!-- Order Items -->
        <div class="card-body p-4">
            @foreach($order->orderItems as $item)
            <div class="d-flex align-items-center gap-3 mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                @if($item->product->gambar)
                <img src="{{ asset('storage/' . $item->product->gambar) }}" alt=""
                    style="width:75px;height:58px;object-fit:cover;border-radius:10px;flex-shrink:0">
                @else
                <div style="width:75px;height:58px;background:linear-gradient(135deg,#E8F4FF,#B3D4FF);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0">✈️</div>
                @endif
                <div class="flex-fill">
                    <div class="fw-semibold" style="font-size:.9rem">{{ $item->product->nama_tiket }}</div>
                    <div class="text-muted" style="font-size:.78rem">
                        <i class="ri-plane-fill me-1" style="color:var(--sky-primary)"></i>{{ $item->product->maskapai }}
                        · {{ $item->product->asal }} → {{ $item->product->tujuan }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem">
                        <i class="ri-calendar-line me-1"></i>
                        {{ \Carbon\Carbon::parse($item->product->tanggal_keberangkatan)->isoFormat('D MMM Y, HH:mm') }} WIB
                    </div>
                </div>
                <div class="text-end">
                    <div class="text-muted" style="font-size:.78rem">{{ $item->jumlah }} tiket</div>
                    <div class="fw-semibold" style="color:var(--sky-primary);font-size:.9rem">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Order Footer -->
        <div class="card-footer border-0 px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2"
            style="background:#F8FAFC">
            <div>
                <span class="text-muted" style="font-size:.85rem">Total Pembayaran: </span>
                <span class="fw-bold" style="font-size:1.05rem;color:var(--sky-primary)">
                    Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}
                </span>
            </div>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm" style="border-radius:8px">
                <i class="ri-eye-line me-1"></i>Lihat Detail
            </a>
        </div>
    </div>
    @endforeach

    <div class="mt-2">{{ $orders->links() }}</div>
    @else
    <div class="empty-state py-5">
        <div style="font-size:80px">📋</div>
        <h4 class="fw-semibold text-muted mt-3">Belum Ada Pesanan</h4>
        <p class="text-muted">Anda belum pernah melakukan pemesanan tiket</p>
        <a href="{{ route('user.home') }}" class="btn btn-primary mt-2" style="border-radius:10px">
            <i class="ri-plane-line me-2"></i>Pesan Tiket Sekarang
        </a>
    </div>
    @endif
</div>
@endsection
