@extends('user.component.layout')

@section('title', 'Chi Tiết Tác Giả - Thư Viện Số')

@push('styles')
    @vite('resources/css/author-detail.css')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Author Cover -->
    <div class="author-cover"></div>

    <!-- Author Profile Section -->
    <section class="py-4">
        <div class="container">
            <div class="row author-profile">
                <div class="col-md-3 text-center text-md-start">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop" 
                         alt="Nguyễn Nhật Ánh" class="author-avatar-large mb-3">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-1">Nguyễn Nhật Ánh</h2>
                    <p class="text-muted mb-2"><i class="bi bi-pen me-2"></i>Tác giả văn học</p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <span class="badge bg-primary"><i class="bi bi-book me-1"></i> 12 sách</span>
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> 4.8/5 (1.2k đánh giá)</span>
                        <span class="badge bg-success"><i class="bi bi-eye me-1"></i> 500k lượt xem</span>
                    </div>

                    <div class="author-social mb-3">
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-globe"></i> Website</a>
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-facebook"></i> Facebook</a>
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-envelope"></i> Email</a>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary rounded-pill"><i class="bi bi-plus-circle me-2"></i>Theo dõi</button>
                        <a href="#books" class="btn btn-outline-primary rounded-pill"><i class="bi bi-book me-2"></i>Xem sách</a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="col-md-3">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">12</h3>
                                <small class="text-muted">Sách</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">50k</h3>
                                <small class="text-muted">Người theo dõi</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">500k</h3>
                                <small class="text-muted">Lượt đọc</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">4.8</h3>
                                <small class="text-muted">Đánh giá TB</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Author Bio Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-3"><i class="bi bi-person-badge me-2 text-orange"></i>Giới thiệu về tác giả</h4>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="mb-3">
                                <strong>Nguyễn Nhật Ánh</strong> là một trong những nhà văn nổi tiếng nhất Việt Nam, 
                                được biết đến with những tác phẩm về tuổi thơ, tình bạn and tình yêu đầu đời.
                            </p>
                            <p class="mb-3">
                                Ông sinh ngày 21 tháng 5 năm 1955 tại TP. Hồ Chí Minh. Tốt nghiệp Đại học Sư phạm 
                                TP. Hồ Chí Minh and từng là giáo viên tiểu học trước khi chuyển hẳn sang viết văn.
                            </p>
                            <p class="mb-0">
                                Với phong cách viết giản dị, gần gũi and đầy cảm xúc, Nguyễn Nhật Ánh đã chinh phục 
                                hàng triệu độc giả mọi lứa tuổi. Các tác phẩm của ông thường xoay quanh cuộc sống 
                                học đường, những mối quan hệ gia đình and bạn bè.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="bi bi-tags me-2 text-orange"></i>Thể loại viết</h4>
                    <div class="tags-container">
                        <span class="badge bg-primary">Văn học</span>
                        <span class="badge bg-info text-dark">Truyện ngắn</span>
                        <span class="badge bg-success">Tiểu thuyết</span>
                        <span class="badge bg-warning text-dark">Tình cảm</span>
                        <span class="badge bg-secondary">Tuổi teen</span>
                        <span class="badge bg-danger">Gia đình</span>
                    </div>

                    <h4 class="fw-bold mb-3 mt-4"><i class="bi bi-award me-2 text-orange"></i>Giải thưởng</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-trophy text-warning me-3"></i>
                            Giải thưởng Văn học TP.HCM
                        </li>
                        <li class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-trophy text-warning me-3"></i>
                            Top 10 sách được đọc nhiều nhất
                        </li>
                        <li class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-trophy text-warning me-3"></i>
                            Tác phẩm được yêu thích nhất 2025
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Author's Books Section -->
    <section class="py-5" id="books">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-book me-2 text-orange"></i>Sách của Nguyễn Nhật Ánh</h4>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Mới nhất</option>
                        <option>Phổ biến nhất</option>
                        <option>Đánh giá cao</option>
                        <option>Giá: Thấp đến cao</option>
                        <option>Giá: Cao đến thấp</option>
                    </select>
                </div>
            </div>

            <div class="row gy-4">
                <!-- Book 1 -->
                <div class="col-md-6">
                    <div class="book-card-horizontal bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=300&fit=crop" 
                             alt="Mắt biếc">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">Mắt Biếc</h5>
                                    <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>Nguyễn Nhật Ánh</p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Văn học</span>
                                <span class="badge bg-secondary me-1">Tiểu thuyết</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.9</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Một câu chuyện cảm động về tình bạn and tình yêu tuổi học trò...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-orange fw-bold fs-5">500 điểm</span>
                                    <small class="text-muted text-decoration-line-through ms-2">600 điểm</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="col-md-6">
                    <div class="book-card-horizontal bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=200&h=300&fit=crop" 
                             alt="Cho tôi xin một vé đi tuổi thơ">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">Cho Tôi Xin Một Vé Đi Tuổi Thơ</h5>
                                    <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>Nguyễn Nhật Ánh</p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Văn học</span>
                                <span class="badge bg-secondary me-1">Ký ức</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.8</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Những kỷ niệm tuổi thơ đẹp đẽ được tái hiện qua từng trang sách...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-orange fw-bold fs-5">450 điểm</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="col-md-6">
                    <div class="book-card-horizontal bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=200&h=300&fit=crop" 
                             alt="Tôi thấy hoa vàng trên cỏ xanh">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">Tôi Thấy Hoa Vàng Trên Cỏ Xanh</h5>
                                    <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>Nguyễn Nhật Ánh</p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Văn học</span>
                                <span class="badge bg-secondary me-1">Truyện</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.9</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Câu chuyện về những ngày hè đầy ắp tiếng cười and kỷ niệm...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-orange fw-bold fs-5">550 điểm</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="col-md-6">
                    <div class="book-card-horizontal bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=200&h=300&fit=crop" 
                             alt="Hai Số Phận">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">Hai Số Phận</h5>
                                    <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>Nguyễn Nhật Ánh</p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Văn học</span>
                                <span class="badge bg-secondary me-1">Drama</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.7</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Hai con người with hai số phận khác nhau, một câu chuyện về tình bạn...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-orange fw-bold fs-5">480 điểm</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    <button class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Trước</a>
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
    </section>

    <!-- Related Authors -->
    <section class="py-4 bg-light">
        <div class="container">
            <h4 class="fw-bold mb-4"><i class="bi bi-people me-2 text-orange"></i>Tác giả liên quan</h4>
            <div class="row gy-3">
                <div class="col-md-3">
                    <a href="{{ url('/author-detail') }}" class="text-decoration-none">
                        <div class="d-flex align-items-center p-2 rounded" style="background: white;">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop" 
                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 text-dark">Trần Đức Shins</h6>
                                <small class="text-muted">8 sách</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/author-detail') }}" class="text-decoration-none">
                        <div class="d-flex align-items-center p-2 rounded" style="background: white;">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=60&h=60&fit=crop" 
                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 text-dark">Phạm Thị Vân</h6>
                                <small class="text-muted">5 sách</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/author-detail') }}" class="text-decoration-none">
                        <div class="d-flex align-items-center p-2 rounded" style="background: white;">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=60&h=60&fit=crop" 
                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 text-dark">Lê Hùng Sơn</h6>
                                <small class="text-muted">15 sách</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/author-detail') }}" class="text-decoration-none">
                        <div class="d-flex align-items-center p-2 rounded" style="background: white;">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" 
                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 text-dark">Vũ Đình Long</h6>
                                <small class="text-muted">9 sách</small>
                            </div>
                        </div>
                    </a>
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

