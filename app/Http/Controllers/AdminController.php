<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Saran;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard dan grafik statistik (Ketentuan 5).
     */
    public function dashboard()
    {
        // Mengambil total data dasar untuk kotak info
        $totalPelanggan = User::where('role', 'user')->count();
        $totalMenu  = Menu::count();
        $totalPesanan = Order::where('status', 'selesai')->count();
        $totalSaran = Saran::count();

        // Data Grafik Pendapatan & Jumlah Transaksi (6 Bulan Terakhir)
        // Mempersiapkan array kosong untuk diisi
        $months = [];
        $totals = [];
        $jumlahTransaksi = [];

        // Looping 6 bulan ke belakang
        for ($i = 5; $i >= 0; $i--) {
            // Ambil nama bulan (contoh: "Jul")
            $month = now()->subMonths($i)->translatedFormat('M');
            $months[] = $month;

            // Hitung total pendapatan untuk bulan tersebut (hanya yang sudah selesai)
            $pendapatan = Order::where('status', 'selesai')
                               ->whereMonth('created_at', now()->subMonths($i)->month)
                               ->whereYear('created_at', now()->subMonths($i)->year)
                               ->sum('total_harga');
            $totals[] = $pendapatan;

            // Hitung jumlah transaksi masuk untuk bulan tersebut
            $trx = Order::whereMonth('created_at', now()->subMonths($i)->month)
                        ->whereYear('created_at', now()->subMonths($i)->year)
                        ->count();
            $jumlahTransaksi[] = $trx;
        }

        // Data Grafik Rasio Status (Pending vs Selesai)
        $statusData = [
            'pending' => Order::where('status', 'pending')->count(),
            'selesai' => Order::where('status', 'selesai')->count()
        ];

        // Data Pesanan Terbaru (Preview di tabel)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Kirim semua data ke tampilan dashboard
        return view('admin.dashboard', [
            'totalPelanggan' => $totalPelanggan,
            'totalMenu' => $totalMenu,
            'totalPesanan' => $totalPesanan,
            'totalSaran' => $totalSaran,
            'months' => $months,
            'totals' => $totals,
            'statusData' => $statusData,
            'jumlahTransaksi' => $jumlahTransaksi,
            'recentOrders' => $recentOrders
        ]);
    }

    /**
     * Menampilkan daftar semua pesanan user.
     */
    public function pesanan()
    {
        // Mengambil pesanan data user
        $orders = Order::with('user')->latest()->get();
        return view('admin.pesanan', compact('orders'));
    }

    /**
     * Mengubah status pesanan menjadi 'selesai'.
     */
    public function konfirmasi($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'selesai']);

        return redirect()->back()->with('success', 'Pesanan #' . $id . ' telah dikonfirmasi selesai!');
    }
}
