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
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/sample logo 1.png') }}" class="me-2" alt="Logo" width="40px">
                <span class="fw-bold text-orange">Thư Viện Số</span>
            </a>

            <form class="d-none d-md-flex me-auto ms-3 search-bar" action="{{ route('books.index') }}" method="GET">
                <input class="form-control" type="search" name="q" placeholder="Tìm kiếm sách..." value="{{ request('q') }}" />
                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="d-flex align-items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="nav-link"><i class="bi bi-person"></i> Đăng nhập</a>
                @else
                    <a href="{{ route('notifications') }}" class="nav-link position-relative">
                        <i class="bi bi-bell"></i> Thông báo
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ auth()->user()->unreadNotifications()->count() > 9 ? '9+' : auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('cart') }}" class="nav-link position-relative">
                        <i class="bi bi-cart"></i> Giỏ hàng
                        @if(session()->has('cart') && count(session()->get('cart', [])) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 0.6rem;">
                                {{ count(session()->get('cart', [])) }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('wishlist') }}" class="nav-link"><i class="bi bi-heart"></i> Yêu thích</a>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('account.index') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.update') }}"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="{{ route('recharge') }}"><i class="bi bi-wallet2 me-2"></i>Nạp điểm ({{ number_format(auth()->user()->points) }})</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('logoutForm').submit()">
                                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
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
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('books.*') ? 'active' : '' }}" href="{{ url('/books') }}">Sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('authors.*') ? 'active' : '' }}" href="{{ url('/authors') }}">Tác giả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
