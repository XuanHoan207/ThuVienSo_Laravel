@extends('component.layout')

@section('title', 'Giới Thiệu - Thư Viện Số')

@section('content')
    @include('component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="about-section py-5" style="background-color: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image-wrapper position-relative">
                        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800"
                            alt="Thư Viện Số" class="img-fluid rounded-4 shadow-lg w-100">
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h6 class="text-uppercase text-orange fw-semibold mb-2">Về Chúng Tôi</h6>
                    <h2 class="fw-bold mb-4">Thư Viện Số - Nền Tảng Đọc Sách Trực Tuyến Hàng Đầu</h2>
                    <p class="text-muted mb-4">
                        <strong>Thư Viện Số</strong> là nền tảng thư viện sách trực tuyến hàng đầu Việt Nam,
                        được thành lập với sứ mệnh mang đến cho bạn trải nghiệm đọc sách tuyệt vời nhất.
                    </p>
                    <p class="text-muted mb-4">
                        Với hàng ngàn đầu sách từ nhiều thể loại khác nhau như văn học, khoa học, công nghệ,
                        kinh tế, và kỹ năng sống - chúng tôi cam kết mang đến cho bạn những nội dung chất lượng
                        nhất từ những tác giả uy tín.
                    </p>
                    <div class="row g-4 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-book fs-1 text-orange me-3"></i>
                                <div>
                                    <h3 class="mb-0 fw-bold">10k+</h3>
                                    <small class="text-muted">Sách điện tử</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people fs-1 text-orange me-3"></i>
                                <div>
                                    <h3 class="mb-0 fw-bold">50k+</h3>
                                    <small class="text-muted">Người dùng</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-star fs-1 text-orange me-3"></i>
                                <div>
                                    <h3 class="mb-0 fw-bold">1k+</h3>
                                    <small class="text-muted">Tác giả</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-download fs-1 text-orange me-3"></i>
                                <div>
                                    <h3 class="mb-0 fw-bold">100k+</h3>
                                    <small class="text-muted">Lượt tải</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('/books') }}" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="bi bi-book me-2"></i>Khám phá sách
                        </a>
                        <a href="{{ url('/contact') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="bi bi-envelope me-2"></i>Liên hệ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase text-orange fw-semibold mb-2">Tại sao chọn chúng tôi</h6>
                <h2 class="fw-bold">Những Điều Khiến Chúng Tôi Khác Biệt</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="bi bi-shield-check text-primary fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Nội dung chất lượng</h5>
                            <p class="text-muted mb-0">Tất cả sách đều được kiểm duyệt kỹ lưỡng, đảm bảo chất lượng nội dung cho người đọc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="bi bi-lightning-charge text-success fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Đọc mọi lúc mọi nơi</h5>
                            <p class="text-muted mb-0">Hỗ trợ đa nền tảng: máy tính, điện thoại, tablet. Đọc sách mọi lúc mọi nơi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="bi bi-wallet2 text-warning fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Giá cả hợp lý</h5>
                            <p class="text-muted mb-0">Hệ thống điểm linh hoạt, nhiều ưu đãi hấp dẫn. Đọc sách với chi phí tối ưu nhất.</p>
                        </div>
                    </div>
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
