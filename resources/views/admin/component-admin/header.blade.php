<header class="admin-header">
    <!-- Toggle Sidebar Button -->
    <button class="btn btn-link sidebar-toggle d-none d-lg-flex" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Mobile Toggle -->
    <button class="btn btn-link sidebar-toggle-mobile d-lg-none" id="sidebarToggleMobile">
        <i class="bi bi-list"></i>
    </button>

    <!-- Search -->
    <form class="admin-search d-none d-md-flex">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Tìm kiếm...">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    <!-- Right Actions -->
    <div class="header-actions d-flex align-items-center gap-3">
        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    5
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                <div class="dropdown-header d-flex justify-content-between align-items-center">
                    <span>Thông báo</span>
                    <a href="#" class="small">Đánh dấu tất cả đã đọc</a>
                </div>
                <div class="notification-list">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon bg-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="notification-content">
                                <p class="mb-0">Sách mới được đăng: "Python Cơ Bản"</p>
                                <small class="text-muted">5 phút trước</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item unread">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon bg-warning">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="notification-content">
                                <p class="mb-0">Người dùng nạp 500 điểm</p>
                                <small class="text-muted">15 phút trước</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon bg-danger">
                                <i class="bi bi-flag"></i>
                            </div>
                            <div class="notification-content">
                                <p class="mb-0">Báo cáo sách mới cần xử lý</p>
                                <small class="text-muted">1 giờ trước</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ url('/admin/notifications') }}" class="small">Xem tất cả thông báo</a>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="dropdown">
            <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-chat-dots"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    3
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                <div class="dropdown-header">
                    <span>Tin nhắn</span>
                </div>
                <div class="notification-list">
                    <a href="#" class="dropdown-item unread">
                        <div class="d-flex align-items-start">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" 
                                 alt="" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                            <div class="notification-content">
                                <p class="mb-0 fw-semibold">Nguyễn Văn A</p>
                                <small class="text-muted">Cảm ơn admin đã duyệt sách...</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-start">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" 
                                 alt="" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                            <div class="notification-content">
                                <p class="mb-0 fw-semibold">Trần Thị B</p>
                                <small class="text-muted">Cho mình hỏi về cách nạp điểm...</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#" class="small">Xem tất cả tin nhắn</a>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="dropdown">
            <button class="user-profile-btn" type="button" data-bs-toggle="dropdown">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" 
                     alt="Admin" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                <span class="d-none d-md-inline ms-2">Admin</span>
                <i class="bi bi-chevron-down ms-2"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                <div class="profile-header">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" 
                         alt="" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                    <h6 class="mb-0">Admin User</h6>
                    <small class="text-muted">admin@thuvienso.vn</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/admin/profile') }}" class="dropdown-item">
                    <i class="bi bi-person me-2"></i>Hồ sơ cá nhân
                </a>
                <a href="{{ url('/admin/settings') }}" class="dropdown-item">
                    <i class="bi bi-gear me-2"></i>Cài đặt
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/logout') }}" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-left me-2"></i>Đăng xuất
                </a>
            </div>
        </div>
    </div>
</header>
