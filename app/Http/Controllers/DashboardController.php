<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Menu; 
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil hitungan asli dari database
        $totalPelanggan = User::count(); 
        $totalMenu = Menu::count();      
        $totalPesanan = Order::where('status', 'selesai')->count(); 
        $totalSaran = 0; 

        // Hitung Pendapatan Grafik (Hanya status selesai)
        $dataPenjualan = Order::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(total_harga) as total') 
        )
        ->whereYear('created_at', date('Y'))
        ->where('status', 'selesai')
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->all();

        // Hitung Jumlah Transaksi (Semua status per bulan)
        $dataTransaksi = Order::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total_trx') 
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->pluck('total_trx', 'bulan')
        ->all();

        // Hitung Rasio Status Pesanan (Pending vs Selesai)
        $statusPesanan = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $statusData = [
            'pending' => $statusPesanan['pending'] ?? 0,
            'selesai' => $statusPesanan['selesai'] ?? 0,
        ];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        
        $totals = [];
        $jumlahTransaksi = [];
        for ($i = 1; $i <= 12; $i++) {
            $totals[] = $dataPenjualan[$i] ?? 0;
            $jumlahTransaksi[] = $dataTransaksi[$i] ?? 0;
        }

        // Pesanan Terbaru (Preview)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Variabel dikirim ke view
        return view('admin.dashboard', compact(
            'totalPelanggan', 'totalMenu', 'totalPesanan', 'totalSaran', 'months', 'totals', 'statusData', 'jumlahTransaksi', 'recentOrders'
        ));
    }
}