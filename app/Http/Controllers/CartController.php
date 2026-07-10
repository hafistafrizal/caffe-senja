<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan daftar item di keranjang.
     */
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        return view('user.keranjang', compact('keranjang'));
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function add($id)
    {
        $menu = Menu::findOrFail($id);
        $keranjang = session()->get('keranjang', []);

        // item ada tambah jumlah. Jika belum, tambahkan item baru.
        if (isset($keranjang[$id])) {
            $keranjang[$id]['quantity']++;
        } else {
            $keranjang[$id] = [
                "nama"     => $menu->nama_menu,
                "quantity" => 1,
                "harga"    => $menu->harga,
            ];
        }

        session()->put('keranjang', $keranjang);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $keranjang = session()->get('keranjang');
            if (isset($keranjang[$request->id])) {
                unset($keranjang[$request->id]);
                session()->put('keranjang', $keranjang);
            }
            return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang!');
        }
    }

    /**
     * Mengubah jumlah item di keranjang.
     */
    public function update(Request $request)
    {
        if ($request->id && $request->action) {
            $keranjang = session()->get('keranjang');
            if (isset($keranjang[$request->id])) {
                if ($request->action == 'increase') {
                    $keranjang[$request->id]['quantity']++;
                } elseif ($request->action == 'decrease') {
                    if ($keranjang[$request->id]['quantity'] > 1) {
                        $keranjang[$request->id]['quantity']--;
                    } else {
                        unset($keranjang[$request->id]);
                    }
                }
                session()->put('keranjang', $keranjang);
            }
            return redirect()->back();
        }
    }

    /**
     * Checkout dan menyimpan pesanan ke database.
     */
    public function checkout(Request $request)
    {
        $keranjang = session()->get('keranjang');

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Keranjang Anda masih kosong!');
        }

        // Hitung total harga dan rincian pesanan
        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['quantity']);
        $rincian = collect($keranjang)->map(fn($item) => "{$item['nama']} ({$item['quantity']})")->implode(', ');

        // Simpan ke tabel orders
        Order::create([
            'user_id'         => auth()->id(),
            'rincian_pesanan' => $rincian,
            'catatan'         => $request->catatan,
            'total_harga'     => $total,
            'status'          => 'pending'
        ]);

        session()->forget('keranjang');

        return redirect('/orders')->with('success', 'Pesanan Anda berhasil dikirim!');
    }
}
