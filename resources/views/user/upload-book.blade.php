@extends('user.component.layout')

@section('title', 'Đăng Sách Mới - Thư Viện Số')

@push('styles')
    @vite('resources/css/upload-book.css')
@endpush

@push('scripts')
    @vite('resources/js/upload-book.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng sách mới</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Upload Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold text-center mb-2"><i class="bi bi-cloud-upload me-2 text-orange"></i>Đăng Sách Mới</h2>
                    <p class="text-center text-muted mb-4">Chia sẻ kiến thức của bạn với cộng đồng độc giả</p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        
                        <!-- Step 1: Basic Info -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-orange"></i>Thông tin cơ bản</h5>
                                
                                <!-- Title -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tiêu đề sách <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề sách" value="{{ old('title') }}" required>
                                </div>

                                <!-- ISBN -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">ISBN</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="Mã số ISBN (nếu có)" value="{{ old('isbn') }}">
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Mô tả <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="Mô tả nội dung sách..." required>{{ old('description') }}</textarea>
                                </div>

                                <!-- Category -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Năm xuất bản</label>
                                        <input type="number" name="published_year" class="form-control" placeholder="VD: 2024" value="{{ old('published_year') }}" min="1900" max="{{ date('Y') }}">
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tags</label>
                                    <select name="tags[]" class="form-select" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Giữ Ctrl/Cmd để chọn nhiều tags</small>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Upload Files -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4"><i class="bi bi-file-earmark-arrow-up me-2 text-orange"></i>Tải lên tệp</h5>

                                <!-- Authors -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Tác giả</label>
                                    <select name="authors[]" class="form-select" multiple>
                                        @foreach($authors as $author)
                                            <option value="{{ $author->id }}" {{ in_array($author->id, old('authors', [])) ? 'selected' : '' }}>
                                                {{ $author->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Giữ Ctrl/Cmd để chọn nhiều tác giả</small>
                                </div>

                                <!-- Book File Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">File sách <span class="text-danger">*</span></label>
                                    <div class="upload-area" id="fileDropZone">
                                        <i class="bi bi-cloud-arrow-up display-4 text-orange mb-3"></i>
                                        <h5>Kéo thả file vào đây hoặc click để chọn</h5>
                                        <p class="text-muted mb-2">Hỗ trợ: PDF, EPUB, MOBI (Tối đa 50MB)</p>
                                        <input type="file" name="book_file" id="bookFile" accept=".pdf,.epub,.mobi" required>
                                    </div>
                                    <div id="filePreview" class="mt-2" style="display: none;">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="bi bi-file-earmark-pdf text-danger me-2 fs-4"></i>
                                            <div class="flex-grow-1">
                                                <strong id="fileName"></strong>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thumbnail Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Ảnh bìa</label>
                                    <div class="upload-area" id="thumbnailDropZone" style="padding: 2rem;">
                                        <input type="file" name="thumbnail" id="thumbnailFile" accept="image/*">
                                        <img id="thumbnailPreview" src="" alt="" style="display: none; max-width: 200px; border-radius: 8px;" class="mb-2">
                                        <div id="thumbnailPlaceholder">
                                            <i class="bi bi-image text-orange mb-2" style="font-size: 2rem;"></i>
                                            <p class="mb-0">Click để chọn ảnh bìa (JPG, PNG - Tối đa 5MB)</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Giá bán (điểm) <span class="text-danger">*</span></label>
                                    <div class="input-group" style="max-width: 300px;">
                                        <input type="number" name="price_points" class="form-control" placeholder="0" min="0" value="{{ old('price_points', 0) }}" required>
                                        <span class="input-group-text">điểm</span>
                                    </div>
                                    <div class="form-text">Đặt 0 nếu muốn cho miễn phí</div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bản quyền</a>
                            </label>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Sách của bạn sẽ được kiểm duyệt trong vòng 24-48 giờ trước khi hiển thị công khai.
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill">
                            <i class="bi bi-cloud-upload me-2"></i> Đăng sách
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
document.getElementById('bookFile').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        document.getElementById('fileName').textContent = e.target.files[0].name;
        document.getElementById('filePreview').style.display = 'block';
    }
});

function removeFile() {
    document.getElementById('bookFile').value = '';
    document.getElementById('filePreview').style.display = 'none';
}

document.getElementById('thumbnailFile').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('thumbnailPreview').src = e.target.result;
            document.getElementById('thumbnailPreview').style.display = 'block';
            document.getElementById('thumbnailPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush
