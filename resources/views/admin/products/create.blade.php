@extends('layouts.admin.app')
@section('title', 'Tambah Tiket')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.products.index') }}">Tiket</a> /</span> Tambah
        </h4>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5 class="card-title m-0">Form Tambah Tiket Pesawat</h5></div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nama Tiket <span class="text-danger">*</span></label>
                    <input type="text" name="nama_tiket" class="form-control @error('nama_tiket') is-invalid @enderror"
                        value="{{ old('nama_tiket') }}" placeholder="Contoh: Jakarta - Bali Economy" required>
                    @error('nama_tiket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Maskapai <span class="text-danger">*</span></label>
                    <input type="text" name="maskapai" class="form-control @error('maskapai') is-invalid @enderror"
                        value="{{ old('maskapai') }}" placeholder="Contoh: Garuda Indonesia" required>
                    @error('maskapai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Kota Asal <span class="text-danger">*</span></label>
                    <input type="text" name="asal" class="form-control @error('asal') is-invalid @enderror"
                        value="{{ old('asal') }}" placeholder="Contoh: Jakarta (CGK)" required>
                    @error('asal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Kota Tujuan <span class="text-danger">*</span></label>
                    <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
                        value="{{ old('tujuan') }}" placeholder="Contoh: Bali (DPS)" required>
                    @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Tanggal & Jam Keberangkatan <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tanggal_keberangkatan"
                        class="form-control @error('tanggal_keberangkatan') is-invalid @enderror"
                        value="{{ old('tanggal_keberangkatan') }}" required>
                    @error('tanggal_keberangkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Harga (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                            value="{{ old('harga') }}" min="0" placeholder="850000" required>
                    </div>
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Stok Kursi <span class="text-danger">*</span></label>
                    <input type="number" name="stok_kursi" class="form-control @error('stok_kursi') is-invalid @enderror"
                        value="{{ old('stok_kursi') }}" min="0" placeholder="50" required>
                    @error('stok_kursi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"
                        placeholder="Deskripsi tiket, termasuk fasilitas, bagasi, dll.">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Gambar Tiket</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror"
                        accept="image/*" onchange="previewImage(this)">
                    <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB.</div>
                    @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="imagePreview" src="#" alt="Preview" class="mt-2 rounded d-none" style="max-height:200px;object-fit:cover">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Simpan Tiket</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
