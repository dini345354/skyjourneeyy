@extends('layouts.admin.app')
@section('title', 'Detail Tiket')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.products.index') }}">Tiket</a> /</span> Detail
        </h4>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center p-4">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_tiket }}"
                        class="img-fluid rounded mb-3" style="max-height:220px;object-fit:cover;width:100%">
                @else
                    <div class="avatar avatar-xl mx-auto mb-3" style="width:100px;height:100px">
                        <span class="avatar-initial rounded bg-label-info" style="width:100%;height:100%;font-size:40px">
                            <i class="ri-plane-fill"></i>
                        </span>
                    </div>
                @endif
                <h5 class="fw-semibold mb-1">{{ $product->nama_tiket }}</h5>
                <span class="badge bg-label-primary mb-3">{{ $product->category->nama_kategori }}</span>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                        <i class="ri-edit-line me-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus tiket ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line me-1"></i>Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><h5 class="card-title m-0">Informasi Tiket</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Maskapai</p>
                        <p class="fw-medium mb-0">{{ $product->maskapai }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Rute</p>
                        <p class="fw-medium mb-0">{{ $product->asal }} → {{ $product->tujuan }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Tanggal Keberangkatan</p>
                        <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Harga</p>
                        <p class="fw-semibold mb-0 text-primary fs-5">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Stok Kursi</p>
                        <p class="fw-medium mb-0">
                            <span class="badge {{ $product->stok_kursi < 10 ? 'bg-danger' : 'bg-success' }} fs-6">
                                {{ $product->stok_kursi }} kursi
                            </span>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-1 text-muted small">Ditambahkan</p>
                        <p class="fw-medium mb-0">{{ $product->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="col-12">
                        <p class="mb-1 text-muted small">Deskripsi</p>
                        <p class="mb-0">{{ $product->deskripsi ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="card-title m-0">Riwayat Pemesanan Tiket Ini</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Kode Pesanan</th><th>Pembeli</th><th>Jumlah</th><th>Subtotal</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($product->orderItems->take(10) as $item)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $item->order) }}">{{ $item->order->kode_pesanan }}</a></td>
                                <td>{{ $item->order->nama_pembeli }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td>
                                    @php $s = $item->order->status_pesanan; @endphp
                                    <span class="badge {{ match($s) { 'pending'=>'bg-warning text-dark','dibayar'=>'bg-info','selesai'=>'bg-success',default=>'bg-danger' } }}">
                                        {{ ucfirst($s) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-muted text-center">Belum ada pesanan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
