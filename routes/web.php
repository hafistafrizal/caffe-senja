<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes - Cafe Senja
|--------------------------------------------------------------------------
| Di sini adalah tempat mendaftarkan semua rute website Anda.
*/
// Arahkan URL admin dashboard ke Controller fungsi index
// ==========================================
// 1. HALAMAN UMUM 
// ==========================================
Route::get('/', function () {
    $menus = \App\Models\Menu::with('category')->latest()->take(6)->get();
    return view('user.beranda', compact('menus'));
});
use App\Http\Controllers\LaporanController;

// Route untuk unduh PDF Laporan (Ketentuan 6)
Route::get('/admin/laporan/unduh', [LaporanController::class, 'unduhPdf'])->name('laporan.unduh');

Route::get('/menu', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Menu::with('category');
    
    // Jika ada parameter kategori yang dipilih
    if ($request->filled('kategori')) {
        $query->where('category_id', $request->kategori);
    }
    
    $menus = $query->get();
    $categories = \App\Models\Category::all(); // Ambil semua kategori untuk filter
    
    return view('user.menu', compact('menus', 'categories'));
});

// Proses kirim saran dari form di beranda
Route::post('/kirim-saran', function (Illuminate\Http\Request $request) {
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email',
        'pesan' => 'required',
    ]);
    \App\Models\Saran::create($request->all());
    return back()->with('success', 'Saran Anda berhasil dikirim! Terima kasih.');
});


// ==========================================
// 2. AUTHENTICATION (Login & Register)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', function () { return view('auth.register'); });
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


// ==========================================
// 3. FITUR PELANGGAN (Harus Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Fitur Keranjang Belanja
    Route::get('/keranjang', [CartController::class, 'index']);
    Route::get('/add-to-cart/{id}', [CartController::class, 'add']);
    Route::post('/update-cart', [CartController::class, 'update']);
    Route::delete('/remove-from-cart', [CartController::class, 'remove']);
    Route::post('/checkout', [CartController::class, 'checkout']);

    // Daftar Pesanan Saya (History)
    Route::get('/orders', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->get();
        return view('user.orders', compact('orders'));
    });
});


// ==========================================
// 4. HALAMAN ADMIN (Role Admin)
// ==========================================
Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Dashboard & Statistik (Gunakan DashboardController)
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // CRUD Menu Kopi (Tambah, Edit, Hapus)
    Route::resource('menus', MenuController::class);
    
    // CRUD Kategori
    Route::resource('categories', CategoryController::class);
    
    // Kelola Pesanan Masuk
    Route::get('/orders', [AdminController::class, 'pesanan']);
    Route::post('/orders/konfirmasi/{id}', [AdminController::class, 'konfirmasi']);
    
    
});