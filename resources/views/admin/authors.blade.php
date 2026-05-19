@extends('admin.component-admin.layout')

@section('title', 'Quản lý Tác giả - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Tác giả</h1>
            <p class="text-muted mb-0">Quản lý tất cả tác giả trong hệ thống</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm tác giả mới
        </button>
    </div>

    <!-- Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.authors.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm tác giả..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Authors Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="80">Avatar</th>
                            <th>Tên tác giả</th>
                            <th>Email</th>
                            <th>Số sách</th>
                            <th>Website</th>
                            <th>Ngày tạo</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($authors ?? [] as $author)
                            <tr>
                                <td><strong>{{ $author->id }}</strong></td>
                                <td>
                                    <img src="{{ $author->image
                                        ? asset('storage/authors/' . $author->image)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=random' }}"
                                         alt="" class="rounded-circle"
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $author->name }}</strong>
                                    @if($author->bio)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($author->bio, 40) }}</small>
                                    @endif
                                </td>
                                <td>{{ $author->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $author->books_count ?? $author->books->count() }}</span>
                                </td>
                                <td>
                                    @if($author->website)
                                        <a href="{{ $author->website }}" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-globe"></i> Link
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $author->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="editAuthor({{ $author->id }}, '{{ addslashes($author->name) }}', '{{ $author->slug }}', '{{ addslashes($author->email ?? '') }}', '{{ addslashes($author->website ?? '') }}', `{{ addslashes($author->bio ?? '') }}`)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tác giả này không?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-person-badge fs-3 d-block mb-2"></i>
                                    Chưa có tác giả nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($authors) && $authors->hasPages())
            <div class="card-footer bg-white">
                {{ $authors->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Tác giả Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên tác giả <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Tiểu sử</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tạo tác giả</button>
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
                        <h5 class="modal-title">Sửa Tác giả</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Tên tác giả <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="edit_website" name="website" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="edit_bio" class="form-label">Tiểu sử</label>
                            <textarea class="form-control" id="edit_bio" name="bio" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Avatar mới</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
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
function editAuthor(id, name, slug, email, website, bio) {
    document.getElementById('editForm').action = '/admin/authors/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_website').value = website;
    document.getElementById('edit_bio').value = bio.replace(/\\n/g, '\n');

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// Auto-generate slug
document.getElementById('name')?.addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (!slugInput.dataset.manual) {
        slugInput.value = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .trim();
    }
});

document.getElementById('slug')?.addEventListener('input', function() {
    this.dataset.manual = 'true';
});
</script>
@endpush
