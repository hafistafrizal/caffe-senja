<!-- SIDE-BAR DASHBOARD ADMIN -->
@extends('layouts.admin')

@section('title', 'Daftar Pesanan Pelanggan')

@section('content')

<!-- NOTIFIKASI SUKSES -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- DAFTAR PESANAN MENU -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold" style="color: #2c3e50;">
            <i class="fa fa-list text-primary mr-2"></i> Daftar Pesanan Masuk
        </h6>
        <!-- Form Filter & Unduh PDF (Ketentuan 6) -->
        <form action="{{ route('laporan.unduh') }}" method="GET" class="d-flex align-items-center m-0">
            <label class="me-2 mb-0 small text-muted">Periode:</label>
            
            <!-- Dropdown Bulan -->
            <select name="bulan" class="form-select form-select-sm me-1" style="width: auto;">
                @php $bulanIni = date('m'); @endphp
                <option value="01" {{ $bulanIni == '01' ? 'selected' : '' }}>Januari</option>
                <option value="02" {{ $bulanIni == '02' ? 'selected' : '' }}>Februari</option>
                <option value="03" {{ $bulanIni == '03' ? 'selected' : '' }}>Maret</option>
                <option value="04" {{ $bulanIni == '04' ? 'selected' : '' }}>April</option>
                <option value="05" {{ $bulanIni == '05' ? 'selected' : '' }}>Mei</option>
                <option value="06" {{ $bulanIni == '06' ? 'selected' : '' }}>Juni</option>
                <option value="07" {{ $bulanIni == '07' ? 'selected' : '' }}>Juli</option>
                <option value="08" {{ $bulanIni == '08' ? 'selected' : '' }}>Agustus</option>
                <option value="09" {{ $bulanIni == '09' ? 'selected' : '' }}>September</option>
                <option value="10" {{ $bulanIni == '10' ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ $bulanIni == '11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ $bulanIni == '12' ? 'selected' : '' }}>Desember</option>
            </select>

            <!-- Dropdown Tahun -->
            <select name="tahun" class="form-select form-select-sm me-2" style="width: auto;">
                @php $tahunIni = date('Y'); @endphp
                <option value="{{ $tahunIni }}">{{ $tahunIni }}</option>
                <option value="{{ $tahunIni - 1 }}">{{ $tahunIni - 1 }}</option>
                <option value="{{ $tahunIni - 2 }}">{{ $tahunIni - 2 }}</option>
            </select>

            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                <i class="fa fa-file-pdf"></i> Unduh Laporan
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4" width="12%">No. Order</th>
                        <th width="15%">Pelanggan</th>
                        <th width="28%">Rincian Pesanan</th>
                        <th width="12%">Total Harga</th>
                        <th width="10%">Status</th>
                        <th width="13%">Tanggal</th>
                        <th class="text-center" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-4">
                            <span class="fw-bold text-primary">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <strong>{{ $order->user->name }}</strong><br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>
                            <span class="small">{{ $order->rincian_pesanan }}</span>
                            @if($order->catatan)
                                <div class="mt-1 small text-warning fw-bold">
                                    <i class="fa-solid fa-note-sticky me-1"></i> Note: {{ $order->catatan }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 rounded-pill">Pending</span>
                            @else
                                <span class="badge bg-success px-3 rounded-pill">Selesai</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center px-4">
                            @if($order->status == 'pending')
                                <form action="{{ url('/admin/orders/konfirmasi/' . $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                        Konfirmasi Selesai
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small"><i class="fa-solid fa-check-double me-1"></i> Terkonfirmasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-receipt fs-1 d-block mb-3 opacity-25"></i>
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
