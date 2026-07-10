<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')
<!-- HALAMAN PESANAN SAYA -->
<section class="d-flex align-items-center" style="min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
    <div class="container">
        
        <div class="text-center mb-5">
            <h4 class="text-primary-custom mb-1">Status & History</h4>
            <div class="d-flex align-items-center justify-content-center mb-3">
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
            </div>
            <h2 class="font-latin fs-1">Pesanan Saya</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Navigasi Tabs -->
                <ul class="nav nav-pills mb-4 justify-content-center gap-3" id="orderTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-2 fw-bold" id="menunggu-tab" data-bs-toggle="pill" data-bs-target="#menunggu" type="button" role="tab">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i> Dalam Proses
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2 fw-bold" id="riwayat-tab" data-bs-toggle="pill" data-bs-target="#riwayat" type="button" role="tab">
                            <i class="fa-solid fa-clipboard-check me-2"></i> Riwayat Selesai
                        </button>
                    </li>
                </ul>

                <!-- Isi Konten Tabs -->
                <div class="tab-content mt-4" id="orderTabsContent">
                    
                    <!-- TAB 1: DALAM PROSES -->
                    <div class="tab-pane fade show active" id="menunggu" role="tabpanel">
                        @forelse($orders->whereIn('status', ['pending', 'diproses']) as $order)
                            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; border-left: 5px solid var(--primary) !important;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <span class="text-muted small fw-bold">Order ID: <span class="text-dark">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fa-solid fa-spinner fa-spin me-1"></i> {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="row align-items-end">
                                        <div class="col-md-8">
                                            <h4 class="font-latin mb-2 text-dark fs-3">{{ $order->rincian_pesanan }}</h4>
                                            
                                            @if($order->catatan)
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="bg-warning bg-opacity-10 text-black px-3 py-2 rounded small fw-bold w-100">
                                                        <i class="fa-solid fa-note-sticky me-2"></i> Catatan: {{ $order->catatan }}
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <p class="text-muted mb-0 small">
                                                <i class="fa-solid fa-calendar-alt me-1 text-primary-custom"></i> 
                                                Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <p class="text-muted mb-0 small">Total Pembayaran</p>
                                            <h3 class="fw-bold mb-0 text-primary-custom">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fa-solid fa-receipt fs-1 text-muted opacity-25 mb-3"></i>
                                <p class="text-muted">Tidak ada pesanan yang sedang diproses.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- TAB 2: RIWAYAT SELESAI -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        @forelse($orders->whereIn('status', ['selesai', 'dibatalkan']) as $order)
                            <div class="card border-0 shadow-sm mb-4 bg-light bg-opacity-50" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <span class="text-muted small fw-bold">Order ID: <span class="text-dark">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                                        <span class="badge {{ $order->status == 'selesai' ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fa-solid {{ $order->status == 'selesai' ? 'fa-check' : 'fa-times' }} me-1"></i> {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="row align-items-end">
                                        <div class="col-md-8">
                                            <h4 class="font-latin mb-2 text-dark fs-3">{{ $order->rincian_pesanan }}</h4>
                                            
                                            <p class="text-muted mb-0 small">
                                                <i class="fa-solid fa-calendar-check me-1"></i> 
                                                Selesai pada: {{ $order->updated_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <p class="text-muted mb-0 small">Total Pembayaran</p>
                                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <p>Belum ada riwayat pesanan.</p>
                            </div>
                        @endforelse
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .nav-pills .nav-link {
        color: var(--dark);
        background-color: white;
        border: 2px solid #eee;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: var(--primary) !important;
        color: var(--dark) !important;
        border-color: var(--dark);
        box-shadow: 4px 4px 0px var(--dark);
    }
</style>

@endsection
