@extends('layouts.admin.app')
@section('title', 'Edit Tiket')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.products.index') }}">Tiket</a> /</span> Edit
        </h4>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5 class="card-title m-0">Edit Tiket: {{ $product->nama_tiket }}</h5></div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Nama Tiket <span class="text-danger">*</span></label>
                    <input type="text" name="nama_tiket" class="form-control @error('nama_tiket') is-invalid @enderror"
                        value="{{ old('nama_tiket', $product->nama_tiket) }}" required>
                    @error('nama_tiket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Maskapai <span class="text-danger">*</span></label>
                    <input type="text" name="maskapai" class="form-control"
                        value="{{ old('maskapai', $product->maskapai) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Kota Asal <span class="text-danger">*</span></label>
                    <input type="text" name="asal" class="form-control"
                        value="{{ old('asal', $product->asal) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Kota Tujuan <span class="text-danger">*</span></label>
                    <input type="text" name="tujuan" class="form-control"
                        value="{{ old('tujuan', $product->tujuan) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Tanggal & Jam Keberangkatan <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tanggal_keberangkatan" class="form-control"
                        value="{{ old('tanggal_keberangkatan', \Carbon\Carbon::parse($product->tanggal_keberangkatan)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Harga (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control"
                            value="{{ old('harga', $product->harga) }}" min="0" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Stok Kursi <span class="text-danger">*</span></label>
                    <input type="number" name="stok_kursi" class="form-control"
                        value="{{ old('stok_kursi', $product->stok_kursi) }}" min="0" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Gambar Tiket</label>
                    @if($product->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="Current" style="max-height:150px;border-radius:8px;">
                        <small class="d-block text-muted mt-1">Gambar saat ini. Upload baru untuk mengganti.</small>
                    </div>
                    @endif
                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <img id="imagePreview" src="#" alt="Preview" class="mt-2 rounded d-none" style="max-height:200px">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Perbarui</button>
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
