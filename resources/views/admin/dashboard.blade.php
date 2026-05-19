@extends('admin.component-admin.layout')

@section('title', 'Dashboard - Admin Thư Viện Số')

@push('styles')
    @vite('resources/css/admin/dashboard.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/dashboard.js')
@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Chào mừng bạn quay trở lại, {{ Auth::user()->name ?? 'Admin' }}!</p>
        </div>
        <div>
            <span class="text-muted">
                <i class="bi bi-calendar me-1"></i>
                {{ date('d/m/Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format($totalBooks ?? 0) }}</span>
                        <span class="stat-card-label">Tổng sách</span>
                    </div>
                    @if(isset($newBooksThisMonth) && $newBooksThisMonth > 0)
                        <span class="stat-trend stat-trend-up">
                            <i class="bi bi-arrow-up"></i> +{{ $newBooksThisMonth }} tháng này
                        </span>
                    @endif
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('admin.books.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format($totalUsers ?? 0) }}</span>
                        <span class="stat-card-label">Người dùng</span>
                    </div>
                    @if(isset($newUsersThisMonth) && $newUsersThisMonth > 0)
                        <span class="stat-trend stat-trend-up">
                            <i class="bi bi-arrow-up"></i> +{{ $newUsersThisMonth }} tháng này
                        </span>
                    @endif
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format($totalOrders ?? 0) }}</span>
                        <span class="stat-card-label">Đơn hàng</span>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format($monthlyRevenue ?? 0) }}đ</span>
                        <span class="stat-card-label">Doanh thu tháng</span>
                    </div>
                    @if(isset($revenueChange) && $revenueChange != 0)
                        <span class="stat-trend {{ $revenueChange >= 0 ? 'stat-trend-up' : 'stat-trend-down' }}">
                            <i class="bi bi-arrow-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs($revenueChange) }}% so với tháng trước
                        </span>
                    @endif
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng gần đây</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Sách</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                    <tr>
                                        <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $order->user && $order->user->avatar
                                                    ? asset('storage/avatars/' . $order->user->avatar)
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($order->user->name ?? 'U') . '&background=random' }}"
                                                     alt="" class="rounded-circle me-2"
                                                     style="width: 30px; height: 30px;">
                                                <span>{{ $order->user->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $order->book->title ?? 'N/A' }}</td>
                                        <td><strong>{{ number_format($order->price_paid) }} điểm</strong></td>
                                        <td>
                                            @switch($order->status ?? 'completed')
                                                @case('completed')
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Đang xử lý</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Chưa có đơn hàng nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Books -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sách chờ duyệt</h5>
                    <span class="badge bg-warning text-dark">{{ $pendingBooksCount ?? 0 }}</span>
                </div>
                <div class="card-body p-0">
                    @if(isset($pendingBooks) && $pendingBooks->count() > 0)
                        <div class="pending-list">
                            @foreach($pendingBooks as $book)
                                <div class="pending-item">
                                    <img src="{{ $book->thumbnail
                                        ? asset('storage/covers/' . $book->thumbnail)
                                        : 'https://via.placeholder.com/100x100?text=No+Image' }}"
                                         alt="" class="rounded">
                                    <div class="pending-info">
                                        <h6 class="mb-1">{{ Str::limit($book->title, 30) }}</h6>
                                        <small class="text-muted">{{ $book->user->name ?? 'N/A' }}</small>
                                        <br>
                                        <small class="text-muted">{{ $book->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="pending-actions">
                                        <form action="{{ route('admin.books.approve', $book->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Duyệt">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.books.reject', $book->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Từ chối">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer bg-white text-center">
                            <a href="{{ route('admin.books.index') }}?status=pending" class="btn btn-sm btn-outline-primary">
                                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-check-circle fs-3 d-block mb-2"></i>
                            Không có sách chờ duyệt
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thống kê nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Sách mới tuần này</span>
                        <strong class="text-success">+{{ $newBooksThisWeek ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Người dùng mới</span>
                        <strong class="text-primary">+{{ $newUsersThisWeek ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Báo cáo chờ xử lý</span>
                        <strong class="text-warning">{{ $pendingReportsCount ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Đơn hàng chờ</span>
                        <strong class="text-info">{{ $pendingOrdersCount ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Books Section -->
    @if(isset($topBooks) && $topBooks->count() > 0)
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top 10 sách xem nhiều nhất</h5>
                    <a href="{{ route('admin.books.index') }}?sort=views&direction=desc" class="btn btn-sm btn-outline-primary">
                        Xem tất cả
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh bìa</th>
                                    <th>Tiêu đề</th>
                                    <th>Thể loại</th>
                                    <th>Lượt xem</th>
                                    <th>Lượt tải</th>
                                    <th>Đánh giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topBooks as $index => $book)
                                    <tr>
                                        <td><strong>{{ $index + 1 }}</strong></td>
                                        <td>
                                            <img src="{{ $book->thumbnail
                                                ? asset('storage/' . $book->thumbnail)
                                                : 'https://via.placeholder.com/50x60?text=No+Image' }}"
                                                 alt="" class="rounded"
                                                 style="width: 50px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>{{ Str::limit($book->title, 40) }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $book->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td><strong>{{ number_format($book->view_count) }}</strong></td>
                                        <td>{{ number_format($book->download_count) }}</td>
                                        <td>
                                            @if($book->rating_avg > 0)
                                                <span class="text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    {{ number_format($book->rating_avg, 1) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Chưa có</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
