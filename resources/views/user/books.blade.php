@extends('user.component.layout')

@section('title', 'Danh Sách Sách - Thư Viện Số')

@push('styles')
    @vite('resources/css/books.css')
@endpush

@push('scripts')
    @vite('resources/js/books.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sách</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Books Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <!-- Search -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Tìm kiếm</h5>
                                <form class="d-flex gap-2">
                                    <input type="text" class="form-control" placeholder="Tên sách, tác giả...">
                                    <button type="submit" class="btn btn-sm btn-primary flex-shrink-0"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Danh mục</h5>
                                <div class="filter-section">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="checkbox" value="" id="catAll" checked>
                                        <label class="form-check-label" for="catAll">Tất cả</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="checkbox" value="cntt" id="catCNTT">
                                        <label class="form-check-label" for="catCNTT">CNTT</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="checkbox" value="khoahoc" id="catKhoaHoc">
                                        <label class="form-check-label" for="catKhoaHoc">Khoa học</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="checkbox" value="kinhte" id="catKinhTe">
                                        <label class="form-check-label" for="catKinhTe">Kinh tế</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="checkbox" value="vanhoc" id="catVanHoc">
                                        <label class="form-check-label" for="catVanHoc">Văn học</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input category-filter" type="checkbox" value="kynangsong" id="catKyNang">
                                        <label class="form-check-label" for="catKyNang">Kỹ năng sống</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Tags</h5>
                                <div class="filter-section">
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Laravel</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">PHP</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">JavaScript</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Python</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">AI</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Machine Learning</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Business</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Marketing</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Tiểu thuyết</span>
                                    <span class="tag-badge bg-light text-dark" onclick="toggleTag(this)">Kỹ năng sống</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Khoảng giá</h5>
                                <div class="filter-section">
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <input type="number" class="form-control" placeholder="Từ" id="priceFrom">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control" placeholder="Đến" id="priceTo">
                                        </div>
                                    </div>
                                    <input type="range" class="form-range" min="0" max="2000" step="50" id="priceRange">
                                    <div class="d-flex justify-content-between">
                                        <small>0 điểm</small>
                                        <small>2000+ điểm</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Tác giả</h5>
                                <div class="filter-section">
                                    <select class="form-select">
                                        <option>Tất cả tác giả</option>
                                        <option>Nguyễn Nhật Ánh</option>
                                        <option>Trần Đức Shins</option>
                                        <option>Lê Hùng Sơn</option>
                                        <option>Vũ Đình Long</option>
                                        <option>Phạm Thị Vân</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Đánh giá</h5>
                                <div class="filter-section">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rate5" value="5">
                                        <label class="form-check-label" for="rate5">
                                            <span class="text-warning">★★★★★</span> 5 sao
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rate4" value="4">
                                        <label class="form-check-label" for="rate4">
                                            <span class="text-warning">★★★★☆</span> 4+ sao
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rate3" value="3">
                                        <label class="form-check-label" for="rate3">
                                            <span class="text-warning">★★★☆☆</span> 3+ sao
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rating" id="rateAll" value="0" checked>
                                        <label class="form-check-label" for="rateAll">Tất cả</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                            <i class="bi bi-x-circle me-2"></i>Xóa bộ lọc
                        </button>
                    </div>
                </div>

                <!-- Book List -->
                <div class="col-lg-9">
                    <!-- Active Filters -->
                    <div class="mb-3" id="activeFilters">
                        <div class="active-filters">
                            <!-- Dynamic filter tags will appear here -->
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">Sách (<span id="bookCount">24</span>)</h4>
                            <small class="text-muted">Tìm thấy 24 kết quả</small>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <select class="form-select form-select-sm" style="width: auto;" id="sortSelect">
                                <option value="newest">Mới nhất</option>
                                <option value="popular">Phổ biến nhất</option>
                                <option value="rating">Đánh giá cao</option>
                                <option value="price-low">Giá: Thấp đến cao</option>
                                <option value="price-high">Giá: Cao đến thấp</option>
                            </select>
                            <div class="btn-group">
                                <button class="view-toggle active" onclick="setView('grid', this)" title="Lưới">
                                    <i class="bi bi-grid"></i>
                                </button>
                                <button class="view-toggle" onclick="setView('list', this)" title="Danh sách">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Books Grid -->
                    <div class="row gy-4" id="booksGrid">
                        <!-- Book 1 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Lập trình Laravel" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">CNTT</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">Laravel</span>
                                        <span class="badge bg-info text-dark me-1" style="font-size: 0.7rem;">PHP</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Lập trình Laravel</a></h5>
                                    <p class="text-muted small mb-2">Lê Hùng Sơn</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★★</span>
                                        <span class="text-muted small">(245)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">500 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book 2 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Machine Learning" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-success position-absolute bottom-0 start-0 m-2">Khoa học</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">AI</span>
                                        <span class="badge bg-warning text-dark me-1" style="font-size: 0.7rem;">ML</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Machine Learning Cơ Bản</a></h5>
                                    <p class="text-muted small mb-2">Vũ Đình Long</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★☆</span>
                                        <span class="text-muted small">(189)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">750 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book 3 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Mắt Biếc" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-info position-absolute bottom-0 start-0 m-2">Văn học</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">Tiểu thuyết</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Mắt Biếc</a></h5>
                                    <p class="text-muted small mb-2">Nguyễn Nhật Ánh</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★★</span>
                                        <span class="text-muted small">(512)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">500 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book 4 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Kỹ năng sống" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-warning text-dark position-absolute bottom-0 start-0 m-2">Kỹ năng</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">Self-help</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Đắc Nhân Tâm</a></h5>
                                    <p class="text-muted small mb-2">Dale Carnegie</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★★</span>
                                        <span class="text-muted small">(1.2k)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">350 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book 5 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Marketing" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-danger position-absolute bottom-0 start-0 m-2">Kinh tế</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">Marketing</span>
                                        <span class="badge bg-info text-dark me-1" style="font-size: 0.7rem;">Business</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Marketing 4.0</a></h5>
                                    <p class="text-muted small mb-2">Philip Kotler</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★☆</span>
                                        <span class="text-muted small">(356)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">600 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book 6 -->
                        <div class="col-md-4">
                            <div class="card book-card-grid border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <a href="{{ url('/books-detail') }}">
                                        <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=300&fit=crop" 
                                             class="card-img-top" alt="Python" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle quick-view-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                    <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">CNTT</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-1" style="font-size: 0.7rem;">Python</span>
                                    </div>
                                    <h5 class="fw-bold mb-1"><a href="{{ url('/books-detail') }}" class="text-decoration-none text-dark">Python Cơ Bản</a></h5>
                                    <p class="text-muted small mb-2">Lê Hùng Sơn</p>
                                    <div class="mb-2">
                                        <span class="text-warning small">★★★★☆</span>
                                        <span class="text-muted small">(198)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold fs-5">400 điểm</span>
                                        <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Trước</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới and ưu đãi hấp dẫn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    <!-- Footer -->
    @include('user.component.footer')
@endsection

