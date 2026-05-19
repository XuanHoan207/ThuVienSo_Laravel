@extends('admin.component-admin.layout')

@section('title', 'Quản lý Người dùng - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Người dùng</h1>
            <p class="text-muted mb-0">Quản lý tài khoản người dùng</p>
        </div>
        <button class="btn btn-success" onclick="exportUsers()">
            <i class="bi bi-download me-2"></i>Xuất Excel
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm tên, email..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="role">
                            <option value="">Tất cả vai trò</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                            <option value="author" {{ request('role') == 'author' ? 'selected' : '' }}>Tác giả</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Bị khóa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Lọc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-lg me-2"></i>Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th width="70">Avatar</th>
                            <th>Người dùng</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Điểm</th>
                            <th>Trạng thái</th>
                            <th>Ngày tham gia</th>
                            <th width="200">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $user)
                            <tr>
                                <td><strong>{{ $user->id }}</strong></td>
                                <td>
                                    <img src="{{ $user->avatar
                                        ? asset('storage/avatars/' . $user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                         alt="" class="rounded-circle"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->phone)
                                        <br>
                                        <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $user->phone }}</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($user->points) }}</strong>
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Bị khóa</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->role !== 'admin')
                                            @if($user->status == 1)
                                                <form action="{{ route('admin.users.ban', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning" title="Khóa tài khoản"
                                                            onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                                        <i class="bi bi-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.users.unban', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Mở khóa">
                                                        <i class="bi bi-unlock"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Xóa"
                                                        onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-3 d-block mb-2"></i>
                                    Chưa có người dùng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($users) && $users->hasPages())
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
function exportUsers() {
    window.location.href = '{{ route('admin.users.export') }}?{{ http_build_query(request()->all()) }}';
}
</script>
@endpush
