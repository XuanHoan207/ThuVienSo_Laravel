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
                    <p class="text-center text-muted mb-4">Chia sẻ kiến thức của bạn with cộng đồng độc giả</p>

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <span class="step-label">Thông tin</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step" data-step="2">
                            <div class="step-number">2</div>
                            <span class="step-label">Tải lên</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step" data-step="3">
                            <div class="step-number">3</div>
                            <span class="step-label">Hoàn tất</span>
                        </div>
                    </div>

                    <form id="uploadForm">
                        <!-- Step 1: Basic Info -->
                        <div class="form-step active" data-step="1">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-orange"></i>Thông tin cơ bản</h5>
                                    
                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tiêu đề sách <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Nhập tiêu đề sách" required>
                                    </div>

                                    <!-- ISBN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">ISBN</label>
                                        <input type="text" class="form-control" placeholder="Mã số ISBN (nếu có)">
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Mô tả <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" placeholder="Mô tả nội dung sách..." required></textarea>
                                    </div>

                                    <!-- Category -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                                            <select class="form-select" required>
                                                <option value="">Chọn danh mục</option>
                                                <option>Công nghệ thông tin</option>
                                                <option>Khoa học</option>
                                                <option>Kinh tế</option>
                                                <option>Văn học</option>
                                                <option>Kỹ năng sống</option>
                                                <option>Giáo dục</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Nhà xuất bản</label>
                                            <input type="text" class="form-control" placeholder="Tên nhà xuất bản">
                                        </div>
                                    </div>

                                    <!-- Tags -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tags</label>
                                        <div class="tag-input" id="tagInput">
                                            <span class="tag">Laravel <i class="bi bi-x"></i></span>
                                            <span class="tag">PHP <i class="bi bi-x"></i></span>
                                            <input type="text" placeholder="Nhấn Enter để thêm tag...">
                                        </div>
                                        <small class="text-muted">Gợi ý: Laravel, PHP, JavaScript, Python, AI...</small>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                            Tiếp theo <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Upload Files -->
                        <div class="form-step" data-step="2">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-file-earmark-arrow-up me-2 text-orange"></i>Tải lên tệp</h5>

                                    <!-- Authors (Multiple) -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Tác giả <span class="text-danger">*</span></label>
                                        <div class="author-list" id="authorList">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" placeholder="Tên tác giả">
                                                <select class="form-select" style="max-width: 150px;">
                                                    <option value="author">Tác giả</option>
                                                    <option value="co-author">Đồng tác giả</option>
                                                    <option value="translator">Dịch giả</option>
                                                    <option value="editor">Biên tập</option>
                                                </select>
                                                <button type="button" class="btn btn-outline-danger" onclick="removeAuthor(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addAuthor()">
                                            <i class="bi bi-plus"></i> Thêm tác giả khác
                                        </button>
                                    </div>

                                    <!-- Book File Upload -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">File sách <span class="text-danger">*</span></label>
                                        <div class="upload-area" id="fileDropZone">
                                            <i class="bi bi-cloud-arrow-up display-4 text-orange mb-3"></i>
                                            <h5>Kéo thả file vào đây hoặc click để chọn</h5>
                                            <p class="text-muted mb-2">Hỗ trợ: PDF, EPUB, MOBI (Tối đa 50MB)</p>
                                            <input type="file" id="bookFile" accept=".pdf,.epub,.mobi" style="display: none;" required>
                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('bookFile').click()">
                                                Chọn file
                                            </button>
                                        </div>
                                        <div id="filePreview" class="mt-2" style="display: none;">
                                            <div class="d-flex align-items-center p-2 bg-light rounded">
                                                <i class="bi bi-file-earmark-pdf text-danger me-2 fs-4"></i>
                                                <div class="flex-grow-1">
                                                    <strong id="fileName">document.pdf</strong>
                                                    <br><small class="text-muted" id="fileSize">2.5 MB</small>
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
                                            <input type="file" id="thumbnailFile" accept="image/*" style="display: none;">
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
                                            <input type="number" class="form-control" placeholder="0" min="0" value="0" required>
                                            <span class="input-group-text">điểm</span>
                                        </div>
                                        <div class="form-text">Đặt 0 nếu muốn cho miễn phí</div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep(1)">
                                            <i class="bi bi-arrow-left me-2"></i> Quay lại
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                            Tiếp theo <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Preview & Submit -->
                        <div class="form-step" data-step="3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-check-circle me-2 text-orange"></i>Xem lại & Hoàn tất</h5>

                                    <div class="row">
                                        <div class="col-md-4 text-center mb-4">
                                            <img src="https://via.placeholder.com/200x280?text=Book+Cover" 
                                                 alt="Book Cover" class="img-fluid rounded shadow" id="previewThumbnail">
                                            <p class="mt-2 text-muted small">Ảnh bìa sách</p>
                                        </div>
                                        <div class="col-md-8">
                                            <h4 id="previewTitle">Tiêu đề sách</h4>
                                            <p class="text-muted" id="previewCategory">Danh mục: ---</p>
                                            
                                            <div class="mb-2">
                                                <span class="badge bg-primary me-1" id="previewTag1">Laravel</span>
                                                <span class="badge bg-info text-dark me-1" id="previewTag2">PHP</span>
                                            </div>

                                            <p id="previewDescription" class="mb-3">
                                                Mô tả sách sẽ hiển thị ở đây...
                                            </p>

                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">Giá:</small>
                                                    <h5 class="text-orange mb-0" id="previewPrice">0 điểm</h5>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">File:</small>
                                                    <p class="mb-0" id="previewFile">Chưa chọn file</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Tác giả:</small>
                                                    <p class="mb-0" id="previewAuthors">---</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Trạng thái:</small>
                                                    <p class="mb-0"><span class="badge bg-warning text-dark">Chờ duyệt</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            Tôi đồng ý with <a href="#">Điều khoản sử dụng</a> and <a href="#">Chính sách bản quyền</a>
                                        </label>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Sách của bạn sẽ được kiểm duyệt trong vòng 24-48 giờ trước khi hiển thị công khai.
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep(2)">
                                            <i class="bi bi-arrow-left me-2"></i> Quay lại
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-cloud-upload me-2"></i> Đăng sách
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('user.component.footer')
@endsection

