@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin /</span> Dashboard
        </h4>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="fw-medium d-block mb-1">Total Pelanggan</span>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ number_format($totalUsers) }}</h4>
                        </div>
                        <small class="mt-1 text-muted">Pengguna terdaftar</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ri-group-line ri-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="fw-medium d-block mb-1">Total Tiket</span>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ number_format($totalProducts) }}</h4>
                        </div>
                        <small class="mt-1 text-muted">Tiket tersedia</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ri-plane-fill ri-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="fw-medium d-block mb-1">Total Transaksi</span>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ number_format($totalOrders) }}</h4>
                        </div>
                        <small class="mt-1 text-muted">Semua pesanan</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ri-shopping-bag-3-line ri-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="fw-medium d-block mb-1">Total Pendapatan</span>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                        <small class="mt-1 text-muted">Total revenue</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ri-money-dollar-circle-line ri-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Stats -->
<div class="row g-4 mb-4">
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Transaksi Terbaru</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><span class="fw-medium">{{ $order->kode_pesanan }}</span></td>
                                <td>{{ $order->nama_pembeli }}</td>
                                <td>Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($order->status_pesanan) {
                                            'pending'    => 'bg-warning text-dark',
                                            'dibayar'    => 'bg-info',
                                            'selesai'    => 'bg-success',
                                            'dibatalkan' => 'bg-danger',
                                            default      => 'bg-secondary',
                                        };
                                        $statusLabel = match($order->status_pesanan) {
                                            'pending'    => 'Pending',
                                            'dibayar'    => 'Dibayar',
                                            'selesai'    => 'Selesai',
                                            'dibatalkan' => 'Dibatalkan',
                                            default      => ucfirst($order->status_pesanan),
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill">
                                        <i class="ri-eye-line ri-20px"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title m-0">Status Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark">Pending</span>
                    </div>
                    <span class="fw-semibold">{{ $orderStats['pending'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info">Dibayar</span>
                    </div>
                    <span class="fw-semibold">{{ $orderStats['dibayar'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success">Selesai</span>
                    </div>
                    <span class="fw-semibold">{{ $orderStats['selesai'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger">Dibatalkan</span>
                    </div>
                    <span class="fw-semibold">{{ $orderStats['dibatalkan'] }}</span>
                </div>

                @if($lowStockProducts->count() > 0)
                <hr>
                <h6 class="fw-semibold mb-3">⚠️ Stok Hampir Habis</h6>
                @foreach($lowStockProducts as $p)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <small class="text-truncate" style="max-width:180px">{{ $p->nama_tiket }}</small>
                    <span class="badge bg-danger">{{ $p->stok_kursi }} kursi</span>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection
