@extends('layouts.admin.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0">
            <span class="text-muted fw-light">Admin / <a href="{{ route('admin.categories.index') }}">Kategori</a> /</span> Edit
        </h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title m-0">Edit Kategori: {{ $category->nama_kategori }}</h5></div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="form-label fw-medium">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $category->nama_kategori) }}" required>
                        @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Perbarui</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
