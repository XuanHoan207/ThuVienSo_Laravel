@extends('user.component.layout')

@section('title', 'Đăng Nhập - Thư Viện Số')

@push('styles')
    @vite('resources/css/login.css')
@endpush

@push('scripts')
    @vite('resources/js/login.js')
@endpush

@section('content')

    <!-- Modern Login & Register Section -->
    <section class="auth-section">
        <div class="container-fluid">
            <div class="row g-0">
                <!-- Left Side Image -->
                <div class="col-lg-6 d-none d-lg-block position-relative auth-image">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=1000" alt="Books"
                        class="img-fluid vh-100" style="object-fit: cover;">
                    <div class="overlay-text position-absolute top-50 start-50 translate-middle text-center text-white px-3">
                        <h2 class="fw-bold">Chào mừng đến với <span style="color:#ED553B;">Thư Viện Số</span></h2>
                        <p>Khám phá, đọc và tải hàng ngàn cuốn sách hay từ khắp nơi trên thế giới</p>
                        <a href="{{ url('/') }}" class="btn btn-light rounded-pill px-4 mt-3">
                            <i class="bi bi-house me-2"></i>Trang chủ
                        </a>
                    </div>
                </div>

                <!-- Right Side Form -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center"
                    style="background: linear-gradient(135deg, #fffaf9 0%, #fefbf5 100%);">
                    <div class="auth-form-wrapper w-100 p-5" style="max-width: 500px;">
                        <!-- Back to Home -->
                        <a href="{{ url('/') }}" class="text-decoration-none text-muted mb-4 d-inline-block">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại trang chủ
                        </a>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs justify-content-center mb-4 border-0" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold" id="login-tab" data-bs-toggle="tab"
                                    data-bs-target="#loginTab" type="button" role="tab">Đăng nhập</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="register-tab" data-bs-toggle="tab"
                                    data-bs-target="#registerTab" type="button" role="tab">Đăng ký</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="authTabsContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
                                <h4 class="fw-bold mb-4 text-center" style="color:#ED553B;">Đăng nhập tài khoản</h4>
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg"
                                            placeholder="Nhập email của bạn" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control form-control-lg"
                                            placeholder="Nhập mật khẩu" required>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe">Ghi nhớ đăng nhập</label>
                                        </div>
                                        <a href="#" class="text-decoration-none small text-orange">Quên mật khẩu?</a>
                                    </div>
                                    <button type="submit" class="btn w-100 py-2 text-white fw-semibold"
                                        style="background-color:#ED553B;">Đăng nhập</button>

                                    <div class="text-center mt-4">
                                        <p class="text-muted mb-3">Hoặc đăng nhập với</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="bi bi-google"></i> Google
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="bi bi-facebook"></i> Facebook
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="registerTab" role="tabpanel">
                                <h4 class="fw-bold mb-4 text-center" style="color:#ED553B;">Tạo tài khoản mới</h4>
                                <form id="registerForm">
                                    <div class="mb-3">
                                        <label class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="Họ và tên" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control form-control-lg" placeholder="Số điện thoại">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control form-control-lg" placeholder="Tạo mật khẩu" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xác nhận mật khẩu</label>
                                        <input type="password" class="form-control form-control-lg" placeholder="Nhập lại mật khẩu" required>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label small" for="agreeTerms">
                                            Tôi đồng ý với <a href="#" class="text-orange">Điều khoản sử dụng</a> và <a href="#" class="text-orange">Chính sách bảo mật</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn w-100 py-2 text-white fw-semibold"
                                        style="background-color:#ED553B;">Đăng ký</button>
                                </form>
                            </div>
                        </div>

                        <!-- Back to home -->
                        <div class="text-center mt-4">
                            <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                                <i class="bi bi-house me-1"></i> Quay lại trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
