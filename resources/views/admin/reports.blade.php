@extends('admin.component-admin.layout')

@section('title', 'Quản lý Báo cáo - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Báo cáo</h1>
            <p class="text-muted mb-0">Xem và xử lý báo cáo từ người dùng</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-1">{{ $pendingCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Chờ xử lý</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success mb-1">{{ $resolvedCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã xử lý</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-1">{{ $totalCount ?? 0 }}</h3>
                    <p class="text-muted mb-0">Tổng số báo cáo</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select class="form-select" name="type">
                            <option value="">Tất cả loại</option>
                            <option value="copyright" {{ request('type') == 'copyright' ? 'selected' : '' }}>Bản quyền</option>
                            <option value="inappropriate" {{ request('type') == 'inappropriate' ? 'selected' : '' }}>Nội dung không phù hợp</option>
                            <option value="broken_link" {{ request('type') == 'broken_link' ? 'selected' : '' }}>Link hỏng</option>
                            <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Đã xử lý</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-lg me-2"></i>Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Người báo cáo</th>
                            <th>Sách</th>
                            <th>Loại vi phạm</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày</th>
                            <th width="180">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports ?? [] as $report)
                            <tr>
                                <td><strong>{{ $report->id }}</strong></td>
                                <td>
                                    @if($report->user)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $report->user->avatar
                                                ? asset('storage/avatars/' . $report->user->avatar)
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($report->user->name) . '&background=random' }}"
                                                 alt="" class="rounded-circle me-2"
                                                 style="width: 32px; height: 32px;">
                                            <span>{{ $report->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Khách</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.books.edit', $report->book_id) }}" class="text-decoration-none">
                                        {{ Str::limit($report->book->title ?? 'N/A', 30) }}
                                    </a>
                                </td>
                                <td>
                                    @switch($report->type)
                                        @case('copyright')
                                            <span class="badge bg-danger">Bản quyền</span>
                                            @break
                                        @case('inappropriate')
                                            <span class="badge bg-warning text-dark">Không phù hợp</span>
                                            @break
                                        @case('broken_link')
                                            <span class="badge bg-info">Link hỏng</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Khác</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span data-bs-toggle="tooltip" title="{{ $report->reason }}">
                                        {{ Str::limit($report->reason, 50) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($report->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                            @break
                                        @case('resolved')
                                            <span class="badge bg-success">Đã xử lý</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Từ chối</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $report->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($report->status === 'pending')
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-success"
                                                    onclick="resolveReport({{ $report->id }})" title="Xử lý">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <form action="{{ route('admin.reports.reject', $report->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" title="Từ chối">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewReport({{ $report->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-flag fs-3 d-block mb-2"></i>
                                    Chưa có báo cáo nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($reports) && $reports->hasPages())
            <div class="card-footer bg-white">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

    <!-- Resolve Modal -->
    <div class="modal fade" id="resolveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="resolveForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Xử lý Báo cáo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="admin_note" class="form-label">Ghi chú của Admin</label>
                            <textarea class="form-control" id="admin_note" name="admin_note" rows="4"
                                      placeholder="Nhập ghi chú về cách xử lý..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="action" class="form-label">Hành động</label>
                            <select class="form-select" id="action" name="action">
                                <option value="hide_book">Ẩn sách</option>
                                <option value="delete_book">Xóa sách</option>
                                <option value="warning_user">Cảnh cáo người dùng</option>
                                <option value="ban_user">Khóa tài khoản</option>
                                <option value="no_action">Không xử lý</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Xác nhận xử lý</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function resolveReport(id) {
    document.getElementById('resolveForm').action = '/admin/reports/' + id + '/resolve';
    new bootstrap.Modal(document.getElementById('resolveModal')).show();
}

function viewReport(id) {
    alert('Xem chi tiết báo cáo #' + id);
}

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>
@endpush
