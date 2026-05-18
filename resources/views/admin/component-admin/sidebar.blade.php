<aside class="admin-sidebar" id="adminSidebar">
    <!-- Logo -->
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('images/sample logo 1.png') }}" alt="Logo" width="40" class="me-2">
            <span class="sidebar-logo-text">Thư Viện Số</span>
        </a>
    </div>

    <!-- Admin Badge -->
    <div class="admin-badge">
        <i class="bi bi-shield-check"></i> Quản trị viên
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-section">
            <p class="nav-section-title">Tổng quan</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Quản lý</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/books') || Request::is('admin/books/*') ? 'active' : '' }}" href="{{ url('/admin/books') }}">
                        <i class="bi bi-book"></i>
                        <span>Quản lý Sách</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/authors') || Request::is('admin/authors/*') ? 'active' : '' }}" href="{{ url('/admin/authors') }}">
                        <i class="bi bi-person-badge"></i>
                        <span>Quản lý Tác giả</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/categories') || Request::is('admin/categories/*') ? 'active' : '' }}" href="{{ url('/admin/categories') }}">
                        <i class="bi bi-grid"></i>
                        <span>Danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reviews') || Request::is('admin/reviews/*') ? 'active' : '' }}" href="{{ url('/admin/reviews') }}">
                        <i class="bi bi-star"></i>
                        <span>Đánh giá</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Đơn hàng & Giao dịch</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/orders') || Request::is('admin/orders/*') ? 'active' : '' }}" href="{{ url('/admin/orders') }}">
                        <i class="bi bi-cart3"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/transactions') || Request::is('admin/transactions/*') ? 'active' : '' }}" href="{{ url('/admin/transactions') }}">
                        <i class="bi bi-wallet2"></i>
                        <span>Giao dịch</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Người dùng</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
                        <i class="bi bi-people"></i>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/admins') || Request::is('admin/admins/*') ? 'active' : '' }}" href="{{ url('/admin/admins') }}">
                        <i class="bi bi-person-gear"></i>
                        <span>Quản trị viên</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Hệ thống</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/notifications') || Request::is('admin/notifications/*') ? 'active' : '' }}" href="{{ url('/admin/notifications') }}">
                        <i class="bi bi-bell"></i>
                        <span>Thông báo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reports') || Request::is('admin/reports/*') ? 'active' : '' }}" href="{{ url('/admin/reports') }}">
                        <i class="bi bi-flag"></i>
                        <span>Báo cáo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : '' }}" href="{{ url('/admin/settings') }}">
                        <i class="bi bi-gear"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="nav-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Xem website</span>
        </a>
        <a href="{{ url('/logout') }}" class="nav-link text-danger">
            <i class="bi bi-box-arrow-left"></i>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>
