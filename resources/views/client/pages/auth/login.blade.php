@extends('client.layouts.app')
@section('title', 'Đăng nhập')
@section('description', 'Đăng nhập vào tài khoản của bạn để truy cập các tính năng cá nhân hóa và quản lý đơn hàng tại cửa hàng đồ chơi của chúng tôi.')
@section('keywords', 'đăng nhập, xác thực người dùng, đăng nhập cửa hàng đồ chơi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/styles_auth.css') }}">
@endpush

@section('content')
    <div class="auth-container d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="auth-card p-4 p-md-5">
                        <h3 class="auth-title text-center mb-4">Đăng nhập</h3>
                        
                        <form action="{{ route('login.post') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label color-primary-3">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 position-relative">
                                <label for="password" class="form-label color-primary-3">Mật khẩu</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" required>
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fa fa-eye" id="toggleIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="auth-btn btn w-100">Đăng nhập</button>

                            <div class="text-center signup-text mt-3">
                                <span>Bạn chưa có tài khoản? </span>
                                <a href="{{ route('register') }}" class="auth-link color-primary-3">Đăng ký</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (togglePassword && passwordInput && toggleIcon) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                    } else {
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                });
            }
        });
    </script>
@endpush