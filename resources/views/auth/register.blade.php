<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')
<!-- HALAMAN REGISTER (Ketentuan 2) -->
<section class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg" style="background-color: white; border-radius: 15px;">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-mug-hot fs-1 text-primary-custom mb-3"></i>
                            <h2 class="font-latin text-dark fs-1">Buat Akun Baru</h2>
                            <p class="text-muted">Bergabunglah dan nikmati kopi terbaik kami!</p>
                        </div>
                        
                        <!-- Form Register -->
                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama</label>
                                <input type="text" name="name" class="form-control py-2 shadow-sm border-0 bg-light @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama anda" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email </label>
                                <input type="email" name="email" class="form-control py-2 shadow-sm border-0 bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email anda" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 position-relative">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" id="registerPassword" class="form-control py-2 shadow-sm border-0 bg-light pe-5 @error('password') is-invalid @enderror" placeholder="Buat password baru" required>
                                <button type="button" class="btn border-0 position-absolute end-0 bottom-0 mb-1 me-1 toggle-password" data-target="#registerPassword" style="background: transparent; z-index: 10;">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4 position-relative">
                                <label class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control py-2 shadow-sm border-0 bg-light pe-5" placeholder="Ulangi password anda" required>
                                <button type="button" class="btn border-0 position-absolute end-0 bottom-0 mb-1 me-1 toggle-password" data-target="#confirmPassword" style="background: transparent; z-index: 10;">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </button>
                            </div>
                            
                            <button type="submit" class="btn-custom w-100 mb-4 text-center d-block py-2 fs-5 border-0">Daftar Sekarang</button>
                            
                            <div class="text-center mt-3 pt-3 border-top">
                                <p class="text-muted mb-0">Sudah punya akun? <a href="{{ url('/login') }}" class="text-primary-custom fw-bold text-decoration-none">Login di sini</a></p>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script Show/Hide Password -->
<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var input = document.querySelector(targetId);
            var icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection
