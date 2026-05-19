@extends('admin.component-admin.layout')

@section('title', 'Quản lý Tags - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Tags</h1>
            <p class="text-muted mb-0">Quản lý tags sách</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm tag mới
        </button>
    </div>

    <!-- Tags Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Màu sắc</th>
                            <th>Số sách</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags ?? [] as $tag)
                            <tr>
                                <td><strong>{{ $tag->id }}</strong></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $tag->color }}; color: white;">
                                        <i class="bi bi-tag me-1"></i>{{ $tag->name }}
                                    </span>
                                </td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 24px; height: 24px; background-color: {{ $tag->color }}; border-radius: 4px; margin-right: 8px;"></div>
                                        <code>{{ $tag->color }}</code>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $tag->books_count ?? $tag->books->count() }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="editTag({{ $tag->id }}, '{{ addslashes($tag->name) }}', '{{ $tag->slug }}', '{{ $tag->color }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa tag này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-tag fs-3 d-block mb-2"></i>
                                    Chưa có tag nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($tags) && $tags->hasPages())
            <div class="card-footer bg-white">
                {{ $tags->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Tag Mới</h5>
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
                            <label for="color" class="form-label">Màu sắc</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="color" name="color" value="#ED553B" style="width: 60px;">
                                <input type="text" class="form-control" id="color_text" value="#ED553B" style="flex: 1;">
                            </div>
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
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa Tag</h5>
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
                            <label for="edit_color" class="form-label">Màu sắc</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" id="edit_color" name="color" value="#ED553B" style="width: 60px;">
                                <input type="text" class="form-control" id="edit_color_text" value="#ED553B" style="flex: 1;">
                            </div>
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
function editTag(id, name, slug, color) {
    document.getElementById('editForm').action = '/admin/tags/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_color_text').value = color;
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

// Sync color inputs
document.getElementById('color')?.addEventListener('input', function() {
    document.getElementById('color_text').value = this.value;
});
document.getElementById('color_text')?.addEventListener('input', function() {
    document.getElementById('color').value = this.value;
});

document.getElementById('edit_color')?.addEventListener('input', function() {
    document.getElementById('edit_color_text').value = this.value;
});
document.getElementById('edit_color_text')?.addEventListener('input', function() {
    document.getElementById('edit_color').value = this.value;
});
</script>
@endpush
