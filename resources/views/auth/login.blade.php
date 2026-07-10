<!-- NAVBAR HALAMAN UTAMA -->
@extends('layouts.user')

@section('content')

<!-- HALAMAN LOGIN (Ketentuan 2) -->
<section class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding-top: 80px; padding-bottom: 40px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg" style="background-color: white; border-radius: 15px;">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-store fs-1 text-primary-custom mb-3"></i>
                            <h2 class="font-latin text-dark fs-1">Welcome Back</h2>
                            <p class="text-muted">Silakan login untuk melanjutkan</p>
                        </div>
                        
                        @if($errors->any())
                            <div class="alert alert-danger py-2 shadow-sm border-0">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ url('/login') }}" method="POST">
                            @csrf 
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control py-2 shadow-sm border-0 bg-light @error('email') is-invalid @enderror" placeholder="Masukkan email anda" required>
                            </div>
                            
                            <div class="mb-4 position-relative">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" id="loginPassword" class="form-control py-2 shadow-sm border-0 bg-light pe-5" placeholder="Masukkan password" required>
                                <button type="button" class="btn border-0 position-absolute end-0 bottom-0 mb-1 me-1 toggle-password" data-target="#loginPassword" style="background: transparent; z-index: 10;">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </button>
                            </div>
                            
                            <button type="submit" class="btn-custom w-100 mb-4 text-center d-block py-2 fs-5">Login Sekarang</button>
                            
                            <div class="text-center mt-3 pt-3 border-top">
                                <p class="text-muted mb-0">Belum punya akun? <a href="{{ url('/register') }}" class="text-primary-custom fw-bold text-decoration-none">Daftar di sini</a></p>
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
