@extends('user.component.layout')

@section('title', 'Chi Tiết Sách - Thư Viện Số')

@push('styles')
    @vite('resources/css/books-detail.css')
@endpush

@push('scripts')
    @vite('resources/js/books-detail.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Book Details Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Left: Book Image -->
                <div class="col-lg-4 mb-4">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800" 
                             alt="Lập trình Laravel" class="book-detail-img img-fluid w-100">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3">-20%</span>
                    </div>
                    <div class="d-flex gap-2 mt-3 justify-content-center">
                        <button class="btn btn-outline-danger" id="wishlistBtn" onclick="toggleWishlist()">
                            <i class="bi bi-heart"></i> Yêu thích
                        </button>
                        <button class="btn btn-outline-secondary" onclick="reportBook()">
                            <i class="bi bi-flag"></i> Báo cáo
                        </button>
                    </div>
                </div>

                <!-- Right: Book Info -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <span class="badge bg-primary me-2">CNTT</span>
                        <span class="badge bg-secondary me-2">Laravel</span>
                        <span class="badge bg-info text-dark">PHP</span>
                    </div>

                    <h1 class="fw-bold mb-2">Lập trình Laravel</h1>
                    
                    <p class="text-muted mb-2">
                        <span>Tác giả: </span>
                        <a href="{{ url('/author-detail') }}" class="text-decoration-none">Lê Hùng Sơn</a>
                    </p>

                    <!-- Rating -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="text-warning me-2" style="font-size: 1.2rem;">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </span>
                            <span class="fw-bold me-1">4.5</span>
                            <span class="text-muted">(245 đánh giá)</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ffcaa5 0%, #ffb088 100%);">
                        <div class="card-body text-dark">
                            <div class="row align-items-center">
                                <div class="col">
                                    <span class="fs-3 fw-bold">500 điểm</span>
                                    <span class="text-decoration-line-through ms-2 opacity-75">600 điểm</span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-orange rounded-pill px-4" id="addToCartBtn" onclick="addToCart()" style="background-color: #ff7043; border-color: #ff7043; color: white;">
                                        <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-eye text-primary fs-4"></i>
                                <p class="mb-0 mt-1"><strong>1.2k</strong></p>
                                <small class="text-muted">Lượt xem</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-download text-success fs-4"></i>
                                <p class="mb-0 mt-1"><strong>456</strong></p>
                                <small class="text-muted">Lượt tải</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-heart text-danger fs-4"></i>
                                <p class="mb-0 mt-1"><strong>89</strong></p>
                                <small class="text-muted">Yêu thích</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-calendar text-info fs-4"></i>
                                <p class="mb-0 mt-1"><strong>2025</strong></p>
                                <small class="text-muted">Năm XB</small>
                            </div>
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Thông tin sách</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>ISBN:</strong> 978-0123456789</p>
                                    <p class="mb-2"><strong>Nhà xuất bản:</strong> FPT Software</p>
                                    <p class="mb-2"><strong>Ngôn ngữ:</strong> Tiếng Việt</p>
                                    <p class="mb-2"><strong>Số trang:</strong> 320</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Định dạng:</strong> PDF, EPUB</p>
                                    <p class="mb-2"><strong>Dung lượng:</strong> 15.2 MB</p>
                                    <p class="mb-2"><strong>Ngày phát hành:</strong> 15/03/2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs tab-custom mt-5" id="bookTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">
                        <i class="bi bi-info-circle me-2"></i>Mô tả
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                        <i class="bi bi-star me-2"></i>Đánh giá (245)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button">
                        <i class="bi bi-chat-left-text me-2"></i>Bình luận
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="bookTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="desc" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">Giới thiệu sách</h4>
                            <p class="mb-3">
                                <strong>"Lập trình Laravel"</strong> là cuốn sách hướng dẫn chi tiết về framework PHP Laravel - 
                                một trong những framework PHP phổ biến nhất hiện nay.
                            </p>
                            <p class="mb-3">
                                Cuốn sách bao gồm các nội dung từ cơ bản đến nâng cao, giúp bạn:
                            </p>
                            <ul class="mb-3">
                                <li>Hiểu rõ kiến trúc and cách hoạt động của Laravel</li>
                                <li>Xây dựng ứng dụng web từ đơn giản đến phức tạp</li>
                                <li>Sử dụng Eloquent ORM để làm việc with database</li>
                                <li>Tạo API RESTful with Laravel</li>
                                <li>Triển khai ứng dụng Laravel lên production</li>
                            </ul>
                            <p class="mb-3">
                                Với phong cách viết dễ hiểu, có nhiều ví dụ thực tế and bài tập practical, 
                                cuốn sách này là tài liệu không thể thiếu cho bất kỳ ai muốn học Laravel.
                            </p>
                            <h5 class="fw-bold mt-4 mb-3">Mục lục</h5>
                            <div class="accordion" id="tocAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#toc1">
                                            Phần 1: Cơ bản về Laravel
                                        </button>
                                    </h2>
                                    <div id="toc1" class="accordion-collapse collapse show" data-bs-parent="#tocAccordion">
                                        <div class="accordion-body">
                                            <ul class="mb-0">
                                                <li>Chương 1: Giới thiệu Laravel</li>
                                                <li>Chương 2: Cài đặt and cấu hình</li>
                                                <li>Chương 3: Routing and Controller</li>
                                                <li>Chương 4: Blade Template Engine</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#toc2">
                                            Phần 2: Database and Eloquent
                                        </button>
                                    </h2>
                                    <div id="toc2" class="accordion-collapse collapse" data-bs-parent="#tocAccordion">
                                        <div class="accordion-body">
                                            <ul class="mb-0">
                                                <li>Chương 5: Database Migration</li>
                                                <li>Chương 6: Eloquent ORM</li>
                                                <li>Chương 7: Query Builder</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="row">
                        <!-- Rating Summary -->
                        <div class="col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center py-4">
                                    <h2 class="fw-bold text-warning mb-0">4.5</h2>
                                    <div class="text-warning mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <p class="text-muted mb-0">245 đánh giá</p>

                                    <hr>

                                    <div class="text-start">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">5</span><i class="bi bi-star-fill text-warning me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 70%;"></div>
                                            </div>
                                            <span class="ms-2 text-muted">70%</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">4</span><i class="bi bi-star-fill text-warning me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 20%;"></div>
                                            </div>
                                            <span class="ms-2 text-muted">20%</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">3</span><i class="bi bi-star-fill text-warning me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 5%;"></div>
                                            </div>
                                            <span class="ms-2 text-muted">5%</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">2</span><i class="bi bi-star-fill text-warning me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 3%;"></div>
                                            </div>
                                            <span class="ms-2 text-muted">3%</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">1</span><i class="bi bi-star-fill text-warning me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 2%;"></div>
                                            </div>
                                            <span class="ms-2 text-muted">2%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="col-lg-8">
                            <!-- Write Review -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Viết đánh giá của bạn</h5>
                                    <form id="reviewForm">
                                        <div class="mb-3">
                                            <label class="form-label">Xếp hạng của bạn</label>
                                            <div class="star-rating-input" id="ratingInput">
                                                <i class="bi bi-star" data-rating="1"></i>
                                                <i class="bi bi-star" data-rating="2"></i>
                                                <i class="bi bi-star" data-rating="3"></i>
                                                <i class="bi bi-star" data-rating="4"></i>
                                                <i class="bi bi-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá của bạn</label>
                                            <textarea class="form-control" rows="3" placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Review List -->
                            <div id="reviewsList">
                                <!-- Review 1 -->
                                <div class="card review-card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">Nguyễn Văn A</h6>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                            <span class="ms-auto text-muted small">15/05/2026</span>
                                        </div>
                                        <p class="mb-0">
                                            Cuốn sách rất hay and dễ hiểu! Tác giả trình bày logic từ cơ bản đến nâng cao, 
                                            giúp người đọc dễ dàng tiếp cận Laravel. Đặc biệt các ví dụ thực tế rất hữu ích.
                                        </p>
                                    </div>
                                </div>

                                <!-- Review 2 -->
                                <div class="card review-card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">Trần Thị B</h6>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <span class="ms-auto text-muted small">12/05/2026</span>
                                        </div>
                                        <p class="mb-0">
                                            Nội dung phong phú, có nhiều bài tập thực hành. Tuy nhiên phần về API hơi ngắn, 
                                            mong tác giả bổ sung thêm ở phiên bản sau.
                                        </p>
                                    </div>
                                </div>

                                <!-- Review 3 -->
                                <div class="card review-card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">Lê Minh C</h6>
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                            </div>
                                            <span class="ms-auto text-muted small">10/05/2026</span>
                                        </div>
                                        <p class="mb-0">
                                            Sách tốt cho người mới bắt đầu. Mình đã học được nhiều từ cuốn sách này 
                                            and giờ có thể tự xây dựng ứng dụng Laravel hoàn chỉnh.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-outline-primary w-100 mt-3" onclick="loadMoreReviews()">
                                Xem thêm đánh giá
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Comments Tab -->
                <div class="tab-pane fade" id="comments" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <!-- Comment Form -->
                            <div class="mb-4">
                                <form id="commentForm">
                                    <div class="d-flex gap-3">
                                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" 
                                             alt="" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <textarea class="form-control" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                                            <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <hr>

                            <!-- Comments List -->
                            <div id="commentsList">
                                <!-- Comment 1 -->
                                <div class="d-flex gap-3 mb-4">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" 
                                         alt="" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">Trần Thị B</h6>
                                                <small class="text-muted">15/05/2026 10:30</small>
                                            </div>
                                            <p class="mb-2">Cảm ơn tác giả đã viết cuốn sách này! Rất hữu ích cho người mới học Laravel.</p>
                                            <div class="d-flex gap-3">
                                                <a href="#" class="text-decoration-none small"><i class="bi bi-hand-thumbs-up me-1"></i> Thích (5)</a>
                                                <a href="#" class="text-decoration-none small"><i class="bi bi-reply me-1"></i> Trả lời</a>
                                            </div>
                                        </div>

                                        <!-- Reply -->
                                        <div class="d-flex gap-3 mt-3 ms-5">
                                            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <div class="bg-light p-3 rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">Lê Hùng Sơn (Tác giả)</h6>
                                                        <small class="text-muted">15/05/2026 11:00</small>
                                                    </div>
                                                    <p class="mb-2">Cảm ơn bạn đã đọc and đánh giá cao cuốn sách! Rất vui vì nó hữu ích cho bạn.</p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-decoration-none small"><i class="bi bi-hand-thumbs-up me-1"></i> Thích (3)</a>
                                                        <a href="#" class="text-decoration-none small"><i class="bi bi-reply me-1"></i> Trả lời</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comment 2 -->
                                <div class="d-flex gap-3 mb-4">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop" 
                                         alt="" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">Nguyễn Văn C</h6>
                                                <small class="text-muted">14/05/2026 16:45</small>
                                            </div>
                                            <p class="mb-2">Sách có bản PDF không? Mình muốn đọc trên tablet.</p>
                                            <div class="d-flex gap-3">
                                                <a href="#" class="text-decoration-none small"><i class="bi bi-hand-thumbs-up me-1"></i> Thích (2)</a>
                                                <a href="#" class="text-decoration-none small"><i class="bi bi-reply me-1"></i> Trả lời</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-outline-primary w-100 mt-3">
                                Xem thêm bình luận
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            <div class="mt-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-book me-2 text-orange"></i>Sách liên quan</h4>
                <div class="row gy-4">
                    <div class="col-md-3">
                        <a href="{{ url('/books-detail') }}" class="text-decoration-none">
                            <div class="card related-book-card border-0 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&h=300&fit=crop" 
                                     class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">Python Cơ Bản</h6>
                                    <p class="text-muted small mb-2">Lê Hùng Sơn</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold">400 điểm</span>
                                        <span class="text-warning small"><i class="bi bi-star-fill"></i> 4.3</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('/books-detail') }}" class="text-decoration-none">
                            <div class="card related-book-card border-0 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=300&fit=crop" 
                                     class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">JavaScript Nâng Cao</h6>
                                    <p class="text-muted small mb-2">Trần Đức Shins</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold">550 điểm</span>
                                        <span class="text-warning small"><i class="bi bi-star-fill"></i> 4.7</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('/books-detail') }}" class="text-decoration-none">
                            <div class="card related-book-card border-0 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?w=400&h=300&fit=crop" 
                                     class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">React Thực Chiến</h6>
                                    <p class="text-muted small mb-2">Vũ Đình Long</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold">600 điểm</span>
                                        <span class="text-warning small"><i class="bi bi-star-fill"></i> 4.8</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('/books-detail') }}" class="text-decoration-none">
                            <div class="card related-book-card border-0 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" 
                                     class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">Node.js Cơ Bản</h6>
                                    <p class="text-muted small mb-2">Lê Hùng Sơn</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold">450 điểm</span>
                                        <span class="text-warning small"><i class="bi bi-star-fill"></i> 4.5</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-flag me-2"></i>Báo cáo sách</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Loại vi phạm</label>
                        <select class="form-select">
                            <option value="">Chọn loại vi phạm</option>
                            <option value="copyright">Vi phạm bản quyền</option>
                            <option value="inappropriate">Nội dung không phù hợp</option>
                            <option value="broken_link">Link hỏng</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" rows="4" placeholder="Mô tả vấn đề của bạn..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" onclick="submitReport()">Gửi báo cáo</button>
                </div>
            </div>
        </div>
    </div>

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

