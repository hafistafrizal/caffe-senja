<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menangani fungsi READ pada CRUD kategori (Ketentuan 3).
     */
    public function index()
    {
        // Ambil semua data kategori dari database
        // withCount('menus') digunakan untuk menghitung jumlah menu di setiap kategori (Relasi 1 to Many)
        $categories = Category::withCount('menus')->get();
        
        // Kirim data ke tampilan (View)
        return view('admin.kelola-kategori', [
            'categories' => $categories
        ]);
    }

    /**
     * Menangani fungsi CREATE pada CRUD kategori (Ketentuan 3).
     */
    public function store(Request $request)
    {
        // Pastikan input nama_kategori tidak kosong dan belum pernah ada (unique)
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
        ]);

        // Simpan kategori baru ke database
        Category::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Menangani fungsi UPDATE pada CRUD kategori (Ketentuan 3).
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $category->id,
        ]);

        // Perbarui nama kategori di database
        $category->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menangani fungsi DELETE pada CRUD kategori (Ketentuan 3).
     */
    public function destroy(Category $category)
    {
        // Cek relasi: Jangan hapus kategori jika masih ada menu yang menggunakannya
        if ($category->menus()->count() > 0) {
            return back()->withErrors(['Kategori tidak dapat dihapus karena masih digunakan pada menu.']);
        }
        
        // Hapus kategori dari database
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
