@extends('user.component.layout')

@section('title', 'Tài Khoản Của Tôi - Thư Viện Số')

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/my-account.css') }}">
<style>
.account-nav .nav-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    transition: all 0.2s;
    background: white;
}
.account-nav .nav-item:hover {
    background: #fff3e0;
    color: #ff7043;
    text-decoration: none;
}
.account-nav .nav-item.active {
    background: linear-gradient(135deg, #ff7043 0%, #ff5722 100%);
    color: white;
}
.account-nav .nav-item i {
    width: 24px;
    margin-right: 12px;
    font-size: 1.1rem;
}
.account-nav .nav-item span {
    flex: 1;
}
.account-nav .nav-item .badge {
    margin-left: auto;
}
.tab-pane {
    display: none;
}
.tab-pane.show,
.tab-pane.active {
    display: block;
}
.book-card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    background: white;
}
.book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.book-card .book-cover {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.book-card .book-info {
    padding: 12px;
}
.stat-card {
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-3px);
}
.profile-header {
    background: linear-gradient(135deg, #ff8a65 0%, #ff7043 100%);
}
.profile-header h6 {
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}
</style>
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Account Section -->
    <section class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <!-- User Profile Summary -->
                    <div class="card-body text-center pb-3 profile-header">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&size=80' }}"
                             alt="" class="rounded-circle mb-2" width="70" height="70" style="border: 3px solid white; object-fit: cover;">
                        <h6 class="mb-0 text-white">{{ Auth::user()->name }}</h6>
                        <small class="text-white-50">{{ Auth::user()->email }}</small>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="account-nav p-0">
                        <a href="#dashboard" class="nav-item active" data-bs-toggle="tab">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#profile" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-person"></i>
                            <span>Hồ sơ</span>
                        </a>
                        <a href="#purchases" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-bag"></i>
                            <span>Sách đã mua</span>
                            <span class="badge bg-primary rounded-pill">{{ $stats['books_purchased'] ?? 0 }}</span>
                        </a>
                        <a href="#downloads" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-download"></i>
                            <span>Tải về</span>
                        </a>
                        <a href="#favorites" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-heart"></i>
                            <span>Yêu thích</span>
                            <span class="badge bg-danger rounded-pill">{{ $stats['favorites_count'] ?? 0 }}</span>
                        </a>
                        <a href="#mybooks" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-book"></i>
                            <span>Sách của tôi</span>
                        </a>
                        <a href="#security" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-shield-lock"></i>
                            <span>Bảo mật</span>
                        </a>
                        <a href="#history" class="nav-item" data-bs-toggle="tab">
                            <i class="bi bi-clock-history"></i>
                            <span>Lịch sử</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <h4 class="fw-bold mb-4"><i class="bi bi-speedometer2 me-2 text-orange"></i>Dashboard</h4>
                        
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-primary text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Tổng điểm</p>
                                            <h2 class="mb-0">{{ number_format($stats['total_points']) }}</h2>
                                        </div>
                                        <i class="bi bi-coin" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="{{ route('recharge') }}" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-plus-circle me-1"></i> Nạp thêm
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-success text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Sách đã mua</p>
                                            <h2 class="mb-0">{{ $stats['books_purchased'] }}</h2>
                                        </div>
                                        <i class="bi bi-bag" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="#purchases" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Xem ngay
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card bg-gradient-warning text-white p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 opacity-75">Yêu thích</p>
                                            <h2 class="mb-0">{{ $stats['favorites_count'] }}</h2>
                                        </div>
                                        <i class="bi bi-heart" style="font-size: 3rem; opacity: 0.5;"></i>
                                    </div>
                                    <a href="#favorites" class="btn btn-light btn-sm mt-3 rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Xem ngay
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/80' }}" 
                                         alt="" class="rounded-circle me-4" width="80" height="80" style="object-fit: cover;">
                                    <div>
                                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                                        <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : (Auth::user()->role === 'author' ? 'info' : 'primary') }}">
                                            {{ ucfirst(Auth::user()->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row g-3 text-center">
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['books_purchased'] }}</h5>
                                        <small class="text-muted">Sách đã mua</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['reviews_count'] }}</h5>
                                        <small class="text-muted">Đánh giá</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="mb-0">{{ $stats['books_uploaded'] }}</h5>
                                        <small class="text-muted">Sách đã đăng</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Tab -->
                    <div class="tab-pane fade" id="profile">
                        <h4 class="fw-bold mb-4"><i class="bi bi-person me-2 text-orange"></i>Hồ sơ</h4>
                        <form action="{{ route('user.profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Địa chỉ</label>
                                            <textarea name="address" class="form-control" rows="2">{{ Auth::user()->address ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Giới thiệu bản thân</label>
                                            <textarea name="bio" class="form-control" rows="3" placeholder="Viết vài dòng về bạn...">{{ Auth::user()->bio ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 rounded-pill px-4">
                                        <i class="bi bi-check2 me-2"></i>Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security">
                        <h4 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-orange"></i>Bảo mật</h4>
                        <form action="{{ route('user.password.change') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="mb-3">Đổi mật khẩu</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control" required minlength="8">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-key me-2"></i>Đổi mật khẩu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Purchases Tab -->
                    <div class="tab-pane fade" id="purchases">
                        <h4 class="fw-bold mb-4"><i class="bi bi-bag me-2 text-orange"></i>Sách đã mua</h4>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if(isset($purchases) && $purchases->count() > 0)
                                    <div class="row g-3">
                                        @foreach($purchases as $purchase)
                                            @if($purchase->book)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="book-card">
                                                    <img src="{{ $purchase->book->thumbnail ? asset('storage/' . $purchase->book->thumbnail) : 'https://via.placeholder.com/150x200' }}"
                                                         alt="" class="book-cover">
                                                    <div class="book-info">
                                                        <h6 class="mb-1">{{ Str::limit($purchase->book->title, 30) }}</h6>
                                                        <small class="text-muted">{{ $purchase->book->authors->pluck('name')->first() ?? 'Unknown' }}</small>
                                                        <div class="mt-2">
                                                            <a href="{{ route('books.show', $purchase->book->slug) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i> Xem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-bag fs-1 d-block mb-3"></i>
                                        <p>Chưa có sách nào được mua</p>
                                        <a href="{{ route('books.index') }}" class="btn btn-primary">Khám phá sách</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Downloads Tab -->
                    <div class="tab-pane fade" id="downloads">
                        <h4 class="fw-bold mb-4"><i class="bi bi-download me-2 text-orange"></i>Tải về</h4>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if(isset($downloads) && $downloads->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sách</th>
                                                    <th>Ngày tải</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($downloads as $download)
                                                    @if($download->book)
                                                    <tr>
                                                        <td>{{ Str::limit($download->book->title, 40) }}</td>
                                                        <td>{{ $download->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>
                                                            <a href="{{ route('books.download', $download->book_id) }}" class="btn btn-sm btn-primary">
                                                                <i class="bi bi-download"></i> Tải lại
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-download fs-1 d-block mb-3"></i>
                                        <p>Chưa có lịch sử tải về</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Favorites Tab -->
                    <div class="tab-pane fade" id="favorites">
                        <h4 class="fw-bold mb-4"><i class="bi bi-heart me-2 text-orange"></i>Sách yêu thích</h4>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if(isset($favorites) && $favorites->count() > 0)
                                    <div class="row g-3">
                                        @foreach($favorites as $favorite)
                                            @if($favorite->book)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="book-card">
                                                    <img src="{{ $favorite->book->thumbnail ? asset('storage/' . $favorite->book->thumbnail) : 'https://via.placeholder.com/150x200' }}"
                                                         alt="" class="book-cover">
                                                    <div class="book-info">
                                                        <h6 class="mb-1">{{ Str::limit($favorite->book->title, 30) }}</h6>
                                                        <small class="text-muted">{{ $favorite->book->authors->pluck('name')->first() ?? 'Unknown' }}</small>
                                                        <div class="mt-2 d-flex gap-2">
                                                            <a href="{{ route('books.show', $favorite->book->slug) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i> Xem
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="removeFavorite({{ $favorite->book->id }})">
                                                                <i class="bi bi-trash"></i> Xóa
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-heart fs-1 d-block mb-3"></i>
                                        <p>Chưa có sách yêu thích</p>
                                        <a href="{{ route('books.index') }}" class="btn btn-primary">Khám phá sách</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- My Books Tab -->
                    <div class="tab-pane fade" id="mybooks">
                        <h4 class="fw-bold mb-4"><i class="bi bi-book me-2 text-orange"></i>Sách của tôi</h4>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if(isset($myBooks) && $myBooks->count() > 0)
                                    <div class="row g-3">
                                        @foreach($myBooks as $book)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="book-card">
                                                    <img src="{{ $book->thumbnail ? asset('storage/' . $book->thumbnail) : 'https://via.placeholder.com/150x200' }}"
                                                         alt="" class="book-cover">
                                                    <div class="book-info">
                                                        <h6 class="mb-1">{{ Str::limit($book->title, 30) }}</h6>
                                                        <small class="text-muted">{{ $book->authors->pluck('name')->first() ?? 'Unknown' }}</small>
                                                        <div class="mt-2">
                                                            <a href="{{ route('books.show', $book->slug) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i> Xem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-book fs-1 d-block mb-3"></i>
                                        <p>Chưa có sách nào được đăng tải</p>
                                        <a href="{{ route('user.books.upload') }}" class="btn btn-primary">Đăng sách mới</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- History Tab -->
                    <div class="tab-pane fade" id="history">
                        <h4 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-orange"></i>Lịch sử đọc</h4>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if(isset($history) && $history->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Sách</th>
                                                    <th>Ngày đọc</th>
                                                    <th>Tiến độ</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($history as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <img src="{{ $item->book->thumbnail ? asset('storage/' . $item->book->thumbnail) : 'https://via.placeholder.com/60x80' }}"
                                                                     alt="" style="width: 50px; height: 65px; object-fit: cover;" class="rounded">
                                                                <div>
                                                                    <h6 class="mb-0">{{ Str::limit($item->book->title, 35) }}</h6>
                                                                    <small class="text-muted">{{ $item->book->authors->pluck('name')->first() ?? 'Unknown' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">{{ $item->last_read_at ? \Carbon\Carbon::parse($item->last_read_at)->format('d/m/Y H:i') : '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="progress flex-grow-1" style="height: 8px; min-width: 100px;">
                                                                    <div class="progress-bar bg-orange" role="progressbar" style="width: {{ $item->max_pages_read && $item->book->pages ? round($item->max_pages_read / $item->book->pages * 100) : 0 }}%"></div>
                                                                </div>
                                                                <small class="text-muted">{{ $item->max_pages_read && $item->book->pages ? round($item->max_pages_read / $item->book->pages * 100) : 0 }}%</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('books.show', $item->book->slug) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-book-open"></i> Đọc tiếp
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-clock-history fs-1 d-block mb-3"></i>
                                        <p>Chưa có lịch sử đọc sách</p>
                                        <a href="{{ route('books.index') }}" class="btn btn-primary">Khám phá sách</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('styles')
<style>
    .account-nav .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
        transition: all 0.2s;
    }
    .account-nav .nav-item:last-child {
        border-bottom: none;
    }
    .account-nav .nav-item:hover {
        background: #fff3e0;
        color: #ff7043;
    }
    .account-nav .nav-item.active {
        background: linear-gradient(135deg, #ff7043 0%, #ff5722 100%);
        color: white;
    }
    .account-nav .nav-item i {
        width: 24px;
        margin-right: 12px;
        font-size: 1.1rem;
    }
    .account-nav .nav-item span {
        flex: 1;
    }
    .account-nav .nav-item .badge {
        margin-left: auto;
    }
    .book-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .book-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .book-card .book-cover {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .book-card .book-info {
        padding: 12px;
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    document.querySelectorAll('.account-nav a[data-bs-toggle="tab"]').forEach(function(triggerEl) {
        triggerEl.addEventListener('click', function(e) {
            e.preventDefault();
            var targetId = this.getAttribute('href');

            // Remove active from all nav items
            document.querySelectorAll('.account-nav a').forEach(function(item) {
                item.classList.remove('active');
            });
            this.classList.add('active');

            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });

            // Show target tab
            var targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
});

function removeFavorite(bookId) {
    if (!confirm('Bạn có chắc muốn xóa khỏi yêu thích?')) return;
    fetch('/books/' + bookId + '/wishlist', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              location.reload();
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Có lỗi xảy ra khi xóa sách yêu thích');
      });
}

function toggleFavorite(bookId) {
    fetch('/books/' + bookId + '/wishlist', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              location.reload();
          }
      });
}
</script>
@endpush
