# Panduan & Pemenuhan Tugas Kelompok Aplikasi Web

**Tugas Utama:**
Kembangkan sebuah aplikasi web dengan topik yang ditentukan oleh masing-masing kelompok. Aplikasi harus memenuhi ketentuan berikut:
1. Memanfaatkan konsep MVC dan Migration.
2. Menyediakan fitur Login/Logout dengan minimal dua jenis peran pengguna.
3. Memiliki relasi data yang diimplementasikan melalui modul CRUD.
4. Mendukung upload gambar.
5. Menampilkan statistik dalam bentuk grafik.
6. Menghasilkan laporan PDF.

---

## Struktur Direktori & File Utama Aplikasi
Secara garis besar, susunan folder (direktori) dan file yang bekerja pada aplikasi ini digambarkan dalam bentuk struktur pohon berikut tanpa menggunakan simbol garis miring. Penjelasan di setiap file telah disesuaikan fungsinya berdasarkan 6 ketentuan tugas utama.

```text
Caffe-Senja
├── app
│   ├── Http
│   │   └── Controllers (Bagian Controller pada MVC)
│   │       ├── AdminController.php -> Menyiapkan data grafik statistik (Ket. 5).
│   │       ├── AuthController.php -> Menangani validasi login & hak akses (Ket. 2).
│   │       ├── CategoryController.php -> Menangani CRUD kategori (Ket. 3).
│   │       ├── LaporanController.php -> Membuat & mengunduh laporan PDF (Ket. 6).
│   │       └── MenuController.php -> Menangani CRUD menu & upload gambar (Ket. 3 & 4).
│   └── Models (Bagian Model pada MVC)
│       ├── Category.php -> Model tabel kategori (Ket. 3).
│       ├── Menu.php -> Model tabel menu & relasinya (Ket. 3).
│       ├── Order.php -> Model data pesanan untuk grafik & PDF (Ket. 5 & 6).
│       └── User.php -> Model data pengguna & autentikasi (Ket. 2).
├── database
│   └── migrations (Bagian Migration pada MVC)
│       ├── create_users_table.php -> Membuat tabel pengguna (Ket. 1 & 2).
│       ├── create_categories_table.php -> Membuat tabel kategori (Ket. 1 & 3).
│       └── create_menus_table.php -> Membuat tabel menu (Ket. 1 & 3).
├── resources
│   └── views (Bagian View pada MVC)
│       ├── admin
│       │   ├── dashboard.blade.php -> Menampilkan grafik statistik (Ket. 5).
│       │   ├── kelola-kategori.blade.php -> Halaman CRUD kategori (Ket. 3).
│       │   ├── kelola-menu.blade.php -> Halaman CRUD menu & gambar (Ket. 4).
│       │   ├── laporan_pdf.blade.php -> Template cetak laporan PDF (Ket. 6).
│       │   └── pesanan.blade.php -> Halaman filter & unduh PDF pesanan.
│       └── auth
│           ├── login.blade.php -> Halaman form login (Ket. 2).
│           └── register.blade.php -> Halaman form daftar akun baru.
├── routes
│   └── web.php -> Mengatur rute URL aplikasi.
└── storage
    └── app
        └── public
            └── menu-images -> Tempat simpan foto menu (Ket. 4).
```

---

## Penjelasan Alur (Flow) & Struktur File per Ketentuan

Berikut adalah rincian mendetail mengenai file apa saja yang bekerja, di mana lokasinya, dan bagaimana alur datanya berjalan dari awal hingga akhir untuk memenuhi setiap ketentuan tugas.

### ✅ 1. & 2. Fitur Login/Logout, Peran Pengguna, & MVC/Migration
Fitur autentikasi ini memisahkan hak akses antara **Admin** dan **User (Pelanggan)**.
* **Alur Kerja (Flow):**
  1. Pengguna membuka halaman Login/Register (View).
  2. Saat tombol *submit* ditekan, rute (`routes/web.php`) mengirim data ke `AuthController` (Controller).
  3. Controller memvalidasi data dan mencocokkannya dengan tabel `users` di database menggunakan `User.php` (Model).
  4. Jika berhasil, *session* dibuat. Jika role-nya `admin`, dialihkan ke halaman dashboard admin. Jika `user`, dialihkan ke beranda.
* **Struktur File yang Terlibat:**
```text
app
├── Http
│   └── Controllers
│       └── AuthController.php -> Mengatur fungsi login, register, dan cek role.
└── Models
    └── User.php -> Model penghubung tabel users.
database
└── migrations
    └── create_users_table.php -> Membuat tabel users beserta hak akses role.
resources
└── views
    └── auth
        ├── login.blade.php -> Tampilan form login.
        └── register.blade.php -> Tampilan form daftar.
```

### ✅ 3. Relasi Data & Modul CRUD (Manajemen Kategori & Menu)
Memenuhi syarat relasi *One-to-Many* (1 Kategori memiliki banyak Menu) dan operasi CRUD (Create, Read, Update, Delete).
* **Alur Kerja (Flow):**
  1. Admin mengelola (CRUD) kategori kopi via form di View Kategori. Controller Kategori menyimpan datanya ke Model Kategori.
  2. Saat Admin ingin menambah Menu, sistem menarik semua data kategori dari database agar bisa dipilih di *dropdown*.
  3. Menu disimpan dengan membawa `category_id` sebagai *Foreign Key*.
  4. Saat ditampilkan, tabel menu akan otomatis memanggil nama kategori berdasarkan relasi `category_id` tersebut.
* **Struktur File yang Terlibat:**
```text
app
├── Http
│   └── Controllers
│       ├── CategoryController.php -> Mengatur proses CRUD kategori.
│       └── MenuController.php -> Mengatur proses CRUD menu.
└── Models
    ├── Category.php -> Model relasi 1 Kategori ke banyak Menu (hasMany).
    └── Menu.php -> Model relasi Menu ke 1 Kategori (belongsTo).
database
└── migrations
    ├── create_categories_table.php -> Membuat tabel categories.
    └── create_menus_table.php -> Membuat tabel menus dengan relasi category_id.
resources
└── views
    └── admin
        ├── kelola-kategori.blade.php -> Tampilan form CRUD kategori.
        └── kelola-menu.blade.php -> Tampilan form CRUD menu.
```

### ✅ 4. Mendukung Upload Gambar (Foto Menu)
Sistem ini memungkinkan Admin untuk mengunggah foto saat menambahkan atau mengedit Menu.
* **Alur Kerja (Flow):**
  1. Admin memilih file gambar (jpg/png) melalui form di `kelola-menu.blade.php`.
  2. Form mengirim file dengan format `multipart/form-data` ke `MenuController`.
  3. Controller memvalidasi ukuran dan jenis file, lalu memindahkan file fisik tersebut ke folder lokal server (`storage/app/public/menu-images`).
  4. Controller menyimpan *nama path gambar* tersebut ke dalam database agar nanti bisa dipanggil oleh tag `<img>`.
* **Struktur File yang Terlibat:**
```text
app
└── Http
    └── Controllers
        └── MenuController.php -> Menyimpan fisik gambar saat upload & menghapus saat menu dihapus.
resources
└── views
    └── admin
        └── kelola-menu.blade.php -> Form dengan input file untuk upload gambar.
storage
└── app
    └── public
        └── menu-images -> Direktori fisik penyimpan gambar.
```

### ✅ 5. Menampilkan Statistik dalam Bentuk Grafik
Menggunakan library **Chart.js** untuk menampilkan performa penjualan Caffe.
* **Alur Kerja (Flow):**
  1. Saat Admin membuka halaman Dashboard, rute mengarah ke `AdminController@dashboard`.
  2. Controller tersebut menghitung jumlah transaksi dan total pendapatan per bulan menggunakan *Query Database*.
  3. Angka-angka hasil hitungan tersebut dilempar (dikirim) ke `dashboard.blade.php`.
  4. Di bagian bawah `dashboard.blade.php`, kode JavaScript (Chart.js) menangkap angka tersebut dan mengubahnya menjadi visual grafik yang menarik.
* **Struktur File yang Terlibat:**
```text
app
├── Http
│   └── Controllers
│       └── AdminController.php -> Menghitung pendapatan per bulan untuk data grafik.
└── Models
    └── Order.php -> Model untuk menghitung total pesanan selesai.
resources
└── views
    └── admin
        └── dashboard.blade.php -> Menampilkan visual grafik menggunakan Chart.js.
```

### ✅ 6. Menghasilkan Laporan PDF
Menggunakan library **DOMPDF** agar Admin bisa mencetak laporan rekapitulasi penjualan per bulan.
* **Alur Kerja (Flow):**
  1. Admin memilih filter 'Bulan' dan 'Tahun' pada halaman Pesanan, lalu menekan "Unduh Laporan".
  2. Permintaan GET ini dikirim ke `LaporanController@unduhPdf`.
  3. Controller memfilter database (hanya pesanan 'selesai' di bulan & tahun yang dipilih).
  4. Data yang tersaring dikirim ke `laporan_pdf.blade.php` (file *View* khusus cetak).
  5. Library DOMPDF menerjemahkan file *View* HTML tersebut menjadi file `.pdf` berekstensi *landscape* lalu otomatis terunduh di browser Admin.
* **Struktur File yang Terlibat:**
```text
app
└── Http
    └── Controllers
        └── LaporanController.php -> Memfilter data pesanan dan mencetak file PDF.
resources
└── views
    └── admin
        ├── laporan_pdf.blade.php -> Template bersih khusus cetak PDF.
        └── pesanan.blade.php -> Tampilan dengan filter tanggal dan tombol unduh.
routes
└── web.php -> Mengatur jalur rute pengunduhan laporan.
```