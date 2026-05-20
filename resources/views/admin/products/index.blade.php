@extends('layouts.admin.app')
@section('title', 'Tiket Pesawat')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0"><span class="text-muted fw-light">Admin /</span> Tiket Pesawat</h4>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0">Daftar Tiket</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Tambah Tiket
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Tiket</th>
                        <th>Maskapai</th>
                        <th>Rute</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $i => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $i }}</td>
                        <td>
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="" width="50" height="40" style="object-fit:cover;border-radius:6px;">
                            @else
                                <div class="avatar" style="width:50px;height:40px">
                                    <span class="avatar-initial rounded bg-label-info" style="height:100%">
                                        <i class="ri-plane-fill"></i>
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-medium">{{ Str::limit($product->nama_tiket, 30) }}</span>
                        </td>
                        <td>{{ $product->maskapai }}</td>
                        <td>
                            <small>
                                <i class="ri-map-pin-2-line text-primary"></i> {{ $product->asal }}<br>
                                <i class="ri-map-pin-2-fill text-danger"></i> {{ $product->tujuan }}
                            </small>
                        </td>
                        <td><small>{{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->format('d M Y H:i') }}</small></td>
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $product->stok_kursi < 10 ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stok_kursi }}
                            </span>
                        </td>
                        
                        <!-- KATEGORI DENGAN WARNA JELAS -->
                        <td>
                            @php
                                $warnaKategori = [
                                    'Domestik' => 'primary',
                                    'Internasional' => 'success',
                                    'International' => 'success',
                                    'Promo' => 'warning',
                                    'Bisnis' => 'danger',
                                    'Business' => 'danger',
                                    'Economy' => 'secondary',
                                    'Ekonomi' => 'secondary',
                                ];
                                $warna = $warnaKategori[$product->category->nama_kategori] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $warna }} px-3 py-2" style="font-size: 0.75rem;">
                                <i class="ri-price-tag-3-line me-1"></i>
                                {{ $product->category->nama_kategori }}
                            </span>
                        </td>
                        
                        <td>
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-icon btn-text-info rounded-pill">
                                <i class="ri-eye-line ri-20px"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-icon btn-text-warning rounded-pill">
                                <i class="ri-edit-line ri-20px"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tiket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-text-danger rounded-pill">
                                    <i class="ri-delete-bin-line ri-20px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">Belum ada tiket</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $products->links() }}</div>
    </div>
</div>
@endsection