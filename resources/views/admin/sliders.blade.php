@extends('admin.component-admin.layout')

@section('title', 'Quản lý Sliders - Admin Thư Viện Số')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Sliders</h1>
            <p class="text-muted mb-0">Quản lý banner trang chủ</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-2"></i>Thêm slider mới
        </button>
    </div>

    <!-- Sliders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th width="150">Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Liên kết</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders ?? [] as $slider)
                            <tr>
                                <td><strong>{{ $slider->id }}</strong></td>
                                <td>
                                    <img src="{{ asset('storage/sliders/' . $slider->image) }}"
                                         alt="" class="rounded" style="width: 120px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $slider->title ?? 'N/A' }}</strong>
                                    @if($slider->subtitle)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($slider->subtitle, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($slider->link)
                                        <a href="{{ $slider->link }}" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-link-45deg me-1"></i>Link
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $slider->order }}</td>
                                <td>
                                    @if($slider->status)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary"
                                                onclick="editSlider({{ $slider->id }}, '{{ addslashes($slider->title ?? '') }}', '{{ addslashes($slider->subtitle ?? '') }}', '{{ $slider->link ?? '' }}', '{{ $slider->link_text ?? 'Xem thêm' }}', {{ $slider->order }}, {{ $slider->status ? 'true' : 'false' }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa slider này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-image fs-3 d-block mb-2"></i>
                                    Chưa có slider nào
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
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Slider Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Phụ đề</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <small class="text-muted">Kích thước khuyến nghị: 1920x600px</small>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Liên kết</label>
                            <input type="url" class="form-control" id="link" name="link" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="link_text" class="form-label">Text liên kết</label>
                            <input type="text" class="form-control" id="link_text" name="link_text" value="Xem thêm">
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="order" name="order" value="0">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Hoạt động</label>
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
                <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa Slider</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="edit_title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="edit_subtitle" class="form-label">Phụ đề</label>
                            <input type="text" class="form-control" id="edit_subtitle" name="subtitle">
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Hình ảnh mới</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <small class="text-muted">Để trống nếu không thay đổi</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_link" class="form-label">Liên kết</label>
                            <input type="url" class="form-control" id="edit_link" name="link" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="edit_link_text" class="form-label">Text liên kết</label>
                            <input type="text" class="form-control" id="edit_link_text" name="link_text">
                        </div>
                        <div class="mb-3">
                            <label for="edit_order" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="edit_order" name="order" value="0">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_status" name="status" value="1">
                                <label class="form-check-label" for="edit_status">Hoạt động</label>
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
function editSlider(id, title, subtitle, link, linkText, order, status) {
    document.getElementById('editForm').action = '/admin/sliders/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_subtitle').value = subtitle;
    document.getElementById('edit_link').value = link;
    document.getElementById('edit_link_text').value = linkText;
    document.getElementById('edit_order').value = order;
    document.getElementById('edit_status').checked = status;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
