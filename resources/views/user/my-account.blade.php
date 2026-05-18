@extends('user.component.layout')

@section('title', 'Tài Khoản Của Tôi - Thư Viện Số')

@push('styles')
    @vite('resources/css/my-account.css')
@endpush

@push('scripts')
    @vite('resources/js/my-account.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Account Section -->
    <section class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="list-group account-nav">
                    <a href="#dashboard" class="list-group-item list-group-item-action active">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a href="#profile" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i>Hồ sơ
                    </a>
                    <a href="#purchases" class="list-group-item list-group-item-action">
                        <i class="bi bi-bag me-2"></i>Sách đã mua
                    </a>
                    <a href="#downloads" class="list-group-item list-group-item-action">
                        <i class="bi bi-download me-2"></i>Tải về
                    </a>
                    <a href="#favorites" class="list-group-item list-group-item-action">
                        <i class="bi bi-heart me-2"></i>Yêu thích
                    </a>
                    <a href="#mybooks" class="list-group-item list-group-item-action">
                        <i class="bi bi-book me-2"></i>Sách của tôi
                    </a>
                    <a href="{{ route('recharge') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wallet2 me-2"></i>Nạp điểm
                    </a>
                    <a href="{{ url('/notifications') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-bell me-2"></i>Thông báo
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action">
                        <i class="bi bi-shield-lock me-2"></i>Bảo mật
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Dashboard Tab -->
                <div class="tab-content" id="dashboardContent">
                    <div id="dashboard">
                        <h4 class="fw-bold mb-4"><i class="bi bi-speedometer2 me-2 text-orange"></i>Dashboard</h4>
                        
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-primary text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Tổng điểm</p>
                                            <h2 class="mb-0">{{ number_format($stats['total_points']) }}</h2>
                                        </div>
                                        <i class="bi bi-coin" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="{{ route('recharge') }}" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-plus-circle me-1"></i> Nạp thêm
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-success text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Sách đã mua</p>
                                            <h2 class="mb-0">{{ $stats['books_purchased'] }}</h2>
                                        </div>
                                        <i class="bi bi-bag" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="#purchases" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Xem ngay
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-warning text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Yêu thích</p>
                                            <h2 class="mb-0">{{ $stats['favorites_count'] }}</h2>
                                        </div>
                                        <i class="bi bi-heart" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="#favorites" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Xem ngay
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/80' }}" 
                                         alt="" class="rounded-circle me-4" width="80" height="80" style="object-fit: cover;">
                                    <div>
                                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                                        <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : (Auth::user()->role === 'author' ? 'info' : 'primary') }}">
                                            {{ ucfirst(Auth::user()->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row g-3 text-center">
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['books_purchased'] }}</h5>
                                        <small class="text-muted">Sách đã mua</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['reviews_count'] }}</h5>
                                        <small class="text-muted">Đánh giá</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['books_uploaded'] }}</h5>
                                        <small class="text-muted">Sách đã đăng</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Tab -->
                    <div id="profile" style="display: none;">
                        <h4 class="fw-bold mb-4"><i class="bi bi-person me-2 text-orange"></i>Hồ sơ</h4>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Địa chỉ</label>
                                            <textarea name="address" class="form-control" rows="2">{{ Auth::user()->address ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Giới thiệu bản thân</label>
                                            <textarea name="bio" class="form-control" rows="3" placeholder="Viết vài dòng về bạn...">{{ Auth::user()->bio ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 rounded-pill px-4">
                                        <i class="bi bi-check2 me-2"></i>Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab -->
                    <div id="security" style="display: none;">
                        <h4 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-orange"></i>Bảo mật</h4>
                        <form action="{{ route('password.change') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="mb-3">Đổi mật khẩu</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control" required minlength="8">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-key me-2"></i>Đổi mật khẩu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
// Tab switching
document.querySelectorAll('.account-nav a').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            document.querySelectorAll('.account-nav a').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content > div').forEach(tab => tab.style.display = 'none');
            document.querySelector(href).style.display = 'block';
        }
    });
});
</script>
@endpush
