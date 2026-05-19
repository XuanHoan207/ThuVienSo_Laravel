@extends('admin.component-admin.layout')

@section('title', 'Hồ sơ - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Hồ sơ cá nhân</h1>
            <p class="text-muted mb-0">Quản lý thông tin tài khoản</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ Auth::user() && Auth::user()->avatar
                        ? asset('storage/avatars/' . Auth::user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=random&size=150' }}"
                         alt="Avatar" class="rounded-circle mb-3"
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <h4>{{ Auth::user()->name ?? 'Admin' }}</h4>
                    <p class="text-muted">{{ Auth::user()->email ?? '' }}</p>
                    <span class="badge bg-danger">Admin</span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thống kê</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Đăng nhập lần cuối</span>
                        <strong>{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">IP cuối</span>
                        <strong>{{ Auth::user()->last_login_ip ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Ngày tham gia</span>
                        <strong>{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : 'N/A' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Edit Profile Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Chỉnh sửa hồ sơ</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name', Auth::user()->name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', Auth::user()->email ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone', Auth::user()->phone ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Giới thiệu</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', Auth::user()->bio ?? '') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-key me-2"></i>Đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
