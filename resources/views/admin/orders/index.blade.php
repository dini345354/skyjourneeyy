@extends('layouts.admin.app')
@section('title', 'Transaksi')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0"><span class="text-muted fw-light">Admin /</span> Transaksi</h4>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title m-0 mb-3">Daftar Transaksi</h5>
        <form class="row g-2" method="GET">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari kode pesanan / nama / email..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="ri-search-line me-1"></i>Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $i => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $i }}</td>
                        <td><span class="fw-medium">{{ $order->kode_pesanan }}</span></td>
                        <td>
                            {{ $order->nama_pembeli }}<br>
                            <small class="text-muted">{{ $order->email }}</small>
                        </td>
                        <td><strong>Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</strong></td>
                        <td>
                            @php
                                $s = $order->status_pesanan;
                                $cls = match($s) { 'pending'=>'bg-warning text-dark','dibayar'=>'bg-info','selesai'=>'bg-success','dibatalkan'=>'bg-danger',default=>'bg-secondary' };
                            @endphp
                            <span class="badge {{ $cls }}">{{ ucfirst($s) }}</span>
                        </td>
                        <td><small>{{ $order->created_at->format('d M Y H:i') }}</small></td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-text-info rounded-pill">
                                <i class="ri-eye-line ri-20px"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
