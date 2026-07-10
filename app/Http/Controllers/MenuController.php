<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk menangani CRUD menu dan upload gambar (Ketentuan 3 & 4).
 */
class MenuController extends Controller
{
    /**
     * (READ) Menampilkan daftar semua menu.
     */
    public function index() 
    {
        // Mengambil semua menu beserta relasi kategorinya (Relasi Belongs To)
        $menus = Menu::with('category')->get();
        // Mengambil semua kategori untuk ditampilkan di dropdown saat tambah menu
        $categories = \App\Models\Category::all();
        
        return view('admin.kelola-menu', [
            'menus' => $menus,
            'categories' => $categories
        ]);
    }

    /**
     * (CREATE) Membuat menu baru ke database.
     */
    public function store(Request $request) 
    {
        // 1. Validasi data input form
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id', // Memastikan kategori ada (Relasi)
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi file gambar
        ]);

        // Proses upload dan simpan gambar baru (CREATE)
        // Jika ada file gambar yang diunggah, simpan ke folder 'public/menu-images'
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-images', 'public');
        }

        // Simpan data ke tabel menus
        Menu::create($data);

        return back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * (UPDATE) Edit data menu.
     */
    public function update(Request $request, Menu $menu) 
    {
        // Validasi data pembaruan
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Proses upload dan timpa gambar (UPDATE)
        // Jika user mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari penyimpanan server jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('menu-images', 'public');
        }

        // Perbarui data di database
        $menu->update($data);

        return back()->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * (DELETE) Menghapus menu dan file gambar.
     */
    public function destroy(Menu $menu) 
    {
        // Proses penghapusan gambar dari server (DELETE)
        // Hapus file gambar dari server sebelum menghapus data dari database
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        // Hapus data menu di database
        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus!');
    }
}