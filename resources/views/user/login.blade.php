@extends('user.component.layout')

@section('title', 'Đăng Nhập - Thư Viện Số')

@push('styles')
    @vite('resources/css/login.css')
@endpush

@push('scripts')
    @vite('resources/js/login.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Login Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #fff4ec 0%, #fefbf5 100%); min-height: 70vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <!-- Left Side: Image -->
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="login-image h-100 d-flex flex-column justify-content-center align-items-center text-white p-4" style="background: linear-gradient(135deg, #ff7043 0%, #ff8d4c 100%);">
                                    <img src="{{ asset('images/sample logo 1.png') }}" alt="Logo" class="mb-4" width="100">
                                    <h3 class="fw-bold mb-3 text-center">Chào mừng đến với Thư Viện Số</h3>
                                    <p class="text-center opacity-75 mb-4">Khám phá hàng ngàn cuốn sách hay từ mọi thể loại</p>
                                    <div class="text-center opacity-75">
                                        <p class="mb-2"><i class="bi bi-book me-2"></i>Sách điện tử chất lượng cao</p>
                                        <p class="mb-2"><i class="bi bi-download me-2"></i>Tải về mọi lúc mọi nơi</p>
                                        <p><i class="bi bi-star me-2"></i>Đánh giá & bình luận sách</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side: Form -->
                            <div class="col-lg-7">
                                <div class="card-body p-5">
                                    <!-- Tabs -->
                                    <ul class="nav nav-pills mb-4 justify-content-center" id="authTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button">
                                                <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="register-tab" data-bs-toggle="pill" data-bs-target="#register" type="button">
                                                <i class="bi bi-person-plus me-2"></i>Đăng ký
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="authTabsContent">
                                        <!-- Login Form -->
                                        <div class="tab-pane fade show active" id="login" role="tabpanel">
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            
                                            <form action="{{ route('login') }}" method="POST" class="login-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="{{ old('email') }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Mật khẩu</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                                                    </div>
                                                    <a href="{{ route('password.request') }}" class="text-orange text-decoration-none">Quên mật khẩu?</a>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                                                    <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                                                </button>
                                            </form>

                                            <div class="text-center my-4">
                                                <span class="text-muted">Hoặc đăng nhập với</span>
                                            </div>

                                            <div class="d-flex gap-3 mb-4">
                                                <button class="btn btn-outline-secondary flex-grow-1 py-2" disabled>
                                                    <i class="bi bi-google text-danger me-2"></i>Google
                                                </button>
                                                <button class="btn btn-outline-secondary flex-grow-1 py-2" disabled>
                                                    <i class="bi bi-facebook text-primary me-2"></i>Facebook
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Register Form -->
                                        <div class="tab-pane fade" id="register" role="tabpanel">
                                            <form action="{{ route('register') }}" method="POST" class="register-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Họ tên</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên của bạn" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="{{ old('email') }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Mật khẩu</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)" required minlength="8">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Xác nhận mật khẩu</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                                                    </div>
                                                </div>
                                                <div class="form-check mb-4">
                                                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                                                    <label class="form-check-label" for="agreeTerms">
                                                        Tôi đồng ý với <a href="#" class="text-orange">Điều khoản sử dụng</a> và <a href="#" class="text-orange">Chính sách bảo mật</a>
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                                                    <i class="bi bi-person-plus me-2"></i>Đăng ký
                                                </button>
                                            </form>

                                            <div class="text-center my-4">
                                                <span class="text-muted">Hoặc đăng ký với</span>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <button class="btn btn-outline-secondary flex-grow-1 py-2" disabled>
                                                    <i class="bi bi-google text-danger me-2"></i>Google
                                                </button>
                                                <button class="btn btn-outline-secondary flex-grow-1 py-2" disabled>
                                                    <i class="bi bi-facebook text-primary me-2"></i>Facebook
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection
