# Cafe Senja

Aplikasi Manajemen Pemesanan dan Kasir (Point of Sales) untuk Cafe Senja, dibangun menggunakan framework Laravel. Fitur utama mencakup pemesanan pelanggan, manajemen menu, kategori, pengelolaan laporan PDF, dan dashboard statistik interaktif.

## Prasyarat (Requirements)

Sebelum menjalankan aplikasi ini, pastikan komputer Anda telah terinstal perangkat lunak berikut:
- **PHP** (Minimal versi 8.1 atau lebih baru disarankan)
- **Composer** (Untuk mengelola dependensi PHP)
- **MySQL / MariaDB** (Sebagai server database, contoh: XAMPP, Laragon, dll.)
- **Git** (Untuk melakukan clone repository)

## Cara Instalasi & Menjalankan Program

Ikuti langkah-langkah di bawah ini untuk menjalankan program Caffe-Senja di komputer Anda:

### 1. Clone Repository (Unduh Kode)
Buka Terminal atau Command Prompt (CMD), lalu jalankan perintah berikut untuk mengunduh kode aplikasi:
```bash
git clone <URL_REPOSITORY_ANDA>
```
Lalu masuk ke dalam direktori project:
```bash
cd caffe-senja
```

### 2. Install Dependensi (Composer)
Jalankan perintah ini untuk menginstal semua pustaka (libraries) Laravel yang dibutuhkan:
```bash
composer install
```

### 3. Konfigurasi File Environment (.env)
Salin file konfigurasi bawaan Laravel:
- **Windows (CMD/PowerShell)**: `copy .env.example .env`
- **Mac/Linux (Terminal)**: `cp .env.example .env`

Buka file `.env` yang baru saja dibuat menggunakan teks editor (misal: VS Code atau Notepad), lalu cari bagian konfigurasi database dan sesuaikan dengan nama database Anda (misalnya `caffe_senja`).
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=caffe_senja
DB_USERNAME=root
DB_PASSWORD=
```
*(Catatan: Buat database kosong terlebih dahulu di phpMyAdmin dengan nama `caffe_senja` sebelum lanjut ke langkah berikutnya).*

### 4. Generate Application Key
Jalankan perintah ini untuk mengamankan session dan data aplikasi:
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database
Untuk membuat struktur tabel di database Anda, jalankan:
```bash
php artisan migrate
```
*(Jika Anda memiliki seeder untuk data awal/admin, Anda juga bisa menjalankan `php artisan migrate --seed`)*.

### 6. Hubungkan Folder Storage (Untuk Upload Gambar)
Aplikasi ini memiliki fitur upload foto menu kopi. Agar gambar dapat diakses dan ditampilkan di website, Anda wajib menjalankan perintah berikut satu kali:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
Langkah terakhir, jalankan server pengembangan bawaan Laravel:
```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat:
**http://127.0.0.1:8000** atau **http://localhost:8000**

---

### Panduan Akun (Untuk Pengujian)
Jika Anda tidak memiliki seeder, Anda dapat:
1. Menekan tombol **Daftar / Register** di halaman website untuk membuat akun pelanggan baru.
2. Untuk mendapatkan akses **Admin**, ubah kolom `role` pada akun Anda di database (tabel `users`) menjadi `admin`, lalu login kembali.
