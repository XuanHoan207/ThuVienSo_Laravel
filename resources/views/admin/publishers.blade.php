@extends('admin.component-admin.layout')

@section('title', 'Quản lý Nhà xuất bản - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Nhà xuất bản</h1>
            <p class="text-muted mb-0">Quản lý nhà xuất bản</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm nhà xuất bản
        </button>
    </div>

    <!-- Publishers Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="80">Logo</th>
                            <th>Tên</th>
                            <th>Website</th>
                            <th>Ngày tạo</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publishers ?? [] as $publisher)
                            <tr>
                                <td><strong>{{ $publisher->id }}</strong></td>
                                <td>
                                    @if($publisher->logo)
                                        <img src="{{ asset('storage/publishers/' . $publisher->logo) }}"
                                             alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-building text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $publisher->name }}</strong>
                                    @if($publisher->info)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($publisher->info, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($publisher->website)
                                        <a href="{{ $publisher->website }}" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-globe me-1"></i>Link
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $publisher->created_at ? $publisher->created_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="editPublisher({{ $publisher->id }}, '{{ addslashes($publisher->name) }}', '{{ $publisher->slug }}', '{{ addslashes($publisher->website ?? '') }}', `{{ addslashes($publisher->info ?? '') }}`)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.publishers.destroy', $publisher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa nhà xuất bản này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-building fs-3 d-block mb-2"></i>
                                    Chưa có nhà xuất bản nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($publishers) && $publishers->hasPages())
            <div class="card-footer bg-white">
                {{ $publishers->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.publishers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Nhà xuất bản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="info" class="form-label">Thông tin</label>
                            <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa Nhà xuất bản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="edit_website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="edit_website" name="website" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="edit_info" class="form-label">Thông tin</label>
                            <textarea class="form-control" id="edit_info" name="info" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_logo" class="form-label">Logo mới</label>
                            <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function editPublisher(id, name, slug, website, info) {
    document.getElementById('editForm').action = '/admin/publishers/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_website').value = website;
    document.getElementById('edit_info').value = info.replace(/\\n/g, '\n');
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// Auto-generate slug
document.getElementById('name')?.addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (!slugInput.dataset.manual) {
        slugInput.value = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').trim();
    }
});
document.getElementById('slug')?.addEventListener('input', function() { this.dataset.manual = 'true'; });
</script>
@endpush
