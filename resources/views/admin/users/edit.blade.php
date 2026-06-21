@extends('admin.component-admin.layout')

@section('title', 'Sửa Người dùng - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sửa Người dùng</h1>
            <p class="text-muted mb-0">Cập nhật thông tin tài khoản #{{ $user->id }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ $user->avatar
                        ? asset('storage/avatars/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=150' }}"
                         alt="Avatar" class="rounded-circle mb-3"
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    @switch($user->role)
                        @case('admin')
                            <span class="badge bg-danger">Admin</span>
                            @break
                        @case('author')
                            <span class="badge bg-purple" style="background-color: #9333ea;">Tác giả</span>
                            @break
                        @default
                            <span class="badge bg-primary">Người dùng</span>
                    @endswitch
                    @if($user->status == 1)
                        <span class="badge bg-success ms-1">Hoạt động</span>
                    @else
                        <span class="badge bg-danger ms-1">Bị khóa</span>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Ngày tham gia</span>
                        <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Đăng nhập lần cuối</span>
                        <strong>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">IP cuối</span>
                        <strong>{{ $user->last_login_ip ?? 'N/A' }}</strong>
                    </div>
                </div>
            </div>

            @if($user->role !== 'admin')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Thao tác nhanh</h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        @if($user->status == 1)
                            <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-warning w-100"
                                        onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                    <i class="bi bi-lock me-2"></i>Khóa tài khoản
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unban', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="bi bi-unlock me-2"></i>Mở khóa tài khoản
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                <i class="bi bi-trash me-2"></i>Xóa tài khoản
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Chỉnh sửa thông tin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="points" class="form-label">Điểm</label>
                            <input type="number" class="form-control @error('points') is-invalid @enderror"
                                   id="points" name="points" value="{{ old('points', $user->points) }}" min="0">
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Lưu thay đổi
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Vai trò người dùng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò</label>
                            <select class="form-select" id="role" name="role" {{ $user->role === 'admin' ? 'disabled' : '' }}>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Người dùng</option>
                                <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Tác giả</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @if($user->role === 'admin')
                                <small class="text-muted">Không thể thay đổi vai trò của tài khoản admin tại đây.</small>
                            @endif
                        </div>

                        @if($user->role !== 'admin')
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-person-gear me-2"></i>Cập nhật vai trò
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
