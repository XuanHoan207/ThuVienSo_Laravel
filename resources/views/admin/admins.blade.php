@extends('admin.component-admin.layout')

@section('title', 'Quản trị viên - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản trị viên</h1>
            <p class="text-muted mb-0">Quản lý tài khoản quản trị</p>
        </div>
        @if(Auth::user()->role === 'super_admin')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle me-2"></i>Thêm admin mới
            </button>
        @endif
    </div>

    <!-- Admins Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="80">Avatar</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Đăng nhập cuối</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins ?? [] as $admin)
                            <tr>
                                <td><strong>{{ $admin->id }}</strong></td>
                                <td>
                                    <img src="{{ $admin->avatar
                                        ? asset('storage/avatars/' . $admin->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=random' }}"
                                         alt="" class="rounded-circle"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $admin->name }}</strong>
                                    @if($admin->id === Auth::id())
                                        <span class="badge bg-info ms-2">Bạn</span>
                                    @endif
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @switch($admin->role)
                                        @case('super_admin')
                                            <span class="badge bg-danger">Super Admin</span>
                                            @break
                                        @case('admin')
                                            <span class="badge bg-warning text-dark">Admin</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $admin->role }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($admin->last_login_at)
                                        {{ $admin->last_login_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Chưa đăng nhập</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-person-gear fs-3 d-block mb-2"></i>
                                    Chưa có admin nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.admins.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Admin Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Quyền</label>
                            <select class="form-select" id="role" name="role">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tạo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
