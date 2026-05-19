@extends('admin.component-admin.layout')

@section('title', 'Quản lý Bình luận - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Bình luận</h1>
            <p class="text-muted mb-0">Kiểm duyệt bình luận và đánh giá</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-1">{{ $totalComments ?? 0 }}</h3>
                    <p class="text-muted mb-0">Tổng bình luận</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-1">{{ $pendingComments ?? 0 }}</h3>
                    <p class="text-muted mb-0">Chờ duyệt</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success mb-1">{{ $approvedComments ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã duyệt</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-danger mb-1">{{ $rejectedComments ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã từ chối</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.comments.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm nội dung bình luận..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-lg me-2"></i>Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Comments Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Người bình luận</th>
                            <th>Sách</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày</th>
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments ?? [] as $comment)
                            <tr>
                                <td><strong>{{ $comment->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $comment->user && $comment->user->avatar
                                            ? asset('storage/avatars/' . $comment->user->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name ?? 'U') . '&background=random' }}"
                                             alt="" class="rounded-circle me-2"
                                             style="width: 32px; height: 32px;">
                                        <span>{{ $comment->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('books.show', $comment->book->slug ?? '#') }}" target="_blank" class="text-decoration-none">
                                        {{ Str::limit($comment->book->title ?? 'N/A', 30) }}
                                    </a>
                                </td>
                                <td>
                                    <span data-bs-toggle="tooltip" title="{{ $comment->content }}">
                                        {{ Str::limit($comment->content, 60) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($comment->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Đã duyệt</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Đã từ chối</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $comment->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($comment->status === 'pending')
                                            <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success" title="Duyệt">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-chat-dots fs-3 d-block mb-2"></i>
                                    Chưa có bình luận nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($comments) && $comments->hasPages())
            <div class="card-footer bg-white">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>
@endpush
