@extends('layouts.admin.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.orders.index') }}">Transaksi</a> /</span> Detail
        </h4>
    </div>
</div>

<div class="row g-4">
    <!-- Order Info -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">{{ $order->kode_pesanan }}</h5>
                @php
                    $s = $order->status_pesanan;
                    $cls = match($s) { 'pending'=>'bg-warning text-dark','dibayar'=>'bg-info','selesai'=>'bg-success','dibatalkan'=>'bg-danger',default=>'bg-secondary' };
                @endphp
                <span class="badge {{ $cls }} fs-6">{{ ucfirst($s) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Nama Pembeli</p>
                        <p class="fw-medium mb-0">{{ $order->nama_pembeli }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Email</p>
                        <p class="fw-medium mb-0">{{ $order->email }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">No. HP</p>
                        <p class="fw-medium mb-0">{{ $order->no_hp }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Tanggal Pesanan</p>
                        <p class="fw-medium mb-0">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-12">
                        <p class="mb-1 text-muted small">Alamat</p>
                        <p class="fw-medium mb-0">{{ $order->alamat }}</p>
                    </div>
                </div>

                <h6 class="fw-semibold mb-3">Detail Tiket Dipesan</h6>
                <div class="table-responsive">
                    <table class="table table-sm border rounded">
                        <thead class="table-light">
                            <tr>
                                <th>Tiket</th>
                                <th>Maskapai</th>
                                <th>Rute</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->nama_tiket }}</td>
                                <td>{{ $item->product->maskapai }}</td>
                                <td>{{ $item->product->asal }} → {{ $item->product->tujuan }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Total Pembayaran:</td>
                                <td class="fw-bold text-primary fs-5">Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="card-title m-0">Update Status Pesanan</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-medium">Status Pesanan</label>
                        <select name="status_pesanan" class="form-select">
                            <option value="pending" {{ $order->status_pesanan == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibayar" {{ $order->status_pesanan == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="selesai" {{ $order->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-refresh-line me-1"></i>Update Status
                    </button>
                </form>
                <hr>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="ri-arrow-left-line me-1"></i>Kembali
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="card-title m-0">Info Pelanggan</h5></div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            {{ strtoupper(substr($order->nama_pembeli, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="fw-semibold mb-0">{{ $order->nama_pembeli }}</p>
                        <small class="text-muted">{{ $order->email }}</small>
                    </div>
                </div>
                @if($order->user)
                <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="ri-user-line me-1"></i>Lihat Profil Pelanggan
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
