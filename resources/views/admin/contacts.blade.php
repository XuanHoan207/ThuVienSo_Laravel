@extends('admin.component-admin.layout')

@section('title', 'Quản lý Liên hệ - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Liên hệ</h1>
            <p class="text-muted mb-0">Xem và phản hồi tin nhắn liên hệ từ người dùng</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-1">{{ $stats['total'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Tổng liên hệ</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-1">{{ $stats['unread'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Chưa đọc</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-info mb-1">{{ $stats['read'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã đọc</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success mb-1">{{ $stats['replied'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Đã phản hồi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.contacts.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm tên, email, chủ đề..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Đã đọc</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-lg me-2"></i>Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Người gửi</th>
                            <th>Chủ đề</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="{{ $contact->status === 'unread' ? 'table-warning' : '' }}">
                                <td><strong>{{ $contact->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $contact->user && $contact->user->avatar
                                            ? asset('storage/avatars/' . $contact->user->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($contact->name) . '&background=random' }}"
                                             alt="" class="rounded-circle me-2"
                                             style="width: 32px; height: 32px;">
                                        <div>
                                            <div class="fw-medium">{{ $contact->name }}</div>
                                            <small class="text-muted">{{ $contact->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($contact->subject, 40) }}</td>
                                <td>
                                    <span data-bs-toggle="tooltip" title="{{ $contact->message }}">
                                        {{ Str::limit($contact->message, 50) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($contact->status)
                                        @case('unread')
                                            <span class="badge bg-warning text-dark">Chưa đọc</span>
                                            @break
                                        @case('read')
                                            <span class="badge bg-info">Đã đọc</span>
                                            @break
                                        @case('replied')
                                            <span class="badge bg-success">Đã phản hồi</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $contact->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-outline-primary" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($contact->status !== 'replied')
                                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-outline-success" title="Phản hồi">
                                                <i class="bi bi-reply"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-envelope-open fs-3 d-block mb-2"></i>
                                    Chưa có liên hệ nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($contacts->hasPages())
            <div class="card-footer bg-white">
                {{ $contacts->links() }}
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
