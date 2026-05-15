@extends('component.layout')

@section('title', 'Giỏ Hàng - Thư Viện Số')

@push('scripts')
    @vite('resources/js/cart.js')
@endpush

@section('content')
    @include('component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Cart Section -->
    <section class="container py-5">
        <h2 class="fw-bold mb-4"><i class="bi bi-cart4 me-2 text-orange"></i>Giỏ Hàng Của Tôi</h2>
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Cart Item 1 -->
                <div class="card border-0 shadow-sm mb-3 p-3 d-flex flex-row align-items-center">
                    <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400" class="rounded me-3" width="80" alt="Lập trình Laravel">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Lập trình Laravel</h6>
                        <p class="text-muted small mb-1">Lê Hùng Sơn</p>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary">CNTT</span>
                            <span class="badge bg-secondary">Laravel</span>
                        </div>
                    </div>
                    <div class="text-end me-3">
                        <span class="text-orange fw-bold d-block">500 điểm</span>
                        <small class="text-muted text-decoration-line-through">600 điểm</small>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger mb-2"><i class="bi bi-trash"></i></button>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="card border-0 shadow-sm mb-3 p-3 d-flex flex-row align-items-center">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400" class="rounded me-3" width="80" alt="Machine Learning">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Machine Learning Cơ Bản</h6>
                        <p class="text-muted small mb-1">Vũ Đình Long</p>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success">Khoa học</span>
                            <span class="badge bg-warning text-dark">AI</span>
                        </div>
                    </div>
                    <div class="text-end me-3">
                        <span class="text-orange fw-bold d-block">750 điểm</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger mb-2"><i class="bi bi-trash"></i></button>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="card border-0 shadow-sm mb-3 p-3 d-flex flex-row align-items-center">
                    <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?w=400" class="rounded me-3" width="80" alt="Mắt Biếc">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Mắt Biếc</h6>
                        <p class="text-muted small mb-1">Nguyễn Nhật Ánh</p>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info text-dark">Văn học</span>
                        </div>
                    </div>
                    <div class="text-end me-3">
                        <span class="text-orange fw-bold d-block">500 điểm</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger mb-2"><i class="bi bi-trash"></i></button>
                    </div>
                </div>

                <div class="text-center py-4">
                    <a href="{{ url('/books') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-bag me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold mb-4"><i class="bi bi-receipt me-2 text-orange"></i>Tóm Tắt Đơn Hàng</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính (3 sách)</span>
                        <span>1,750 điểm</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Giảm giá</span>
                        <span class="text-success">-100 điểm</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Tổng cộng</span>
                        <span class="text-orange">1,650 điểm</span>
                    </div>
                    <div class="alert alert-light mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-wallet2 me-2"></i>Số dư của bạn</span>
                            <span class="fw-bold text-success">1,250 điểm</span>
                        </div>
                        <small class="text-muted">Bạn cần nạp thêm 400 điểm để thanh toán</small>
                    </div>
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                        <button class="btn btn-outline-primary" type="button">Áp dụng</button>
                    </div>
                    <button class="btn btn-primary w-100 py-3 rounded-pill mb-3" onclick="checkout()">
                        <i class="bi bi-credit-card me-2"></i>Thanh toán ngay
                    </button>
                    <a href="{{ url('/recharge') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                        <i class="bi bi-plus-circle me-2"></i>Nạp thêm điểm
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới và ưu đãi hấp dẫn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    @include('component.footer')
@endsection
