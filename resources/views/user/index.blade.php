@extends('user.component.layout')

@section('title', 'Trang Chủ - Thư Viện Số')

@section('content')
    @include('user.component.header')

    <!-- Section 3: Single Image Carousel -->
    <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Book Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Book Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Book Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Top Categories Section -->
    <section class="categories-section py-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h6 class="text-uppercase text-orange fw-semibold mb-1">Categories</h6>
                    <h2 class="fw-bold text-dark">Khám phá các danh mục hàng đầu</h2>
                </div>
                <p class="text-muted mt-3 mt-md-0 ms-md-4" style="max-width: 500px;">
                    Tìm kiếm những cuốn sách hay nhất thuộc nhiều lĩnh vực khác nhau để mở mang kiến thức.
                </p>
            </div>
            <div class="d-flex justify-content-start gap-2 mb-4">
                <button class="btn btn-outline-primary rounded-circle arrow-btn"><i class="bi bi-arrow-left"></i></button>
                <button class="btn btn-primary rounded-circle arrow-btn"><i class="bi bi-arrow-right"></i></button>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="category-card text-center p-3 h-100">
                        <img src="{{ asset('images/cat1.png') }}" class="img-fluid rounded mb-3" alt="Higher Education">
                        <h5 class="fw-semibold mb-2">Giáo dục đại học</h5>
                        <p class="text-muted small mb-0">Tài liệu học tập và nghiên cứu chuyên sâu dành cho sinh viên và giảng viên.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card text-center p-3 h-100">
                        <img src="{{ asset('images/cat2.png') }}" class="img-fluid rounded mb-3" alt="Management Books">
                        <h5 class="fw-semibold mb-2">Quản trị & Kinh doanh</h5>
                        <p class="text-muted small mb-0">Kiến thức về quản lý, khởi nghiệp và phát triển doanh nghiệp bền vững.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card text-center p-3 h-100">
                        <img src="{{ asset('images/cat3.png') }}" class="img-fluid rounded mb-3" alt="Engineering Books">
                        <h5 class="fw-semibold mb-2">Kỹ thuật & Công nghệ</h5>
                        <p class="text-muted small mb-0">Cập nhật những công nghệ mới nhất và kiến thức kỹ thuật thực tiễn.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ url('/books') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">Xem thêm →</a>
            </div>
        </div>
    </section>

    <!-- eBook Section -->
    <section class="ebook-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h6 class="text-uppercase text-orange fw-semibold mb-2">eBook</h6>
                    <h2 class="fw-bold text-dark mb-3">
                        Truy cập, Đọc, Thực hành & Tương tác <br>
                        với nội dung số (eBook)
                    </h2>
                    <p class="text-muted mb-4">
                        Trải nghiệm đọc sách hiện đại với hàng ngàn đầu sách số đa dạng thể loại, dễ dàng truy cập mọi lúc mọi nơi.
                    </p>
                    <form class="position-relative w-100">
                        <input type="email" class="form-control rounded-pill pe-5" placeholder="Nhập địa chỉ email của bạn" required>
                        <button type="submit" class="btn" style="position:absolute;right:6px;top:6px;bottom:6px;background-color:#ff7043;border-color:#ff7043;color:#fff;border-radius:50px;padding:0 1rem;">Đăng nhập</button>
                    </form>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800" alt="Person with Books" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- New Release Section -->
    <section class="new-release-section py-5">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Sách mới phát hành</h2>
                <div>
                    <button class="btn btn-light rounded-circle me-2" id="scrollLeft"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-light rounded-circle" id="scrollRight"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            <div class="book-carousel-wrapper overflow-hidden position-relative">
                <div class="book-carousel d-flex transition-all">
                    <div class="book-card card border-0 me-3">
                        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=400" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Tương lai của AI</h6>
                            <p class="text-muted mb-1">TechPress</p>
                            <p class="fw-semibold text-orange mb-0">500 điểm</p>
                        </div>
                    </div>
                    <div class="book-card card border-0 me-3">
                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Làm chủ mã nguồn</h6>
                            <p class="text-muted mb-1">ByteBooks</p>
                            <p class="fw-semibold text-orange mb-0">400 điểm</p>
                        </div>
                    </div>
                    <div class="book-card card border-0 me-3">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Mẫu thiết kế phần mềm</h6>
                            <p class="text-muted mb-1">O'Reilly</p>
                            <p class="fw-semibold text-orange mb-0">600 điểm</p>
                        </div>
                    </div>
                    <div class="book-card card border-0 me-3">
                        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=400" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Cơ bản về UI/UX</h6>
                            <p class="text-muted mb-1">DesignHub</p>
                            <p class="fw-semibold text-orange mb-0">350 điểm</p>
                        </div>
                    </div>
                    <div class="book-card card border-0 me-3">
                        <img src="{{ asset('images/cat1.png') }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Bí mật Next.js</h6>
                            <p class="text-muted mb-1">WebCraft</p>
                            <p class="fw-semibold text-orange mb-0">700 điểm</p>
                        </div>
                    </div>
                    <div class="book-card card border-0 me-3">
                        <img src="{{ asset('images/cat2.png') }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">JavaScript hiện đại</h6>
                            <p class="text-muted mb-1">CodeSphere</p>
                            <p class="fw-semibold text-orange mb-0">300 điểm</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <span class="indicator active"></span>
                <span class="indicator"></span>
            </div>
        </div>
    </section>

    <!-- Featured Section -->
    <section class="featured-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 text-center">
                    <img src="{{ asset('images/book.png') }}" alt="Featured Product" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-7">
                    <h5 class="text-uppercase text-muted mb-2">Sản phẩm nổi bật</h5>
                    <h2 class="fw-bold mb-3">Combo Sách Công Nghệ</h2>
                    <p class="text-secondary mb-3">Bộ sưu tập đầy đủ các kiến thức nền tảng và nâng cao về lập trình, giúp bạn tiến xa hơn trong sự nghiệp.</p>
                    <h4 class="text-danger mb-4">1,500 điểm</h4>
                    <a href="{{ url('/books') }}" class="btn btn-dark rounded-pill px-4 py-2">Xem thêm →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Offer Section -->
    <section class="offer-section container">
        <div class="row align-items-center">
            <div class="col-md-6 offer-text">
                <h2>Tất cả sách đang giảm giá 50%! Đừng bỏ lỡ!</h2>
                <p>Cơ hội duy nhất trong năm để sở hữu những cuốn sách giá trị với mức giá cực kỳ ưu đãi.</p>
                <div class="timer">
                    <div>768 <span>Ngày</span></div>
                    <div>01 <span>Giờ</span></div>
                    <div>27 <span>Phút</span></div>
                    <div>55 <span>Giây</span></div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/Unsplash.png') }}" alt="Books" class="offer-img img-fluid">
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng ký nhận bản tin của chúng tôi</h3>
        <p>Nhận những cập nhật mới nhất về sách và khuyến mãi trực tiếp qua email của bạn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập địa chỉ email của bạn tại đây">
            <button>GỬI</button>
        </div>
    </section>

    @include('user.component.footer')
@endsection