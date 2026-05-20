@extends('layouts.admin.app')
@section('title', 'Detail Pelanggan')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.users.index') }}">Pelanggan</a> /</span> Detail
        </h4>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body p-4">
                <div class="avatar avatar-xl mx-auto mb-3" style="width:80px;height:80px">
                    <span class="avatar-initial rounded-circle bg-label-primary" style="width:100%;height:100%;font-size:32px">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge bg-label-success mb-3">Pelanggan</span>
                <div class="row g-2 text-start mt-2">
                    <div class="col-12">
                        <small class="text-muted">No. HP</small>
                        <p class="fw-medium mb-1">{{ $user->phone ?: '-' }}</p>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Alamat</small>
                        <p class="fw-medium mb-1">{{ $user->address ?: '-' }}</p>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Bergabung</small>
                        <p class="fw-medium mb-0">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title m-0">Riwayat Pesanan</h5></div>
            <div class="card-body">
                @forelse($user->orders as $order)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div>
                            <p class="fw-semibold mb-0">{{ $order->kode_pesanan }}</p>
                            <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                        </div>
                        @php $s = $order->status_pesanan; @endphp
                        <span class="badge {{ match($s) { 'pending'=>'bg-warning text-dark','dibayar'=>'bg-info','selesai'=>'bg-success',default=>'bg-danger' } }}">
                            {{ ucfirst($s) }}
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-2">
                            <thead><tr><th>Tiket</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->nama_tiket }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total: Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</strong>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ri-eye-line me-1"></i>Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="ri-shopping-bag-3-line ri-48px mb-3 d-block opacity-50"></i>
                    <p>Pelanggan ini belum memiliki pesanan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
