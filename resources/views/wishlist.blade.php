@extends('component.layout')

@section('title', 'Sách Yêu Thích - Thư Viện Số')

@section('content')
    @include('component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yêu thích</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Wishlist Section -->
    <section class="container py-5">
        <h2 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>Sách Yêu Thích</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <div class="col">
                <div class="book-card card border-0 shadow-sm p-2 h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400" class="card-img-top" alt="Mắt Biếc">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Mắt Biếc</h6>
                        <p class="text-muted small mb-1">Nguyễn Nhật Ánh</p>
                        <div class="text-warning small mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="text-muted">(245)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-orange fw-bold">500 điểm</span>
                            <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="book-card card border-0 shadow-sm p-2 h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400" class="card-img-top" alt="Atomic Habits">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Atomic Habits</h6>
                        <p class="text-muted small mb-1">James Clear</p>
                        <div class="text-warning small mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="text-muted">(512)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-orange fw-bold">550 điểm</span>
                            <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="book-card card border-0 shadow-sm p-2 h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=400" class="card-img-top" alt="Think Like a Monk">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Think Like a Monk</h6>
                        <p class="text-muted small mb-1">Jay Shetty</p>
                        <div class="text-warning small mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="text-muted">(189)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-orange fw-bold">499 điểm</span>
                            <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="book-card card border-0 shadow-sm p-2 h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400" class="card-img-top" alt="Cho Tôi Xin Một Vé">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Cho Tôi Xin Một Vé Đi Tuổi Thơ</h6>
                        <p class="text-muted small mb-1">Nguyễn Nhật Ánh</p>
                        <div class="text-warning small mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="text-muted">(356)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-orange fw-bold">450 điểm</span>
                            <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới and ưu đãi hấp dẫn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    <!-- Footer -->
    @include('component.footer')
@endsection

