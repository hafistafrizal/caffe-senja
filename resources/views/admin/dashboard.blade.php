@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    
    <!-- KOTAK INFO -->
    <div class="row mb-4">
        <!-- Card 1: Total Pelanggan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="p-3 rounded" style="background-color: #eef2ff; color: #4e73df;">
                                <i class="fa fa-users fa-2x"></i>
                            </div>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 11px;">Total Pelanggan</div>
                            <!-- Panggil data asli dari database -->
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalPelanggan }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Menu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="p-3 rounded" style="background-color: #fff9e6; color: #f6c23e;">
                                <i class="fa fa-coffee fa-2x"></i>
                            </div>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 11px;">Total Menu</div>
                            <!-- Panggil data asli dari database -->
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalMenu }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Pesanan Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="p-3 rounded" style="background-color: #e8f5e9; color: #1cc88a;">
                                <i class="fa fa-receipt fa-2x"></i>
                            </div>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 11px;">Pesanan Selesai</div>
                            <!-- Panggil data asli dari database -->
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalPesanan }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Saran Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="p-3 rounded" style="background-color: #e0f7fa; color: #36b9cc;">
                                <i class="fa fa-envelope fa-2x"></i>
                            </div>
                        </div>
                        <div class="col ml-3">
                            <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 11px;">Saran Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalSaran }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK STATISTIK (Ketentuan 5) -->
    <div class="row">
        <!-- Grafik Pendapatan (Line Chart) -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: #2c3e50; font-size: 14px;">
                        <i class="fa fa-chart-bar" style="color: #f6c23e;"></i> Grafik Pendapatan
                    </h6>
                </div>
                
                <div class="card-body">
                    <div style="position: relative; height: 230px; width: 100%;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Rasio Status (Pie/Donut Chart) -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: #2c3e50; font-size: 14px;">
                        <i class="fa fa-chart-pie" style="color: #1cc88a;"></i> Rasio Status Pesanan
                    </h6>
                </div>
                
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="position: relative; height: 230px; width: 100%;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Jumlah Transaksi (Bar Chart) -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: #2c3e50; font-size: 14px;">
                        <i class="fa fa-chart-line" style="color: #36b9cc;"></i> Jumlah Transaksi
                    </h6>
                </div>
                
                <div class="card-body">
                    <div style="position: relative; height: 230px; width: 100%;">
                        <canvas id="trxChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PREVIEW PESANAN TERBARU -->
    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold" style="color: #2c3e50; font-size: 14px;">
                        <i class="fa fa-list-check pe-1" style="color: #1cc88a;"></i> Pesanan Terbaru
                    </h6>
                    <a href="{{ url('/admin/orders') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 2px 10px;">Lihat Semua</a>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0 align-middle">
                            <thead class="bg-light text-secondary" style="font-size: 13px;">
                                <tr>
                                    <th class="ps-4 py-3">No. Pesanan</th>
                                    <th class="py-3">Pelanggan</th>
                                    <th class="py-3">Total Harga</th>
                                    <th class="py-3">Status</th>
                                    <th class="pe-4 py-3 text-end">Waktu</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                                @forelse($recentOrders as $order)
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3 fw-bold text-dark">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-circle-user text-muted me-2 fs-5"></i>
                                                {{ $order->user->name ?? 'Anonim' }}
                                            </div>
                                        </td>
                                        <td class="py-3 fw-bold text-success">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td class="py-3">
                                            @if($order->status === 'selesai')
                                                <span class="badge bg-success" style="opacity: 0.9;">Selesai</span>
                                            @elseif($order->status === 'pending')
                                                <span class="badge bg-warning text-dark" style="opacity: 0.9;">Pending</span>
                                            @else
                                                <span class="badge bg-secondary" style="opacity: 0.9;">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted" style="font-size: 12px;">
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada pesanan masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Data Grafik Pendapatan
        const grafikBulan = {!! json_encode($months ?? []) !!};
        const grafikTotal = {!! json_encode($totals ?? []) !!};

        const ctxSales = document.getElementById('salesChart');
        if(ctxSales) {
            new Chart(ctxSales.getContext('2d'), {
                type: 'line', 
                data: {
                    labels: grafikBulan,
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: grafikTotal,
                        backgroundColor: 'rgba(246, 194, 62, 0.2)', // Warna kuning transparan untuk area bawah garis
                        borderColor: 'rgba(246, 194, 62, 1)', // Warna garis utamanya
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(246, 194, 62, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(246, 194, 62, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true, // Mengisi area bawah garis
                        tension: 0.4 // Membuat garis melengkung halus (tidak kaku)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: true, position: 'top' }
                    }
                }
            });
        }

        // 2. Data Grafik Rasio Status (Pie/Donut Chart)
        const statusData = {!! json_encode($statusData ?? ['pending' => 0, 'selesai' => 0]) !!};
        const ctxStatus = document.getElementById('statusChart');
        if(ctxStatus) {
            new Chart(ctxStatus.getContext('2d'), {
                type: 'doughnut', // Menggunakan donut chart agar terlihat modern
                data: {
                    labels: ['Pending', 'Selesai'],
                    datasets: [{
                        data: [statusData.pending, statusData.selesai],
                        backgroundColor: [
                            'rgba(246, 194, 62, 0.85)', // Kuning untuk pending
                            'rgba(28, 200, 138, 0.85)'  // Hijau untuk selesai
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'bottom' }
                    }
                }
            });
        }

        // 3. Data Grafik Jumlah Transaksi (Bar Chart)
        const trxTotal = {!! json_encode($jumlahTransaksi ?? []) !!};
        const ctxTrx = document.getElementById('trxChart');
        if(ctxTrx) {
            new Chart(ctxTrx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: grafikBulan,
                    datasets: [{
                        label: 'Jumlah Transaksi Masuk',
                        data: trxTotal,
                        backgroundColor: 'rgba(54, 185, 204, 0.85)', 
                        borderColor: 'rgba(38, 154, 171, 1)',
                        borderWidth: 1,
                        borderRadius: 4 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: true, position: 'top' }
                    }
                }
            });
        }
    });
</script>
@endsection