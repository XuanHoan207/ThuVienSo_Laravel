@extends('admin.component-admin.layout')

@section('title', 'Quản lý Danh mục - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Danh mục</h1>
            <p class="text-muted mb-0">Quản lý danh mục sách</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm danh mục mới
        </button>
    </div>

    <!-- Categories Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th width="100">Icon</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Danh mục cha</th>
                            <th>Số sách</th>
                            <th>Thứ tự</th>
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories ?? [] as $category)
                            <tr>
                                <td><strong>{{ $category->id }}</strong></td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/categories/' . $category->image) }}"
                                             alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-grid text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>
                                    @if($category->parent)
                                        <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $category->books_count ?? $category->books->count() }}</span>
                                </td>
                                <td>{{ $category->order }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->slug }}', '{{ $category->description }}', {{ $category->parent_id ?? 'null' }}, {{ $category->order }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-grid fs-3 d-block mb-2"></i>
                                    Chưa có danh mục nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($categories) && $categories->hasPages())
            <div class="card-footer bg-white">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Danh mục Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Danh mục cha</label>
                            <select class="form-select" id="parent_id" name="parent_id">
                                <option value="">-- Không có --</option>
                                @foreach($allCategories ?? [] as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="order" name="order" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Icon/Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tạo danh mục</button>
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
                        <h5 class="modal-title">Sửa Danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="edit_parent_id" class="form-label">Danh mục cha</label>
                            <select class="form-select" id="edit_parent_id" name="parent_id">
                                <option value="">-- Không có --</option>
                                @foreach($allCategories ?? [] as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_order" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="edit_order" name="order" value="0">
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
function editCategory(id, name, slug, description, parentId, order) {
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_order').value = order;

    const parentSelect = document.getElementById('edit_parent_id');
    parentSelect.value = parentId;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// Auto-generate slug
document.getElementById('name').addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (!slugInput.dataset.manual) {
        slugInput.value = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manual = 'true';
});
</script>
@endpush
