@extends('admin.component-admin.layout')

@section('title', 'Giao dịch - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Giao dịch</h1>
            <p class="text-muted mb-0">Theo dõi giao dịch nạp điểm</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-1">{{ number_format($totalRecharge ?? 0) }}</h3>
                    <p class="text-muted mb-0">Tổng tiền nạp (VNĐ)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success mb-1">{{ number_format($totalPointsGiven ?? 0) }}</h3>
                    <p class="text-muted mb-0">Tổng điểm đã tặng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-1">{{ $totalTransactions ?? 0 }}</h3>
                    <p class="text-muted mb-0">Tổng giao dịch</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-info mb-1">{{ number_format($monthlyRecharge ?? 0) }}</h3>
                    <p class="text-muted mb-0">Nạp tháng này (VNĐ)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.transactions.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm người dùng..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="type">
                            <option value="">Tất cả loại</option>
                            <option value="recharge" {{ request('type') == 'recharge' ? 'selected' : '' }}>Nạp tiền</option>
                            <option value="download" {{ request('type') == 'download' ? 'selected' : '' }}>Tải sách</option>
                            <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Mua sách</option>
                            <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Hoàn tiền</option>
                            <option value="bonus" {{ request('type') == 'bonus' ? 'selected' : '' }}>Thưởng</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-lg me-2"></i>Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Loại</th>
                            <th>Số tiền (VNĐ)</th>
                            <th>Điểm</th>
                            <th>Trạng thái</th>
                            <th>Phương thức</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions ?? [] as $transaction)
                            <tr>
                                <td><strong>#{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $transaction->user && $transaction->user->avatar
                                            ? asset('storage/avatars/' . $transaction->user->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($transaction->user->name ?? 'U') . '&background=random' }}"
                                             alt="" class="rounded-circle me-2"
                                             style="width: 30px; height: 30px;">
                                        <span>{{ $transaction->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @switch($transaction->type)
                                        @case('recharge')
                                            <span class="badge bg-success">Nạp tiền</span>
                                            @break
                                        @case('download')
                                            <span class="badge bg-info">Tải sách</span>
                                            @break
                                        @case('purchase')
                                            <span class="badge bg-primary">Mua sách</span>
                                            @break
                                        @case('refund')
                                            <span class="badge bg-warning text-dark">Hoàn tiền</span>
                                            @break
                                        @case('bonus')
                                            <span class="badge bg-purple" style="background-color: #9333ea;">Thưởng</span>
                                            @break
                                        @case('upload')
                                            <span class="badge bg-secondary">Upload</span>
                                            @break
                                        @default
                                            <span class="badge bg-dark">{{ $transaction->type }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <strong>{{ number_format($transaction->amount) }}</strong>
                                </td>
                                <td>
                                    <span class="{{ $transaction->points >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->points >= 0 ? '+' : '' }}{{ number_format($transaction->points) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($transaction->status)
                                        @case('completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Đang xử lý</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger">Thất bại</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-secondary">Đã hủy</span>
                                            @break
                                        @default
                                            <span class="badge bg-dark">{{ $transaction->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $transaction->payment_method ?? '-' }}</td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-wallet2 fs-3 d-block mb-2"></i>
                                    Chưa có giao dịch nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($transactions) && $transactions->hasPages())
            <div class="card-footer bg-white">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@endsection
