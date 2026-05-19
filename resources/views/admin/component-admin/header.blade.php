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
    <form class="admin-search d-none d-md-flex" action="{{ route('admin.books.index') }}" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sách..." value="{{ request('search') }}">
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
                @if(isset($unreadNotifications) && $unreadNotifications > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                    </span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                <div class="dropdown-header d-flex justify-content-between align-items-center">
                    <span>Thông báo</span>
                    <a href="{{ route('admin.notifications.index') }}" class="small">Xem tất cả</a>
                </div>
                <div class="notification-list">
                    @forelse($latestNotifications ?? [] as $notification)
                        <a href="{{ $notification->link ?? '#' }}" class="dropdown-item {{ !$notification->is_read ? 'unread' : '' }}">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon bg-{{ $notification->icon_color ?? 'primary' }}">
                                    <i class="bi {{ $notification->icon ?? 'bi-bell' }}"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="mb-0">{{ $notification->title }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="dropdown-item text-center text-muted py-3">
                            Không có thông báo nào
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="dropdown">
            <button class="user-profile-btn" type="button" data-bs-toggle="dropdown">
                <img src="{{ Auth::user() && Auth::user()->avatar
                    ? asset('storage/avatars/' . Auth::user()->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=random' }}"
                     alt="{{ Auth::user()->name ?? 'Admin' }}" class="rounded-circle"
                     style="width: 40px; height: 40px; object-fit: cover;">
                <span class="d-none d-md-inline ms-2">{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="bi bi-chevron-down ms-2"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                <div class="profile-header">
                    <img src="{{ Auth::user() && Auth::user()->avatar
                        ? asset('storage/avatars/' . Auth::user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=random' }}"
                         alt="" class="rounded-circle mb-2"
                         style="width: 60px; height: 60px; object-fit: cover;">
                    <h6 class="mb-0">{{ Auth::user()->name ?? 'Admin' }}</h6>
                    <small class="text-muted">{{ Auth::user()->email ?? 'admin@thuvienso.vn' }}</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                    <i class="bi bi-person me-2"></i>Hồ sơ cá nhân
                </a>
                <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                    <i class="bi bi-gear me-2"></i>Cài đặt
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                    <i class="bi bi-box-arrow-left me-2"></i>Đăng xuất
                </a>
                <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>
