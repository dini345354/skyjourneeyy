@extends('layouts.user.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px">
            <i class="ri-arrow-left-line"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-0">Detail Pesanan</h2>
            <p class="text-muted mb-0">{{ $order->kode_pesanan }}</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Tiket -->
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px">
                <h5 class="fw-bold mb-4">✈️ Tiket yang Dipesan</h5>
                @foreach($order->orderItems as $item)
                <div class="d-flex align-items-center gap-3 mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                    @if($item->product->gambar)
                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt=""
                        style="width:90px;height:68px;object-fit:cover;border-radius:12px;flex-shrink:0">
                    @else
                    <div style="width:90px;height:68px;background:linear-gradient(135deg,#E8F4FF,#B3D4FF);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:32px;flex-shrink:0">✈️</div>
                    @endif
                    <div class="flex-fill">
                        <div class="fw-semibold">{{ $item->product->nama_tiket }}</div>
                        <div class="text-muted" style="font-size:.83rem">
                            <i class="ri-plane-fill me-1" style="color:var(--sky-primary)"></i>{{ $item->product->maskapai }}
                        </div>
                        <div class="text-muted" style="font-size:.83rem">
                            <i class="ri-map-pin-2-line me-1"></i>{{ $item->product->asal }} → {{ $item->product->tujuan }}
                        </div>
                        <div class="text-muted" style="font-size:.83rem">
                            <i class="ri-calendar-line me-1"></i>{{ \Carbon\Carbon::parse($item->product->tanggal_keberangkatan)->isoFormat('D MMMM Y, HH:mm') }} WIB
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted mb-1" style="font-size:.8rem">{{ $item->jumlah }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                        <div class="fw-bold" style="color:var(--sky-primary)">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-between pt-3 border-top mt-2 fw-bold" style="font-size:1.05rem">
                    <span>Total Pembayaran</span>
                    <span style="color:var(--sky-primary)">Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Data Pemesan -->
            <div class="card border-0 shadow-sm p-4" style="border-radius:16px">
                <h5 class="fw-bold mb-4">👤 Data Pemesan</h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted mb-1" style="font-size:.8rem">Nama</div>
                        <div class="fw-medium">{{ $order->nama_pembeli }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1" style="font-size:.8rem">Email</div>
                        <div class="fw-medium">{{ $order->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1" style="font-size:.8rem">No. HP</div>
                        <div class="fw-medium">{{ $order->no_hp }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1" style="font-size:.8rem">Tanggal Pesan</div>
                        <div class="fw-medium">{{ $order->created_at->isoFormat('D MMMM Y, HH:mm') }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted mb-1" style="font-size:.8rem">Alamat</div>
                        <div class="fw-medium">{{ $order->alamat }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius:16px">
                <h5 class="fw-bold mb-4">📊 Status Pesanan</h5>
                @php
                    $s = $order->status_pesanan;
                    $statuses = ['pending','dibayar','selesai'];
                    $currentIdx = array_search($s, $statuses);
                    if($s === 'dibatalkan') $currentIdx = -1;
                    $labels = ['Pesanan Dibuat','Pembayaran Dikonfirmasi','Selesai'];
                    $icons = ['ri-shopping-bag-3-line','ri-bank-card-line','ri-check-double-line'];
                @endphp

                @if($s === 'dibatalkan')
                <div class="text-center py-3">
                    <i class="ri-close-circle-line" style="font-size:48px;color:#DC3545"></i>
                    <p class="fw-semibold text-danger mt-2 mb-0">Pesanan Dibatalkan</p>
                </div>
                @else
                @foreach($statuses as $idx => $status)
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        background:{{ $idx <= $currentIdx ? 'linear-gradient(135deg,#0066CC,#0099FF)' : '#E4E7EC' }};
                        color:{{ $idx <= $currentIdx ? 'white' : '#9CA3AF' }}">
                        <i class="{{ $icons[$idx] }}"></i>
                    </div>
                    <div>
                        <div class="fw-medium {{ $idx <= $currentIdx ? '' : 'text-muted' }}" style="font-size:.875rem">
                            {{ $labels[$idx] }}
                        </div>
                        @if($idx == $currentIdx)
                        <small class="text-success fw-semibold">● Saat ini</small>
                        @elseif($idx < $currentIdx)
                        <small class="text-muted">Selesai</small>
                        @else
                        <small class="text-muted">Menunggu</small>
                        @endif
                    </div>
                </div>
                @if(!$loop->last)
                <div style="width:2px;height:20px;background:#E4E7EC;margin-left:17px;margin-bottom:4px"></div>
                @endif
                @endforeach
                @endif

                <hr>
                <div class="text-center">
                    @php $cls = match($s) { 'pending'=>'warning text-dark','dibayar'=>'info','selesai'=>'success','dibatalkan'=>'danger',default=>'secondary' }; @endphp
                    <span class="badge bg-{{ $cls }} px-3 py-2" style="font-size:.9rem">
                        {{ match($s) { 'pending'=>'Menunggu Pembayaran','dibayar'=>'Sudah Dibayar','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan',default=>ucfirst($s) } }}
                    </span>
                </div>

                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100" style="border-radius:10px">
                        <i class="ri-arrow-left-line me-1"></i>Kembali ke Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
