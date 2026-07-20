# ☕ Cafe Senja

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

**Cafe Senja** adalah sebuah aplikasi web Point of Sales (POS) dan manajemen pemesanan kafe yang modern, dibangun menggunakan framework Laravel. Aplikasi ini dirancang untuk memudahkan proses transaksi antara pelanggan dan admin, manajemen menu, kategori, hingga laporan penjualan yang interaktif.

## ✨ Fitur Utama

- **Pemesanan Pelanggan (Cart & Checkout)**: Sistem keranjang belanja yang interaktif bagi pelanggan.
- **Manajemen Menu & Kategori**: Admin dapat dengan mudah mengelola daftar menu, harga, gambar, dan kategori menu.
- **Dashboard Statistik (Admin)**: Visualisasi pendapatan dan data pesanan masuk.
- **Cetak Laporan Penjualan (PDF)**: Admin dapat mengunduh laporan transaksi.
- **Sistem Autentikasi & Role**: Hak akses berbeda untuk pengguna biasa (*user*) dan kasir/pengelola (*admin*).
- **Feedback & Saran**: Pelanggan dapat memberikan saran kepada Cafe Senja langsung dari Beranda.

## 🛠️ Prasyarat (Requirements)

Sebelum menjalankan aplikasi ini, pastikan sistem Anda telah memiliki:
- **PHP** (v8.1 atau lebih baru)
- **Composer** (Package manager PHP)
- **MySQL / MariaDB** (Database server lokal seperti XAMPP atau Laragon)
- **Git**

## 🚀 Cara Instalasi & Menjalankan Program

Ikuti langkah-langkah di bawah ini untuk menjalankan program Cafe Senja di perangkat lokal Anda:

### 1. Clone Repository
Unduh *source code* dari repositori ini:
```bash
git clone https://github.com/hafistafrizal/caffe-laravel.git
cd caffe-senja
```

### 2. Install Dependensi
Unduh seluruh library yang dibutuhkan oleh sistem Laravel:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi bawaan dari `.env.example` menjadi `.env`.
- **Windows (CMD)**: `copy .env.example .env`
- **Linux/Mac**: `cp .env.example .env`

Buka file `.env` tersebut. Atur nama database Anda (buat database kosong bernama `caffe_senja` di MySQL terlebih dahulu):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=caffe_senja
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
Buat kunci unik untuk keamanan *session* aplikasi:
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database
Otomatis buat struktur tabel di database Anda:
```bash
php artisan migrate
```

### 6. Hubungkan Storage (Gambar Menu)
Wajib dijalankan agar gambar menu yang di-*upload* dapat tampil di website:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
🎉 Selesai! Aplikasi sudah berjalan dan bisa diakses lewat browser di alamat: **http://127.0.0.1:8000** atau **http://localhost:8000**

---

## 🔑 Panduan Akun Uji Coba (Admin)

Secara bawaan (*default*), saat Anda mendaftar melalui web, role yang diberikan adalah **User**. Untuk mendapatkan akses Admin:
1. Registrasi akun baru lewat halaman web.
2. Buka aplikasi manajemen database Anda (seperti phpMyAdmin).
3. Buka tabel `users`, cari akun yang baru Anda buat, dan ubah nilai pada kolom `role` dari `user` menjadi `admin`.
4. Login kembali dan Anda akan diarahkan ke halaman Admin Dashboard!
