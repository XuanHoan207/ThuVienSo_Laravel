    <!-- Top Bar -->
    <div class="top-bar text-white py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #ff7043;">
        <div><i class="bi bi-telephone me-2"></i> 1900 1234</div>
        <div class="social-icons">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/sample logo 1.png') }}" class="me-2" alt="Logo" width="40px">
                <span class="fw-bold text-orange">Thư Viện Số</span>
            </a>

            <form class="d-none d-md-flex me-auto ms-3 search-bar">
                <input class="form-control" type="search" placeholder="Tìm kiếm sách..." />
                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/notifications') }}" class="nav-link position-relative">
                    <i class="bi bi-bell"></i> Thông báo
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </a>
                <a href="{{ url('/cart') }}" class="nav-link"><i class="bi bi-cart"></i> Giỏ hàng</a>
                <a href="{{ url('/wishlist') }}" class="nav-link"><i class="bi bi-heart"></i> Yêu thích</a>
                <a href="{{ url('/my-account') }}" class="nav-link"><i class="bi bi-person"></i> Tài khoản</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Nav Links -->
    <div class="nav-links border-top">
        <div class="container">
            <ul class="nav justify-content-center py-2">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('books') || Request::is('books-detail') ? 'active' : '' }}" href="{{ url('/books') }}">Sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('authors') || Request::is('author-detail') ? 'active' : '' }}" href="{{ url('/authors') }}">Tác giả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
