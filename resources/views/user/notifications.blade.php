@extends('user.component.layout')

@section('title', 'Thông Báo - Thư Viện Số')

@push('styles')
    @vite('resources/css/notifications.css')
@endpush

@push('scripts')
    @vite('resources/js/notifications.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thông báo</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Notifications Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0"><i class="bi bi-bell me-2 text-orange"></i>Thông Báo</h2>
                        <button class="btn btn-outline-danger btn-sm" onclick="markAllRead()">
                            <i class="bi bi-check-all me-1"></i> Đánh dấu tất cả đã đọc
                        </button>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="mb-4">
                        <button class="btn filter-btn active" onclick="filterNotifications('all', this)">
                            <i class="bi bi-list me-1"></i> Tất cả
                        </button>
                        <button class="btn filter-btn" onclick="filterNotifications('book', this)">
                            <i class="bi bi-book me-1"></i> Sách
                        </button>
                        <button class="btn filter-btn" onclick="filterNotifications('points', this)">
                            <i class="bi bi-coin me-1"></i> Điểm
                        </button>
                        <button class="btn filter-btn" onclick="filterNotifications('system', this)">
                            <i class="bi bi-gear me-1"></i> Hệ thống
                        </button>
                    </div>

                    <!-- Notifications List -->
                    <div id="notificationsList">
                        <!-- Notification 1: Unread -->
                        <div class="card notification-card mb-3 unread" data-type="book">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-success text-white me-3">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Sách của bạn đã được duyệt!</h6>
                                                <p class="text-muted small mb-1">
                                                    Sách <strong>"Lập trình Laravel"</strong> đã được duyệt and hiển thị công khai.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> 15 phút trước</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Xem sách</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 2: Unread -->
                        <div class="card notification-card mb-3 unread" data-type="points">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-warning text-dark me-3">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Nạp điểm thành công!</h6>
                                                <p class="text-muted small mb-1">
                                                    Bạn đã nạp thành công <strong class="text-success">+550 điểm</strong> qua VNPay.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> 2 giờ trước</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Chi tiết</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 3 -->
                        <div class="card notification-card mb-3" data-type="book">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-primary text-white me-3">
                                        <i class="bi bi-cart-plus"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Có sách mới trong giỏ hàng!</h6>
                                                <p class="text-muted small mb-1">
                                                    Sách <strong>"Machine Learning Cơ Bản"</strong> đang chờ bạn thanh toán.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> 5 giờ trước</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ url('/cart') }}"><i class="bi bi-cart me-2"></i>Xem giỏ hàng</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 4 -->
                        <div class="card notification-card mb-3" data-type="book">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-info text-white me-3">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Đánh giá của bạn đã được duyệt!</h6>
                                                <p class="text-muted small mb-1">
                                                    Cảm ơn bạn đã đánh giá <strong>"Mắt Biếc"</strong> 5 sao.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> Hôm qua</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Xem đánh giá</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 5 -->
                        <div class="card notification-card mb-3" data-type="system">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-secondary text-white me-3">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Nhận thưởng đăng nhập!</h6>
                                                <p class="text-muted small mb-1">
                                                    Chúc mừng bạn! Hôm nay bạn nhận được <strong class="text-success">+10 điểm</strong> thưởng đăng nhập.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> 2 ngày trước</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 6 -->
                        <div class="card notification-card mb-3" data-type="book">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-danger text-white me-3">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Sách bị từ chối duyệt</h6>
                                                <p class="text-muted small mb-1">
                                                    Sách <strong>"Python Cơ Bản"</strong> không đạt yêu cầu. Vui lòng chỉnh sửa and gửi lại.
                                                </p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i> 3 ngày trước</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Chỉnh sửa</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Trước</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- User Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" 
                                     alt="Avatar" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">Nguyễn Văn User</h5>
                                    <small class="text-muted">user@email.com</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around text-center">
                                <div>
                                    <h5 class="mb-0 text-orange">1,250</h5>
                                    <small class="text-muted">Điểm</small>
                                </div>
                                <div>
                                    <h5 class="mb-0">15</h5>
                                    <small class="text-muted">Sách đã mua</small>
                                </div>
                                <div>
                                    <h5 class="mb-0">8</h5>
                                    <small class="text-muted">Đánh giá</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0"><i class="bi bi-lightning me-2 text-orange"></i>Truy cập nhanh</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ url('/my-account') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-person me-3 text-orange"></i> Tài khoản của tôi
                                </a>
                                <a href="{{ url('/recharge') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-wallet2 me-3 text-orange"></i> Nạp điểm
                                </a>
                                <a href="{{ url('/history') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-clock-history me-3 text-orange"></i> Lịch sử tải
                                </a>
                                <a href="{{ url('/upload-book') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-cloud-upload me-3 text-orange"></i> Đăng sách mới
                                </a>
                                <a href="{{ url('/wishlist') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-heart me-3 text-orange"></i> Sách yêu thích
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0"><i class="bi bi-gear me-2 text-orange"></i>Cài đặt thông báo</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notifyBook" checked>
                                <label class="form-check-label" for="notifyBook">
                                    Thông báo sách mới
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notifyPoints" checked>
                                <label class="form-check-label" for="notifyPoints">
                                    Thông báo điểm
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notifySystem" checked>
                                <label class="form-check-label" for="notifySystem">
                                    Thông báo hệ thống
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notifyEmail">
                                <label class="form-check-label" for="notifyEmail">
                                    Nhận qua email
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('user.component.footer')
@endsection

