<!-- SIDE-BAR ADMIN -->

<!-- 
    KETENTUAN 4: Menggunakan sistem Blade Templating (Layouting)
    KETENTUAN 5: Navbar terpisah (Sidebar khusus Admin)
-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cafe Senja</title>

    <link href="https://fonts.googleapis.com/css2?family=Rancho&family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #f8a738; 
            --dark:    #301007;  
            --bg:      #f4f6f9;  
        }

        body, html {
            height: 100%;
            overflow: hidden; /* Mencegah scroll pada seluruh halaman */
        }

        body {
            font-family: 'Raleway', sans-serif;
            background-color: var(--bg);
        }
        .font-latin { font-family: 'Rancho', cursive; }

        /* SIDEBAR (Panel Kiri) */
        .sidebar {
            min-width: 230px;
            max-width: 230px;
            height: 100vh;
            overflow-y: auto; /* Agar sidebar bisa di-scroll terpisah jika penuh */
            background-color: var(--dark);
            color: white;
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar a.nav-link {
            color: rgba(255,255,255,0.7);
            padding: 13px 20px;
            border-radius: 0;
            transition: 0.25s;
        }

        .sidebar a.nav-link:hover,
        .sidebar a.nav-link.active {
            color: white;
            background-color: var(--primary);
        }
        .sidebar a.nav-link i { width: 22px; }

        /* TOPBAR (Header Atas) */
        .topbar {
            background: white;
            padding: 14px 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--dark);
            font-weight: 700;
        }
        .btn-primary:hover {
            background-color: var(--dark);
            border-color: var(--dark);
            color: white;
        }
    </style>
</head>
<body>

<div class="d-flex" style="height: 100vh;">
    <!-- SIDEBAR KIRI -->
    <div class="sidebar d-none d-md-flex flex-column shadow">

        <div class="sidebar-header text-center">
            <i class="fa-solid fa-store fs-2 mb-1" style="color: var(--primary);"></i>
            <h4 class="font-latin text-white mb-0">Cafe Senja</h4>
            <small style="color: var(--primary);">Admin Panel</small>
        </div>

        <!-- Menu Navigasi -->
        <nav class="nav flex-column mt-2 flex-grow-1">
            <a href="{{ url('/admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="{{ url('/admin/categories') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Kategori
            </a>
            <a href="{{ url('/admin/menus') }}" class="nav-link {{ request()->is('admin/menus*') ? 'active' : '' }}">
                <i class="fa-solid fa-mug-hot"></i> Menu Kopi
            </a>
            <a href="{{ url('/admin/orders') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Pesanan
            </a>
        </nav>

        <div class="border-top border-secondary border-opacity-25">
            <a href="{{ url('/') }}" target="_blank" class="nav-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website
            </a>
        </div>
    </div>

    <!-- AREA KONTEN ATAS -->
    <div class="flex-grow-1" style="height: 100vh; overflow-y: auto;">

        <!-- TOPBAR -->
        <header class="topbar d-flex justify-content-between align-items-center mb-4">
            <h5 class="font-latin mb-0">@yield('title', 'Dashboard')</h5>

            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold text-dark d-none d-sm-inline">
                    <i class="fa-solid fa-circle-user me-1" style="color: var(--primary);"></i>
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Konten Halaman (diisi oleh setiap halaman) -->
        <main class="container-fluid px-4 pb-5">
            @yield('content')
        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Menghilangkan notifikasi (alert) secara otomatis setelah 3 detik
    setTimeout(function() {
        var alertList = document.querySelectorAll('.alert');
        alertList.forEach(function(alertNode) {
            var alert = bootstrap.Alert.getOrCreateInstance(alertNode);
            alert.close();
        });
    }, 3000);
</script>
</body>
</html>
