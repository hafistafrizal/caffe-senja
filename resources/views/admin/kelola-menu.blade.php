<!-- SIDE-BAR DASHBOARD ADMIN -->
@extends('layouts.admin')

@section('title', 'Kelola Menu Kopi')

@section('content')

<!-- NOTIFIKASI SUKSES -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-circle-check fs-4 me-2"></i>
            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Tampilan Error Validasi -->
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


<!-- TABEL DAFTAR MENU CAFFE (Ketentuan 3 & 4) -->
<div class="card border-0 shadow-sm d-flex flex-column" style="height: calc(100vh - 100px);">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">
            <i class="fa-solid fa-mug-hot me-2 text-warning"></i> Daftar Menu Kopi
        </h6>
        <button class="btn btn-primary btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fa-solid fa-plus me-1"></i> Tambah Menu
        </button>
    </div>

    <!-- TABEL DATA MENU -->
    <div class="card-body p-0" style="overflow-y: auto;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">No</th>
                        <th>Foto</th>
                        <th>Kategori</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($menus as $menu)
                    <tr>
                        <td class="px-4 text-muted">{{ $loop->iteration }}</td>
                        <td>
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                    <i class="fa-solid fa-image text-muted opacity-50"></i>
                                </div>
                            @endif
                        </td>
                        <td><span class="badge bg-info text-dark">{{ $menu->category->nama_kategori ?? '-' }}</span></td>
                        <td><strong>{{ $menu->nama_menu }}</strong></td>
                        <td class="text-success fw-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="text-muted small">{{ Str::limit($menu->deskripsi, 50) }}</td>
                        <td class="text-center px-4">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Edit --}}
                                <button class="btn btn-warning btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $menu->id }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ url('/admin/menus/'.$menu->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3" onclick="return confirm('Yakin ingin menghapus menu {{ $menu->nama_menu }}?')">
                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- MODAL EDIT MENU -->
                    <div class="modal fade" id="modalEdit{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-pen me-2"></i> Edit Menu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ url('/admin/menus/'.$menu->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-3 text-center">
                                            <p class="mb-2 fw-bold small text-muted">Foto Saat Ini:</p>
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" class="rounded shadow-sm mb-3 border" style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded mx-auto d-flex align-items-center justify-content-center border mb-3" style="width: 120px; height: 120px;">
                                                    <i class="fa-solid fa-image fs-1 text-muted opacity-25"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Ganti Foto (Opsional)</label>
                                            <div class="input-group input-group-sm">
                                                <input type="file" name="image" id="editImage{{ $menu->id }}" class="form-control shadow-none">
                                                <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('editImage{{ $menu->id }}').value=''">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Format: jpg, png, jpeg. Maks: 2MB</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-select shadow-none" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Nama Menu</label>
                                            <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Harga (Rp)</label>
                                            <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control shadow-none" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control shadow-none" rows="3" required>{{ $menu->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light btn-sm fw-bold px-3" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3 text-dark">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-mug-hot fs-1 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">Belum ada menu kopi tersedia.</p>
                            <small>Klik tombol <strong>Tambah Menu</strong> untuk memulai.</small>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- MODAL TAMBAH MENU BARU -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-plus me-2"></i> Tambah Menu Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/menus') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Foto Menu</label>
                        <div class="input-group input-group-sm">
                            <input type="file" name="image" id="addImage" class="form-control shadow-none" required>
                            <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('addImage').value=''">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <small class="text-muted">Format: jpg, png, jpeg. Maks: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select shadow-none" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control shadow-none" placeholder="Contoh: Espresso Macchiato" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control shadow-none" placeholder="Contoh: 28000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-none" rows="3" placeholder="Jelaskan aroma dan rasa kopinya..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light btn-sm fw-bold px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
