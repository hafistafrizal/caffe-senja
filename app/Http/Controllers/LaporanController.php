<?php

namespace App\Http\Controllers;

use App\Models\Order; // Pastikan ini sesuai dengan nama Model transaksimu
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Membuat dan mengunduh laporan PDF (Ketentuan 6).
     */
    public function unduhPdf(Request $request)
    {
        // Ambil input bulan & tahun dari dropdown, otomatis gunakan bulan/tahun saat ini jika kosong
        $bulan_pilihan = $request->bulan ?? date('m'); 
        $tahun_pilihan = $request->tahun ?? date('Y');

        // Cari data pesanan berstatus selesai di database berdasarkan bulan & tahun
        $orders = Order::with('user')
                    ->where('status', 'selesai')           // Hanya pesanan yang sudah sukses
                    ->whereMonth('created_at', $bulan_pilihan) // Saring bulannya
                    ->whereYear('created_at', $tahun_pilihan)  // Saring tahunnya
                    ->orderBy('updated_at', 'desc')        // Urutkan dari yang terbaru
                    ->get();

        // Hitung total pendapatan dari pesanan yang ditemukan
        // Menjumlahkan kolom 'total_harga' dari seluruh data pesanan yang didapat di atas
        $totalPendapatan = $orders->sum('total_harga');

        // Siapkan teks format judul PDF (Contoh: "Juli 2026")
        // Kita ubah angka bulan '07' jadi tulisan 'Juli' supaya rapi
        $daftarNamaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        // Gabungkan nama bulan dan tahun (misal: "Juli" spasi "2026")
        $teksPeriode = $daftarNamaBulan[$bulan_pilihan] . ' ' . $tahun_pilihan; 

        // Buat dan kembalikan file PDF dari view HTML
        // Kita kirimkan data ke file desain HTML (laporan_pdf.blade.php)
        $data_untuk_pdf = [
            'orders' => $orders,
            'totalPendapatan' => $totalPendapatan,
            'namaBulan' => $teksPeriode
        ];

        // Buat PDF-nya, atur posisi kertas landscape (mendatar) karena kolomnya banyak
        $pdf = Pdf::loadView('admin.laporan_pdf', $data_untuk_pdf)
                  ->setPaper('a4', 'landscape');

        // Langsung otomatis download dengan nama file yang rapi
        return $pdf->download('Laporan-Penjualan-' . $teksPeriode . '.pdf');
    }
}