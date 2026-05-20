@extends('layouts.admin.app')
@section('title', 'Pelanggan')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold py-3 mb-0"><span class="text-muted fw-light">Admin /</span> Data Pelanggan</h4>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title m-0 mb-3">Daftar Pelanggan</h5>
        <form class="row g-2" method="GET">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="ri-search-line me-1"></i>Cari</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Total Pesanan</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="fw-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?: '-' }}</td>
                        <td><span class="badge bg-label-info">{{ $user->orders_count }} pesanan</span></td>
                        <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-icon btn-text-info rounded-pill">
                                <i class="ri-eye-line ri-20px"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pelanggan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links() }}</div>
    </div>
</div>
@endsection
