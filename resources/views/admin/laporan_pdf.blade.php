<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Cafe Senja (Ketentuan 6)</title>
    <style>
        body {
            font-family: 'Georgia', serif; /* Font klasik serif */
            color: #3e332a;
            background-color: #ffffff;
            font-size: 11px; /* Dikecilkan sedikit agar muat banyak kolom */
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #8b7355;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #8b7355;
            margin: 0;
            font-size: 26px;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-style: italic;
            color: #6d5d4b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #d3c4b1;
        }
        th, td {
            padding: 8px; /* Disesuaikan untuk memberi ruang */
            text-align: left;
            vertical-align: top; /* Teks di atas jika sel panjang */
        }
        th {
            background-color: #f4ecd8; /* Warna krem hangat */
            color: #5c4a3d;
            text-align: center;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-box {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #5c4a3d;
            background-color: #f4ecd8;
            padding: 12px;
            border: 1px dashed #8b7355;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 13px;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>CAFE SENJA</h1>
        <p>Laporan Riwayat Transaksi Penjualan</p>
        <p>Periode: {{ $namaBulan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">No. Order</th>
                <th width="15%">Nama Pelanggan</th>
                <th width="20%">Menu & Jumlah</th>
                <th width="15%">Keterangan (Note)</th>
                <th width="15%">Waktu Pembelian</th>
                <th width="10%">Waktu Konfirmasi</th>
                <th width="15%">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $key => $order)
            <tr>
                <td class="text-center" style="font-weight: bold; color: #2c3e50;">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="text-center">{{ $order->user->name ?? 'Pelanggan' }}</td>
                <td>{{ $order->rincian_pesanan }}</td>
                <td>{{ $order->catatan ?? '-' }}</td>
                <td class="text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-center">{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center"><i>Belum ada data penjualan yang selesai.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Kediri, {{ date('d F Y') }}</p>
        <p>Admin Cafe Senja,</p>
        <div class="ttd-name">Admin Cafe Senja</div>
    </div>

</body>
</html>