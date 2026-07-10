<!-- NAVBAR USER  -->

<!-- 
    KETENTUAN 4: Menggunakan sistem Blade Templating (Layouting)
    KETENTUAN 5: Navbar terpisah (Layout khusus User/Pelanggan)
-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Senja - Great Coffee For Some Joy</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rancho&family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* GLOBAL CSS */
        :root {
            --primary: #f8a738;
            --dark: #301007;
            --bg-light: #f9f9f9;
        }
        body {
            font-family: 'Raleway', sans-serif;
            color: var(--dark);
            background-color: var(--bg-light);
            background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');
        }
        h1, h2, h3, h4, .font-latin { font-family: 'Rancho', cursive; }
        .text-primary-custom { color: var(--primary); }
        .text-dark-custom { color: var(--dark); }

        /* Style Tombol */
        .btn-custom {
            background-color: var(--primary); color: var(--dark); border: 2px solid var(--dark);
            font-weight: bold; padding: 8px 25px; border-radius: 5px;
            box-shadow: 3px 3px 0px var(--dark); transition: all 0.3s;
        }
        .btn-custom:hover { background-color: var(--dark); color: white; box-shadow: none; transform: translateY(3px); }
        
        .btn-custom-danger {
            background-color: #dc3545; color: white; border: 2px solid var(--dark);
            font-weight: bold; padding: 8px 25px; border-radius: 5px;
            box-shadow: 3px 3px 0px var(--dark); transition: all 0.3s;
        }
        .btn-custom-danger:hover { background-color: var(--dark); color: white; box-shadow: none; transform: translateY(3px); }

        /* NAVBAR CSS */
        .navbar { 
            background-color: rgba(180, 180, 180, 0.3);
            backdrop-filter: blur(10px);
            padding: 8px 0; 
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .navbar-brand { font-family: 'Rancho', cursive; font-size: 1.8rem; color: var(--dark) !important; }
        .nav-link { color: var(--dark) !important; font-weight: 500; margin: 0 10px; transition: color 0.3s; }
        .nav-link:hover { color: var(--primary) !important; }

        /* CSS UNTUK KONTEN */
        .hero-section { min-height: 80vh; display: flex; align-items: center; overflow: hidden; padding-top: 80px; }
        .hero-img-box { height: 600px; background-image: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=800'); background-size: cover; background-position: center; border-radius: 0 500px 500px 0; box-shadow: 10px 0 20px rgba(0,0,0,0.2); }
        .hero-text h1 { font-size: 4.5rem; line-height: 1.1; margin-bottom: 20px; color: var(--dark); }
        .about-section { padding: 80px 0; background-color: white; }
        .about-img-arch { width: 100%; height: 500px; object-fit: cover; border-radius: 250px 250px 0 0; border: 5px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .about-icon { color: var(--primary); font-size: 2rem; margin-right: 15px; }
        .menu-section { padding: 80px 0; }
        .menu-card { border: none; }
        .contact-section { padding: 80px 0; background-color: white; }
        .contact-form-wrapper { position: relative; padding: 15px; border: 2px dashed var(--primary); }
        .contact-form-bg { background-image: linear-gradient(rgba(48,16,7,0.7), rgba(48,16,7,0.7)), url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800'); background-size: cover; padding: 40px; border-radius: 5px; }
        .contact-form-bg input, .contact-form-bg textarea { background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.5); color: white; border-radius: 0; padding-left: 0; }
        .contact-form-bg input::placeholder, .contact-form-bg textarea::placeholder { color: #ddd; }
        .contact-form-bg input:focus, .contact-form-bg textarea:focus { background: transparent; color: white; box-shadow: none; border-bottom: 1px solid var(--primary); }
        .contact-icon-box { background-color: var(--primary); color: var(--dark); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size: 1.2rem; margin-right: 15px; border: 2px solid var(--dark); box-shadow: 2px 2px 0px var(--dark); }
        .working-hours-box { background-color: var(--primary); padding: 30px; border: 2px solid var(--dark); box-shadow: 10px 10px 0px var(--dark); margin-top: 30px; }
        .footer { background-color: var(--dark); background-image: url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1920&q=20'); background-size: cover; background-blend-mode: multiply; color: white; padding: 60px 0 20px; border-top: 5px solid var(--primary); }
        .footer h3, .footer h4 { color: var(--primary); }
        .footer a { color: #ccc; text-decoration: none; }
        .footer a:hover { color: var(--primary); }
        .newsletter-input { background-color: transparent; border: 1px solid var(--primary); color: white; }
    </style>
</head>
<body>
    
    <!-- NAVBAR SECTION -->
    <nav class="navbar navbar-expand-lg fixed-top w-100 z-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fa-solid fa-store fs-4 me-2"></i> Cafe Senja
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link text-primary-custom" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/menu') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/orders') }}">Pesanan Saya</a></li>
                </ul>

                <!-- Tombol Aksi (Keranjang, Admin Panel, Auth) -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Ikon Keranjang -->
                    <a href="{{ url('/keranjang') }}" class="text-dark fs-5 position-relative text-decoration-none me-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @php
                            $cartCount = session('keranjang') ? array_sum(array_column(session('keranjang'), 'quantity')) : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-white" style="font-size: 0.6rem;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Tombol Admin -->
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ url('/admin') }}" class="btn-custom py-1 px-3 text-decoration-none">
                            <i class="fa-solid fa-gauge-high me-1"></i> Admin Panel
                        </a>
                    @endif
                    
                    <!-- Tombol Login/Logout -->
                    @auth
                        <form action="{{ url('/logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="btn-custom-danger py-1 px-3">Logout</button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="btn-custom py-1 px-3 text-decoration-none">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- NOTIFIKASI GLOBAL -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fixed-top mt-5 mx-auto shadow-lg border-0 text-center py-3" 
             style="max-width: 500px; z-index: 9999; border-radius: 15px; background-color: white; border-left: 5px solid #198754 !important;" 
             role="alert">
            <i class="fa-solid fa-circle-check fs-4 me-2 text-success"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- MAIN SECTION (Tempat Setiap Halaman) -->
    @yield('content')

    <!-- FOOTER SECTION -->
    <footer class="footer">
        <div class="container">
            
            <div class="row g-4 justify-content-between">
                <div class="col-md-5">
                    <h3 class="font-latin text-white mb-3"><i class="fa-solid fa-store fs-4 me-2"></i> Cafe Senja</h3>
                    <p class="text-white small mb-4">Cafe Senja adalah tempat terbaik untuk menikmati secangkir kopi hangat dengan suasana yang tenang dan nyaman di jantung Kota Kediri. Kami hadir untuk memberikan kebahagiaan di setiap tegukan kopi Anda.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="contact-icon-box m-0" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-brands fa-facebook-f text-black"></i></a>
                        <a href="#" class="contact-icon-box m-0" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-brands fa-pinterest-p text-black"></i></a>
                        <a href="#" class="contact-icon-box m-0" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-brands fa-instagram text-black"></i></a>
                        <a href="#" class="contact-icon-box m-0" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-brands fa-twitter text-black"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="font-latin mb-3 text-white">Contact Info</h4>
                    <ul class="list-unstyled small text-white">
                        <li class="mb-3 d-flex align-items-center">
                            <div class="contact-icon-box m-0 me-3" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-solid fa-location-dot text-black"></i></div> 
                            <span>Jln. Imam Bonjol No. 01 Kota kediri Jawa Timur, Indonesia</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <div class="contact-icon-box m-0 me-3" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-solid fa-phone text-black"></i></div> 
                            <span>+62 899-9999-9999</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <div class="contact-icon-box m-0 me-3" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fa-solid fa-envelope text-black"></i></div> 
                            <span>cafesenja@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-4 mt-2">
                <p class="small mb-0">Copyright @ 2026 Cafe Senja All Right Reserved</p>
            </div>
        </div>
    </footer>

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