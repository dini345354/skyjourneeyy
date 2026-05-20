@extends('layouts.admin.app')
@section('title', 'Kategori')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0"><span class="text-muted fw-light">Admin /</span> Kategori</h4>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0">Daftar Kategori</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Tiket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $i => $cat)
                    <tr>
                        <td>{{ $categories->firstItem() + $i }}</td>
                        <td><span class="fw-medium">{{ $cat->nama_kategori }}</span></td>
                        <td>{{ Str::limit($cat->deskripsi, 60, '...') ?: '-' }}</td>
                        <td><span class="badge bg-label-primary">{{ $cat->products_count }} tiket</span></td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-icon btn-text-warning rounded-pill" title="Edit">
                                <i class="ri-edit-line ri-20px"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-text-danger rounded-pill" title="Hapus">
                                    <i class="ri-delete-bin-line ri-20px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $categories->links() }}</div>
    </div>
</div>
@endsection
