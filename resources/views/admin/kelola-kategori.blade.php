@extends('layouts.admin')

@section('title', 'Kelola Kategori Menu')

@section('content')

<!-- NOTIFIKASI -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-circle-check fs-4 me-2"></i>
            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- TABEL KATEGORI (Ketentuan 3) -->
<div class="card border-0 shadow-sm d-flex flex-column" style="height: calc(100vh - 100px);">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">
            <i class="fa-solid fa-tags me-2 text-warning"></i> Daftar Kategori
        </h6>
        <button class="btn btn-primary btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="card-body p-0" style="overflow-y: auto;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">No</th>
                        <th>Nama Kategori</th>
                        <th>Total Menu Terkait</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-4 text-muted">{{ $loop->iteration }}</td>
                        <td><strong>{{ $category->nama_kategori }}</strong></td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $category->menus_count ?? 0 }} Menu
                            </span>
                        </td>
                        <td class="text-center px-4">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-warning btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $category->id }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>

                                <form action="{{ url('/admin/categories/'.$category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3" onclick="return confirm('Yakin ingin menghapus kategori {{ $category->nama_kategori }}?')">
                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- MODAL EDIT KATEGORI -->
                    <div class="modal fade" id="modalEdit{{ $category->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-pen me-2"></i> Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ url('/admin/categories/'.$category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_kategori" class="form-control" value="{{ $category->nama_kategori }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-0">
                                        <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning fw-bold text-dark px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="mb-3"><i class="fa-solid fa-folder-open fa-3x opacity-50"></i></div>
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KATEGORI -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-plus-circle me-2"></i> Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/categories') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Kopi Panas" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold text-dark px-4">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
