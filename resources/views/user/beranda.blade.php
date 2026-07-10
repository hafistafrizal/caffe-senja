<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')

    <!-- HEADER SECTION -->
    <section id="home" class="hero-section container-fluid p-0">
        <div class="row g-0 align-items-center w-100">
            <div class="col-md-5">
                <div class="hero-img-box"></div>
            </div>
            <div class="col-md-6 offset-md-1 p-5 hero-text">
                <div class="d-flex align-items-center mb-2">
                    <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                    <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                    <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
                </div>
                @auth
                    <h2 class="mb-4 fw-bold" style="color: var(--dark);">
                        Selamat datang, {{ auth()->user()->name }}
                    </h2>
                @endauth
                <h1>If you love coffee,<br>you are at the best<br>place!</h1>
                <div class="mt-2 d-flex">
                    <a class="btn-custom text-decoration-none" href="#menu">Best Coffee</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 text-center position-relative">
                    <img src="https://images.unsplash.com/photo-1559525839-b184a4d698c7?w=600" class="about-img-arch" alt="About Coffee">
                </div>
                <div class="col-md-6 offset-md-1 mt-5 mt-md-0">
                    <h4 class="text-primary-custom mb-1">About Us</h4>
                    <div class="d-flex align-items-center mb-3">
                        <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                        <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                        <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
                    </div>
                    <h2 class="font-latin fs-1 mb-4">Apa yang membuat kopi kami spesial?</h2>
                    <p class="text-muted mb-5">Nikmati pengalaman minum kopi yang tak terlupakan dengan biji kopi pilihan terbaik yang diproses dengan dedikasi dan keahlian tinggi untuk menghasilkan cita rasa sempurna.</p>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 d-flex">
                            <i class="fa-solid fa-mug-hot about-icon"></i>
                            <div>
                                <h4 class="font-latin">Kualitas Tinggi</h4>
                                <p class="text-muted small">Kami hanya menggunakan biji kopi pilihan terbaik dari petani lokal maupun mancanegara.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 d-flex">
                            <i class="fa-solid fa-mug-saucer about-icon"></i>
                            <div>
                                <h4 class="font-latin">Teknik Seduh Ahli</h4>
                                <p class="text-muted small">Metode penyeduhan modern dan tradisional untuk aroma yang lebih kuat dan nikmat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  MENU CAFFE SECTION -->
    <section id="menu" class="menu-section text-center">
        <div class="container">
            <h4 class="text-primary-custom mb-1">Latest Menu</h4>
            <div class="d-flex align-items-center justify-content-center mb-3">
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
            </div>
            <h2 class="font-latin fs-1 mb-5">Menu Terbaru Kami</h2>

            <div id="menuCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner pb-5 px-md-5">
                    @forelse($menus->chunk(3) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row g-4 text-start">
                                @foreach($chunk as $menu)
                                    <div class="col-md-4 d-flex align-items-stretch">
                                        <div class="card menu-card shadow-sm w-100" style="border-radius: 15px; overflow: hidden; background-color: white;">
                                            <div style="position: relative;">
                                                @if($menu->image)
                                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="w-100" style="height: 250px; object-fit: cover;">
                                                @else
                                                    <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=600" alt="Default Coffee" class="w-100" style="height: 250px; object-fit: cover;">
                                                @endif

                                                @if($menu->category)
                                                    <span class="badge position-absolute" style="top: 15px; left: 15px; background-color: rgba(48, 16, 7, 0.85); color: white; padding: 6px 15px; border-radius: 20px; font-weight: 500; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.2);">
                                                        {{ $menu->category->nama_kategori }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="card-body p-4 d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                                    <h3 class="font-latin mb-0 text-dark-custom" style="font-size: 1.8rem; line-height: 1.2;">{{ $menu->nama_menu }}</h3>
                                                    <span class="text-primary-custom fw-bold fs-5" style="white-space: nowrap;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                                </div>
                                                
                                                <p class="text-muted small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.5;">
                                                    {{ $menu->deskripsi }}
                                                </p>
                                                
                                                <a href="{{ url('/add-to-cart/' . $menu->id) }}" class="btn-custom text-decoration-none text-center w-100 mt-auto d-flex align-items-center justify-content-center py-2" style="border-radius: 8px;">
                                                    <i class="fa-solid fa-cart-plus me-2 fs-5"></i> Add To Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p class="text-muted">Belum ada menu tersedia.</p>
                        </div>
                    @endforelse
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev" style="width: 5%; left: -20px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next" style="width: 5%; right: -20px;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="mt-4">
                <a href="{{ url('/menu') }}" class="btn-custom d-inline-block text-decoration-none px-4 py-2" style="font-size: 1.1rem;">
                    Lihat Semua Menu <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="text-center mb-5">
                <h4 class="text-primary-custom mb-1">Contact Info</h4>
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <hr style="width: 30px; border-top: 2px solid var(--dark);" class="me-2">
                    <i class="fa-solid fa-diamond text-dark" style="font-size: 0.5rem;"></i>
                    <hr style="width: 30px; border-top: 2px solid var(--dark);" class="ms-2">
                </div>
                <h2 class="font-latin fs-1">Connect With Us</h2>
            </div>
            
            <div class="row align-items-center">
                <div class="col-md-5 mb-4 mb-md-0">
                    <div class="contact-form-wrapper">
                        <div class="contact-form-bg">
                            <h2 class="font-latin text-primary-custom mb-4 text-center">Contact Form</h2>
                            
                            <!-- FORM SARAN -->
                            @if(session('success_saran'))
                                <div class="alert alert-success border-0 small py-2 mb-3">
                                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success_saran') }}
                                </div>
                            @endif

                            <form action="{{ url('/kirim-saran') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <input type="text" name="nama" class="form-control" placeholder="Your Name" required>
                                </div>
                                <div class="mb-4">
                                    <input type="email" name="email" class="form-control" placeholder="Email Id" required>
                                </div>
                                <div class="mb-4">
                                    <textarea name="pesan" class="form-control" rows="2" placeholder="Message" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn-custom w-50">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 offset-md-1">
                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon-box"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <p class="mb-0 fw-bold">+62 899-9999-9999</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon-box"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <p class="mb-0 fw-bold">cafesenja@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="contact-icon-box"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <p class="mb-0 fw-bold">Jln. Imam Bonjol No. 01 Kota kediri, Jawa Timur Indonesia</p>
                        </div>
                    </div>
                    
                    <div class="working-hours-box text-dark">
                        <h3 class="font-latin mb-3">Working Hours</h3>
                        <ul class="list-unstyled mb-0 fw-bold">
                            <li class="mb-2">Mon-Thus ............... 10.AM - 8.30 PM</li>
                            <li class="mb-2">Fri-Sat .................... 09.AM - 8.30 PM</li>
                            <li>Sunday ................... Closed</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection