@extends('layouts.user.app')
@section('title', 'Cari Tiket Pesawat')

@section('content')
<!-- HERO -->
<section class="sky-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1>✈️ Terbang ke Mana Saja,<br>Harga Terbaik!</h1>
                <p class="mt-3">Temukan dan pesan tiket pesawat domestik & internasional dengan mudah, cepat, dan terpercaya bersama SkyJourney.</p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <div class="d-flex align-items-center gap-2 text-white-50">
                        <i class="ri-shield-check-line" style="color:#66CCFF;font-size:20px"></i>
                        <span style="font-size:.875rem">100% Terpercaya</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-white-50">
                        <i class="ri-customer-service-2-line" style="color:#66CCFF;font-size:20px"></i>
                        <span style="font-size:.875rem">Layanan 24/7</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-white-50">
                        <i class="ri-price-tag-3-line" style="color:#66CCFF;font-size:20px"></i>
                        <span style="font-size:.875rem">Harga Terbaik</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Search Box -->
                <div class="search-bar">
                    <form action="{{ route('user.home') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="ri-search-line text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="Cari tiket, kota asal, tujuan, maskapai..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="sort" class="form-select">
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-search w-100">
                                    <i class="ri-search-line me-2"></i>Cari Tiket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RESULTS - Tambah ID disini -->
<div class="container py-5" id="semua-tiket">
    <!-- Category Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('user.home', array_merge(request()->except('category'), [])) }}"
            class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3">
            Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('user.home', array_merge(request()->except('category'), ['category' => $cat->id])) }}"
            class="btn btn-sm {{ request('category') == $cat->id ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3">
            {{ $cat->nama_kategori }}
        </a>
        @endforeach
    </div>

    <!-- Result Info -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">
                @if(request('search'))
                    Hasil untuk "{{ request('search') }}"
                @elseif(request('category'))
                    Tiket {{ $categories->where('id', request('category'))->first()?->nama_kategori }}
                @else
                    Semua Tiket Pesawat
                @endif
            </h2>
            <p class="section-sub mb-0">{{ $products->total() }} tiket tersedia</p>
        </div>
        @if(request('search') || request('category'))
        <a href="{{ route('user.home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="ri-close-line me-1"></i>Reset Filter
        </a>
        @endif
    </div>

    <!-- Ticket Grid -->
    @if($products->count())
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('user.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block;">
                <div class="ticket-card">
                    @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_tiket }}" class="ticket-card-img">
                    @else
                    <div class="ticket-card-img-placeholder">✈️</div>
                    @endif

                    <div class="ticket-card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge-category">{{ $product->category->nama_kategori }}</span>
                            <span class="ticket-stok"><i class="ri-seat-line me-1"></i>{{ $product->stok_kursi }} kursi</span>
                        </div>

                        <div class="ticket-route">
                            {{ $product->asal }}
                            <i class="ri-arrow-right-line"></i>
                            {{ $product->tujuan }}
                        </div>
                        <div class="ticket-airline">
                            <i class="ri-plane-fill me-1"></i>{{ $product->maskapai }}
                        </div>
                        <div class="ticket-date mb-3">
                            <i class="ri-calendar-event-line me-1"></i>
                            {{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->isoFormat('dddd, D MMMM Y') }}
                            · {{ \Carbon\Carbon::parse($product->tanggal_keberangkatan)->format('H:i') }} WIB
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <div>
                                <div class="ticket-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                <small class="text-muted" style="font-size:.75rem">per orang</small>
                            </div>
                            @if($product->stok_kursi < 10)
                            <span class="badge bg-warning text-dark" style="font-size:.72rem">Hampir habis!</span>
                            @endif
                        </div>

                        <div class="btn btn-book w-100">
                            <i class="ri-ticket-2-line me-1"></i>Lihat & Pesan
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $products->appends(request()->query())->links() }}
    </div>

    @else
    <div class="empty-state">
        <i class="ri-plane-line opacity-30"></i>
        <h5 class="fw-semibold text-muted">Tiket Tidak Ditemukan</h5>
        <p class="text-muted">Coba ubah kata kunci pencarian atau hapus filter Anda.</p>
        <a href="{{ route('user.home') }}" class="btn btn-primary mt-2">Lihat Semua Tiket</a>
    </div>
    @endif
</div>
@endsection