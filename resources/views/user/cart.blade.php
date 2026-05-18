@extends('user.component.layout')

@section('title', 'Giỏ Hàng - Thư Viện Số')

@push('scripts')
    @vite('resources/js/cart.js')
@endpush

@section('content')
    @include('user.component.header')

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
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($cartItems) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                <div class="card border-0 shadow-sm mb-3 p-3 d-flex flex-row align-items-center">
                    <a href="{{ route('books.show', $item['book']->slug) }}">
                        @if($item['book']->thumbnail)
                            <img src="{{ asset('storage/' . $item['book']->thumbnail) }}" class="rounded me-3" width="80" alt="{{ $item['book']->title }}" style="height: 100px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/80x100?text=No" class="rounded me-3" width="80" alt="No Cover" style="height: 100px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">{{ $item['book']->title }}</h6>
                        <p class="text-muted small mb-1">
                            @foreach($item['book']->authors->take(2) as $author)
                                {{ $author->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        @if($item['book']->category)
                            <span class="badge bg-primary">{{ $item['book']->category->name }}</span>
                        @endif
                    </div>
                    <div class="text-end me-3">
                        <span class="text-orange fw-bold d-block">{{ number_format($item['book']->price_points) }} điểm</span>
                    </div>
                    <div>
                        <a href="{{ route('cart.remove', $item['book']->id) }}" class="btn btn-sm btn-outline-danger mb-2">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
                @endforeach

                <div class="text-center py-4">
                    <a href="{{ route('books.index') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-bag me-2"></i>Tiếp tục mua sắm
                    </a>
                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger rounded-pill ms-2">
                        <i class="bi bi-trash me-2"></i>Xóa giỏ hàng
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold mb-4"><i class="bi bi-receipt me-2 text-orange"></i>Tóm Tắt Đơn Hàng</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính ({{ count($cartItems) }} sách)</span>
                        <span>{{ number_format($subtotal) }} điểm</span>
                    </div>
                    @if($discount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Giảm giá</span>
                        <span class="text-success">-{{ number_format($discount) }} điểm</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Tổng cộng</span>
                        <span class="text-orange">{{ number_format($total) }} điểm</span>
                    </div>
                    
                    @auth
                    <div class="alert {{ $userPoints >= $total ? 'alert-success' : 'alert-warning' }} mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-wallet2 me-2"></i>Số dư của bạn</span>
                            <span class="fw-bold">{{ number_format($userPoints) }} điểm</span>
                        </div>
                        @if($userPoints < $total)
                            <small class="text-muted">Bạn cần nạp thêm {{ number_format($total - $userPoints) }} điểm để thanh toán</small>
                        @endif
                    </div>
                    
                    @if($userPoints >= $total)
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill">
                                <i class="bi bi-credit-card me-2"></i>Thanh toán ngay
                            </button>
                        </form>
                    @else
                        <a href="{{ route('recharge') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                            <i class="bi bi-plus-circle me-2"></i>Nạp thêm điểm
                        </a>
                    @endif
                    @else
                    <div class="alert alert-info mb-4">
                        <a href="{{ route('login') }}">Đăng nhập</a> để thanh toán.
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-cart text-muted" style="font-size: 5rem;"></i>
            <h3 class="text-muted mt-3">Giỏ hàng trống</h3>
            <p class="text-muted">Hãy thêm sách vào giỏ hàng để mua sắm.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-bag me-2"></i>Khám phá sách ngay
            </a>
        </div>
        @endif
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

    @include('user.component.footer')
@endsection
