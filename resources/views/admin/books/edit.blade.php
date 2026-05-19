@extends('admin.component-admin.layout')

@section('title', 'Sửa Sách - Admin Thư Viện Số')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sửa Sách</h1>
            <p class="text-muted mb-0">Cập nhật thông tin sách</p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
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

    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Thông tin sách</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên sách <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug', $book->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                   id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Tác giả</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="authors" class="form-label">Chọn tác giả</label>
                            <select class="form-select select2 @error('authors') is-invalid @enderror"
                                    id="authors" name="authors[]" multiple="multiple">
                                @foreach($authors ?? [] as $author)
                                    <option value="{{ $author->id }}"
                                            {{ in_array($author->id, old('authors', $book->authors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Có thể chọn nhiều tác giả</small>
                            @error('authors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Danh mục & Xuất bản</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Thể loại <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                <option value="">-- Chọn thể loại --</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publisher_id" class="form-label">Nhà xuất bản <span class="text-danger">*</span></label>
                            <select class="form-select @error('publisher_id') is-invalid @enderror"
                                    id="publisher_id" name="publisher_id" required>
                                <option value="">-- Chọn nhà xuất bản --</option>
                                @foreach($publishers ?? [] as $publisher)
                                    <option value="{{ $publisher->id }}"
                                            {{ old('publisher_id', $book->publisher_id) == $publisher->id ? 'selected' : '' }}>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_year" class="form-label">Năm xuất bản</label>
                            <input type="number" class="form-control @error('published_year') is-invalid @enderror"
                                   id="published_year" name="published_year"
                                   value="{{ old('published_year', $book->published_year) }}" min="1900" max="2100">
                            @error('published_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pages" class="form-label">Số trang</label>
                            <input type="number" class="form-control @error('pages') is-invalid @enderror"
                                   id="pages" name="pages" value="{{ old('pages', $book->pages) }}" min="1">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="language" class="form-label">Ngôn ngữ</label>
                            <input type="text" class="form-control @error('language') is-invalid @enderror"
                                   id="language" name="language" value="{{ old('language', $book->language) }}">
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Giá & Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="price_points" class="form-label">Giá (điểm) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price_points') is-invalid @enderror"
                                   id="price_points" name="price_points"
                                   value="{{ old('price_points', $book->price_points) }}" min="0" required>
                            @error('price_points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select class="form-select select2 @error('tags') is-invalid @enderror"
                                    id="tags" name="tags[]" multiple="multiple">
                                @foreach($tags ?? [] as $tag)
                                    <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', $book->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status">
                                <option value="pending" {{ old('status', $book->status) == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="approved" {{ old('status', $book->status) == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="rejected" {{ old('status', $book->status) == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
                                <option value="hidden" {{ old('status', $book->status) == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">File & Hình ảnh</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Ảnh bìa mới</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                   id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="text-muted">Định dạng: JPG, PNG. Kích thước tối đa: 2MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="thumbnailPreview" class="mt-2">
                                @if($book->thumbnail)
                                    <img src="{{ asset('storage/covers/' . $book->thumbnail) }}"
                                         class="img-thumbnail" style="max-height: 150px;">
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file_path" class="form-label">File sách mới</label>
                            <input type="file" class="form-control @error('file_path') is-invalid @enderror"
                                   id="file_path" name="file_path" accept=".pdf,.epub">
                            <small class="text-muted">Định dạng: PDF, EPUB. Kích thước tối đa: 50MB</small>
                            @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($book->file_path)
                                <div class="mt-2">
                                    <span class="badge bg-info">
                                        <i class="bi bi-file-earmark-text me-1"></i>
                                        File hiện tại: {{ $book->file_type ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-circle me-2"></i>Cập nhật sách
                </button>

                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa sách này không?')">
                        <i class="bi bi-trash me-2"></i>Xóa sách
                    </button>
                </form>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/vi.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: 'Chọn...',
        allowClear: true,
        language: 'vi'
    });

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        if (!slugInput.dataset.manual) {
            slugInput.value = generateSlug(this.value);
        }
    });

    slugInput.addEventListener('input', function() {
        slugInput.dataset.manual = 'true';
    });

    function generateSlug(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }

    // Thumbnail preview
    document.getElementById('thumbnail').addEventListener('change', function(e) {
        const preview = document.getElementById('thumbnailPreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-height: 150px;">';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endpush
