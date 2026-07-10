<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')

    <!--  MENU SECTION -->
    <section class="menu-section text-center" style="padding-top: 120px; padding-bottom: 80px; min-height: 80vh;">
        <div class="container">
            <h4 class="text-primary-custom mb-1">Our Special Menu</h4>
            <div class="d-flex align-items-center justify-content-center mb-3">
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
            </div>
            <h2 class="font-latin fs-1 mb-4">Explore All Coffees</h2>

            <!-- FILTER KATEGORI -->
            <div class="d-flex justify-content-end mb-5">
                <form action="{{ url('/menu') }}" method="GET" class="d-flex align-items-center gap-2">
                    <a href="{{ url('/menu') }}" class="{{ !request('kategori') ? 'btn-custom' : 'btn btn-outline-dark fw-bold text-dark' }} text-decoration-none d-flex align-items-center justify-content-center" style="height: 40px; {{ !request('kategori') ? '' : 'border: 2px solid var(--dark); border-radius: 5px;' }}">
                        Semua
                    </a>
                    
                    <select name="kategori" class="form-select shadow-none fw-bold" style="height: 40px; border-radius: 5px; border: 2px solid var(--dark); min-width: 200px; cursor: pointer; color: var(--dark); background-color: transparent;" onchange="this.form.submit()">
                        <option value="">-- Filter Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- CARD MENU -->
            <div class="row g-4 text-start">
                @forelse($menus as $menu)
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card menu-card shadow-sm w-100" style="border-radius: 15px; overflow: hidden; background-color: white;">
                            <!-- Bagian Gambar -->
                            <div style="position: relative;">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="w-100" style="height: 250px; object-fit: cover;">
                                @else
                                    <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=600" alt="Default Coffee" class="w-100" style="height: 250px; object-fit: cover;">
                                @endif
                                
                                <!-- Label Kategori -->
                                @if($menu->category)
                                    <span class="badge position-absolute" style="top: 15px; left: 15px; background-color: rgba(48, 16, 7, 0.85); color: white; padding: 6px 15px; border-radius: 20px; font-weight: 500; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.2);">
                                        {{ $menu->category->nama_kategori }}
                                    </span>
                                @endif
                            </div>

                            <!-- Bagian Konten -->
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h3 class="font-latin mb-0 text-dark-custom" style="font-size: 1.8rem; line-height: 1.2;">{{ $menu->nama_menu }}</h3>
                                    <span class="text-primary-custom fw-bold fs-5" style="white-space: nowrap;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                </div>
                                
                                <p class="text-muted small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.5;">
                                    {{ $menu->deskripsi }}
                                </p>
                                
                                <a href="{{ url('/add-to-cart/' . $menu->id) }}" class="btn-custom text-decoration-none text-center w-100 mt-auto d-flex align-items-center justify-content-center py-2" style="border-radius: 8px;">
                                    <i class="fa-solid fa-cart-plus me-2 fs-5"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada menu tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
