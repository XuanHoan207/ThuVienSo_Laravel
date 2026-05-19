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
                    <a class="nav-link {{ Request::is('admin') || Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
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
                    <a class="nav-link {{ Request::is('admin/books*') ? 'active' : '' }}" href="{{ route('admin.books.index') }}">
                        <i class="bi bi-book"></i>
                        <span>Quản lý Sách</span>
                        @if(isset($pendingBooksCount) && $pendingBooksCount > 0)
                            <span class="badge bg-warning text-dark float-end">{{ $pendingBooksCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/authors*') ? 'active' : '' }}" href="{{ route('admin.authors.index') }}">
                        <i class="bi bi-person-badge"></i>
                        <span>Quản lý Tác giả</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/publishers*') ? 'active' : '' }}" href="{{ route('admin.publishers.index') }}">
                        <i class="bi bi-building"></i>
                        <span>Nhà xuất bản</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/tags*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                        <i class="bi bi-tags"></i>
                        <span>Tags</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/sliders*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                        <i class="bi bi-image"></i>
                        <span>Sliders</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Kiểm duyệt</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reviews') || Request::is('admin/comments') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                        <i class="bi bi-chat-dots"></i>
                        <span>Bình luận</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-flag"></i>
                        <span>Báo cáo</span>
                        @if(isset($pendingReportsCount) && $pendingReportsCount > 0)
                            <span class="badge bg-danger float-end">{{ $pendingReportsCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                        <i class="bi bi-envelope"></i>
                        <span>Liên hệ</span>
                        @if(isset($unreadContactsCount) && $unreadContactsCount > 0)
                            <span class="badge bg-warning text-dark float-end">{{ $unreadContactsCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <p class="nav-section-title">Đơn hàng & Giao dịch</p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-cart3"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/transactions*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
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
                    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/admins*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
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
                    <a class="nav-link {{ Request::is('admin/notifications*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
                        <i class="bi bi-bell"></i>
                        <span>Thông báo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
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
        <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i>
            <span>Đăng xuất</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</aside>
