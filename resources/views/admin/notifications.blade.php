@extends('admin.component-admin.layout')

@section('title', 'Thông báo - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Thông báo</h1>
            <p class="text-muted mb-0">Quản lý thông báo hệ thống</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Gửi thông báo
        </button>
    </div>

    <!-- Notifications Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Người nhận</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications ?? [] as $notification)
                            <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}">
                                <td><strong>{{ $notification->id }}</strong></td>
                                <td>
                                    @if($notification->user)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $notification->user->avatar
                                                ? asset('storage/avatars/' . $notification->user->avatar)
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($notification->user->name) . '&background=random' }}"
                                                     alt="" class="rounded-circle me-2"
                                                     style="width: 28px; height: 28px;">
                                            <span>{{ $notification->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Tất cả</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($notification->title, 40) }}</td>
                                <td>{{ Str::limit($notification->content, 60) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $notification->type }}</span>
                                </td>
                                <td>
                                    @if($notification->is_read)
                                        <span class="badge bg-success">Đã đọc</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa đọc</span>
                                    @endif
                                </td>
                                <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-bell fs-3 d-block mb-2"></i>
                                    Chưa có thông báo nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($notifications) && $notifications->hasPages())
            <div class="card-footer bg-white">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.notifications.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Gửi Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Người nhận</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">-- Tất cả người dùng --</option>
                                @foreach($users ?? [] as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Loại thông báo</label>
                            <select class="form-select" id="type" name="type">
                                <option value="system">Hệ thống</option>
                                <option value="announcement">Thông báo</option>
                                <option value="promotion">Khuyến mãi</option>
                                <option value="update">Cập nhật</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung</label>
                            <textarea class="form-control" id="content" name="content" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Gửi thông báo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
