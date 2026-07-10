<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')
<!-- HALAMAN KERANJANG -->
<section class="d-flex align-items-center" style="min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
    <div class="container">
        <!-- Header Halaman -->
        <div class="text-center mb-5">
            <h4 class="text-primary-custom mb-1">Your Order</h4>
            <div class="d-flex align-items-center justify-content-center mb-3">
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
            </div>
            <h2 class="font-latin fs-1">Keranjang Belanja</h2>
        </div>

        <div class="row g-4">
            <!-- Daftar Produk -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="font-latin text-dark border-bottom pb-3 mb-4">Daftar Item</h4>
                        
                        @php $total = 0; @endphp
                        @if($keranjang && count($keranjang) > 0)
                            @foreach($keranjang as $id => $details)
                                @php $total += $details['harga'] * $details['quantity'] @endphp
                                <div class="row align-items-center mb-4 pb-4 border-bottom">
                                    <div class="col-md-6 col-12">
                                        <h5 class="font-latin mb-1 fs-3 text-dark">{{ $details['nama'] }}</h5>
                                        @php
                                            $menuItem = \App\Models\Menu::find($id);
                                        @endphp
                                        @if($menuItem && $menuItem->deskripsi)
                                            <p class="text-muted small mb-1">{{ $menuItem->deskripsi }}</p>
                                        @endif
                                        <p class="text-muted mb-0 small">Harga Satuan: Rp {{ number_format($details['harga'], 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="col-md-3 col-6 mt-3 mt-md-0">
                                        <div class="d-flex align-items-center bg-light border rounded px-2 py-1" style="width: max-content;">
                                            <form action="{{ url('/update-cart') }}" method="POST" class="m-0 p-0 d-inline-block">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="btn text-dark border-0 px-3 fs-5 fw-bold" style="background: transparent;">-</button>
                                            </form>
                                            <span class="mx-3 fs-5 fw-bold">{{ $details['quantity'] }}</span>
                                            <form action="{{ url('/update-cart') }}" method="POST" class="m-0 p-0 d-inline-block">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="btn text-dark border-0 px-3 fs-5 fw-bold" style="background: transparent;">+</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mt-3 mt-md-0 text-md-end text-center">
                                        <h5 class="mb-0 fw-bold text-dark">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</h5>
                                    </div>
                                    
                                    <div class="col-md-1 col-2 mt-3 mt-md-0 text-end">
                                        <form action="{{ url('/remove-from-cart') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent">
                                                <i class="fa-solid fa-trash-can fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fa-solid fa-cart-shopping fs-1 text-muted opacity-25 mb-3"></i>
                                <p class="text-muted">Keranjang Anda masih kosong.</p>
                                <a href="{{ url('/menu') }}" class="btn-custom text-decoration-none d-inline-block mt-2">Lihat Menu</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan (Total & Catatan)-->
            <div class="col-md-4">
                <div class="card border-0 shadow-lg overflow-hidden" style="background-color: var(--dark); border-radius: 20px; color: white;">
                    <div class="card-body p-4">
                        <h4 class="font-latin text-primary-custom border-bottom border-secondary pb-3 mb-4">Ringkasan</h4>
                        
                        <div class="d-flex justify-content-between mb-3 opacity-75">
                            <span>Total Pesanan</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4 border-top border-secondary pt-3">
                            <h5 class="fw-bold text-primary-custom">Total Bayar</h5>
                            <h5 class="fw-bold text-primary-custom">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                        </div>
                        
                        @if($keranjang && count($keranjang) > 0)
                            <form action="{{ url('/checkout') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-primary-custom mb-2">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Catatan Pesanan (Opsional)
                                    </label>
                                    <textarea name="catatan" class="form-control bg-dark text-white border-secondary shadow-none" 
                                              style="font-size: 0.9rem; border-style: dashed;" rows="3" 
                                              placeholder="Contoh: Less sugar, es banyakin..."></textarea>
                                </div>
                                <button type="submit" class="btn-custom w-100 py-3 text-center d-flex align-items-center justify-content-center fs-5 border-0 shadow-none">
                                    Konfirmasi Pesanan <i class="fa-solid fa-circle-check ms-2"></i>
                                </button>
                            </form>
                        @else
                            <button class="btn-custom w-100 py-3 text-center d-block fs-5 border-0 opacity-50 shadow-none" disabled>
                                Keranjang Kosong
                            </button>
                        @endif
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ url('/menu') }}" class="text-dark-custom fw-bold text-decoration-none opacity-75 hover-opacity-100">
                        <i class="fa-solid fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; }
    textarea::placeholder { color: rgba(255,255,255,0.3) !important; }
</style>

@endsection
