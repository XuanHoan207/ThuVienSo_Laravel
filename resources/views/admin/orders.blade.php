@extends('admin.component-admin.layout')

@section('title', 'Quản lý Đơn hàng - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Đơn hàng</h1>
            <p class="text-muted mb-0">Theo dõi và quản lý đơn hàng</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-1">{{ $stats['total'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Tổng đơn hàng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success mb-1">{{ number_format($stats['revenue'] ?? 0) }}</h3>
                    <p class="text-muted mb-0">Tổng doanh thu (điểm)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-1">{{ $stats['completed'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Hoàn thành</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-danger mb-1">{{ $stats['cancelled'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã hủy</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm người dùng, sách..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="payment_type">
                            <option value="">Tất cả</option>
                            <option value="points" {{ request('payment_type') == 'points' ? 'selected' : '' }}>Điểm</option>
                            <option value="free" {{ request('payment_type') == 'free' ? 'selected' : '' }}>Miễn phí</option>
                            <option value="promotion" {{ request('payment_type') == 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Người dùng</th>
                            <th>Sách</th>
                            <th>Số tiền</th>
                            <th>Thanh toán</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                            <tr>
                                <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $order->user && $order->user->avatar
                                            ? asset('storage/avatars/' . $order->user->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($order->user->name ?? 'U') . '&background=random' }}"
                                             alt="" class="rounded-circle me-2"
                                             style="width: 32px; height: 32px;">
                                        <div>
                                            <strong>{{ $order->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ Str::limit($order->book->title ?? 'N/A', 35) }}</strong>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($order->price_paid) }} điểm</strong>
                                </td>
                                <td>
                                    @switch($order->payment_type)
                                        @case('points')
                                            <span class="badge bg-primary">Điểm</span>
                                            @break
                                        @case('free')
                                            <span class="badge bg-success">Miễn phí</span>
                                            @break
                                        @case('promotion')
                                            <span class="badge bg-info">Khuyến mãi</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $order->payment_type }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-cart3 fs-3 d-block mb-2"></i>
                                    Chưa có đơn hàng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($orders) && $orders->hasPages())
            <div class="card-footer bg-white">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
