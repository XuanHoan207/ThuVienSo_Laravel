@extends('user.component.layout')

@section('title', $book->title . ' - Thư Viện Số')

@push('styles')
    @vite('resources/css/books-detail.css')
    <style>
        .rating-star-icon { font-size: 2rem; cursor: pointer; color: #e0e0e0; transition: all 0.2s ease; margin-right: 2px; }
        .rating-star-icon.active { color: #ffc107; filter: drop-shadow(0 0 3px rgba(255, 193, 7, 0.5)); }
        .rating-star-icon:hover { transform: scale(1.15); }
        .star-rating-wrapper { display: flex; align-items: center; gap: 10px; }
        .review-card { transition: all 0.3s ease; border-left: 3px solid #ffc107; }
        .review-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; transform: translateY(-2px); }
        .wishlist-btn { transition: all 0.3s ease; }
        .wishlist-btn:hover { transform: scale(1.05); }
        .wishlist-btn.active { background-color: #dc3545; color: white; border-color: #dc3545; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/books-detail.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
@endpush

@section('content')
    @include('user.component.header')

    <!-- Breadcrumb -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('books.index') }}" class="text-decoration-none">Sách</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Book Details Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Left: Book Image -->
                <div class="col-lg-4 mb-4">
                    <div class="position-relative">
                        @if($book->thumbnail)
                            <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="{{ $book->title }}" class="book-detail-img img-fluid w-100 rounded">
                        @else
                            <img src="https://via.placeholder.com/400x600?text=No+Cover" alt="No Cover" class="book-detail-img img-fluid w-100 rounded">
                        @endif
                        @if($book->price_points > 0)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3">PREMIUM</span>
                        @else
                            <span class="badge bg-success position-absolute top-0 start-0 m-3">FREE</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2 mt-3 justify-content-center">
                        <button class="btn {{ $hasFavorited ? 'btn-danger' : 'btn-outline-danger' }} flex-grow-1 wishlist-btn {{ $hasFavorited ? 'active' : '' }}" id="btn-favorite" data-id="{{ $book->id }}">
                            <i class="bi bi-heart{{ $hasFavorited ? '-fill' : '' }}"></i> {{ $hasFavorited ? 'Đã thích' : 'Yêu thích' }}
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="bi bi-flag"></i> Báo cáo
                        </button>
                    </div>
                    @if($book->price_points > 0)
                    <div class="mt-3 text-center">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#readOnlineModal">
                            <i class="bi bi-eye me-2"></i>Xem thử (5 trang miễn phí)
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Right: Book Info -->
                <div class="col-lg-8">
                    <!-- Categories & Tags -->
                    <div class="mb-3">
                        @if($book->category)
                            <span class="badge bg-primary me-2">{{ $book->category->name }}</span>
                        @endif
                        @if($book->file_type)
                            <span class="badge bg-secondary me-2">{{ strtoupper($book->file_type) }}</span>
                        @endif
                        @foreach($book->tags->take(3) as $tag)
                            <span class="badge" style="background-color: {{ $tag->color ?? '#6c757d' }};">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <h1 class="fw-bold mb-2">{{ $book->title }}</h1>
                    
                    <!-- Authors -->
                    <p class="text-muted mb-2">
                        <span>Tác giả: </span>
                        @foreach($book->authors as $author)
                            <a href="{{ route('authors.show', ['slug' => $author->slug]) }}" class="text-decoration-none">{{ $author->name }}</a>@if(!$loop->last), @endif
                        @endforeach
                    </p>

                    <!-- Rating -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="text-warning me-2" style="font-size: 1.2rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $book->rating_avg)
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i - 0.5 <= $book->rating_avg)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="fw-bold me-1">{{ number_format($book->rating_avg, 1) }}</span>
                            <span class="text-muted">({{ $book->rating_count }} đánh giá)</span>
                        </div>
                    </div>

                    <!-- Price Card -->
                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ffcaa5 0%, #ffb088 100%);">
                        <div class="card-body text-dark">
                            <div class="row align-items-center">
                                <div class="col">
                                    <span class="fs-3 fw-bold">{{ number_format($book->price_points) }} điểm</span>
                                    @if($book->price_points == 0)
                                        <span class="badge bg-success ms-2">MIỄN PHÍ</span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    @auth
                                        @if($hasPurchased || (isset($isUploader) && $isUploader))
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#readOnlineModal" style="background-color: #ff7043; border-color: #ff7043; color: white;">
                                                    <i class="bi bi-book-half me-2"></i>Đọc ngay
                                                </button>
                                                <a href="{{ route('books.download', $book->id) }}" class="btn btn-outline-dark rounded-pill px-4">
                                                    <i class="bi bi-download me-2"></i>Tải xuống
                                                </a>
                                            </div>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST" id="purchaseForm">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="btn btn-orange rounded-pill px-4" style="background-color: #ff7043; border-color: #ff7043; color: white;">
                                                    <i class="bi bi-cart-plus me-2"></i>Thêm vào Giỏ Hàng
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        @if($book->price_points == 0)
                                            <button type="button" class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#readOnlineModal" style="background-color: #ff7043; border-color: #ff7043; color: white;">
                                                <i class="bi bi-book-half me-2"></i>Đọc ngay (Miễn phí)
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4" style="background-color: #ff7043; border-color: #ff7043; color: white;">Đăng nhập để mua</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-eye text-primary fs-4"></i>
                                <p class="mb-0 mt-1"><strong>{{ number_format($book->view_count) }}</strong></p>
                                <small class="text-muted">Lượt xem</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-download text-success fs-4"></i>
                                <p class="mb-0 mt-1"><strong>{{ number_format($book->download_count) }}</strong></p>
                                <small class="text-muted">Lượt tải</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-heart text-danger fs-4"></i>
                                <p class="mb-0 mt-1" id="fav-count"><strong>{{ number_format($book->favorites()->where('status', 'active')->count()) }}</strong></p>
                                <small class="text-muted">Yêu thích</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="bi bi-calendar text-info fs-4"></i>
                                <p class="mb-0 mt-1"><strong>{{ $book->published_year ?? 'N/A' }}</strong></p>
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
                                    @if($book->isbn)
                                        <p class="mb-2"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                    @endif
                                    @if($book->publisher)
                                        <p class="mb-2"><strong>Nhà xuất bản:</strong> {{ $book->publisher->name }}</p>
                                    @endif
                                    <p class="mb-2"><strong>Ngôn ngữ:</strong> {{ $book->language ?? 'Tiếng Việt' }}</p>
                                    @if($book->pages)
                                        <p class="mb-2"><strong>Số trang:</strong> {{ $book->pages }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($book->file_type)
                                        <p class="mb-2"><strong>Định dạng:</strong> {{ strtoupper($book->file_type) }}</p>
                                    @endif
                                    @if($book->file_size)
                                        <p class="mb-2"><strong>Dung lượng:</strong> {{ $book->formatted_file_size }}</p>
                                    @endif
                                    @if($book->published_year)
                                        <p class="mb-2"><strong>Ngày phát hành:</strong> {{ $book->published_year }}</p>
                                    @endif
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
                        <i class="bi bi-star me-2"></i>Đánh giá & Bình luận ({{ $book->rating_count }})
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="bookTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="desc" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">Giới thiệu sách</h4>
                            <div class="book-description">
                                {{ $book->description ?: 'Chưa có mô tả chi tiết cho cuốn sách này.' }}
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
                                    <h2 class="fw-bold text-warning mb-0">{{ number_format($book->rating_avg, 1) }}</h2>
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($book->rating_avg) ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0">{{ $book->rating_count }} đánh giá</p>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="col-lg-8">
                            <!-- Write Review & Comment (Combined) -->
                            @auth
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">
                                            <i class="bi bi-star-fill text-warning me-2"></i>Đánh giá & Bình luận
                                        </h5>
                                        
                                        <!-- Star Rating -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Chọn số sao:</label>
                                            <div class="star-rating-wrapper">
                                                <div class="star-rating-input" id="starRatingContainer">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star rating-star-icon {{ ($userRating && $userRating->stars >= $i) ? 'active' : '' }}" data-rating="{{ $i }}"></i>
                                                    @endfor
                                                    <input type="hidden" name="stars" id="ratingValue" value="{{ $userRating ? $userRating->stars : '5' }}">
                                                </div>
                                                <span class="ms-3 text-muted" id="ratingText">Tuyệt vời</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Comment Input -->
                                        <form action="{{ route('books.review', $book->id) }}" method="POST" id="combinedForm">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="stars" id="formRatingValue" value="{{ $userRating ? $userRating->stars : '5' }}">
                                            <input type="hidden" name="comment" id="hiddenComment">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Viết bình luận của bạn:</label>
                                                <textarea id="commentInput" name="comment" class="form-control" rows="3" placeholder="Chia sẻ trải nghiệm của bạn về tài liệu này..." maxlength="1000">{{ $userRating ? $userRating->comment : '' }}</textarea>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <small class="text-muted"><span id="charCount">0</span>/1000 ký tự</small>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning fw-bold px-4" id="btnSubmitRating">
                                                <i class="bi bi-send me-2"></i>Gửi đánh giá
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info rounded-4 border-0 shadow-sm">
                                    <i class="bi bi-info-circle me-2"></i> Vui lòng <a href="{{ route('login') }}" class="fw-bold">đăng nhập</a> để gửi đánh giá và bình luận.
                                </div>
                            @endauth

                            <!-- Review List -->
                            <div id="reviewsList">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-chat-left-text me-2"></i>Danh sách đánh giá ({{ $book->rating_count }})
                                </h5>
                                @forelse($book->ratings->take(10) as $rating)
                                    <div class="card review-card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
                                                <img src="{{ $rating->user->avatar ? asset('storage/' . $rating->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($rating->user->name ?? 'User') . '&background=random&color=fff' }}" 
                                                     alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $rating->user->name ?? 'Người dùng' }}</h6>
                                                    <div class="text-warning small">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="bi bi-star{{ $i <= $rating->stars ? '-fill' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <span class="ms-auto text-muted small">{{ $rating->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <p class="mb-0 text-dark" style="line-height: 1.6;">
                                                {{ $rating->comment ?: 'Người dùng không viết bình luận.' }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-book me-2 text-orange"></i>Sách liên quan</h4>
                <div class="row gy-4">
                    @foreach($relatedBooks as $related)
                    <div class="col-md-3 col-6">
                        <a href="{{ route('books.show', $related->slug) }}" class="text-decoration-none">
                            <div class="card related-book-card border-0 shadow-sm">
                                @if($related->thumbnail)
                                    <img src="{{ asset('storage/' . $related->thumbnail) }}" class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x180?text=No+Cover" class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1 text-truncate">{{ $related->title }}</h6>
                                    <p class="text-muted small mb-2">{{ $related->authors->first()?->name ?? 'N/A' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-orange fw-bold">{{ number_format($related->price_points) }} đ</span>
                                        @if($related->rating_avg > 0)
                                            <span class="text-warning small"><i class="bi bi-star-fill"></i> {{ number_format($related->rating_avg, 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Reader Modal -->
    <div class="modal fade" id="readOnlineModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: #1a1a2e;">
                <div class="modal-header border-0 py-2" style="background: #16213e;">
                    <h6 class="modal-title text-white mb-0">
                        <i class="bi bi-book me-2"></i>{{ $book->title }}
                        @if(!$hasPurchased && !(isset($isUploader) && $isUploader))
                            <span class="badge bg-warning text-dark ms-2">XEM THỬ</span>
                        @endif
                    </h6>
                    <div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body p-0" style="height: calc(100vh - 60px);">
                    <iframe id="previewIframe" src="{{ route('books.preview', $book->slug) }}?t={{ ($hasPurchased || (isset($isUploader) && $isUploader)) ? 'full' : 'preview' }}&page=1"
                            width="100%" height="100%" style="border: none; display: block;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-flag me-2"></i>Báo cáo tài liệu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reportForm">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Loại vi phạm</label>
                            <select name="type" class="form-select border-light bg-light">
                                <option value="">Chọn loại vi phạm</option>
                                <option value="copyright">Vi phạm bản quyền</option>
                                <option value="content">Nội dung không phù hợp</option>
                                <option value="broken">Link hỏng/Lỗi file</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Mô tả</label>
                            <textarea name="reason" class="form-control border-light bg-light" rows="4" placeholder="Chi tiết vấn đề..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Gửi báo cáo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới và ưu đãi hấp dẫn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite Button
    const favBtn = document.getElementById('btn-favorite');
    const favCount = document.getElementById('fav-count');
    
    if(favBtn) {
        favBtn.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ book_id: id })
                });
                
                if(response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                
                const data = await response.json();
                console.log('Wishlist response:', data);
                
                if(data.success) {
                    if(data.is_favorited) {
                        this.innerHTML = '<i class="bi bi-heart-fill"></i> Đã thích';
                        this.classList.remove('btn-outline-danger');
                        this.classList.add('btn-danger', 'active');
                    } else {
                        this.innerHTML = '<i class="bi bi-heart"></i> Yêu thích';
                        this.classList.remove('btn-danger', 'active');
                        this.classList.add('btn-outline-danger');
                    }
                    
                    if (favCount && data.count !== undefined) {
                        favCount.innerHTML = `<strong>${data.count}</strong>`;
                    }
                } else {
                    alert(data.error || 'Vui lòng đăng nhập!');
                }
            } catch(e) {
                console.error('Wishlist error:', e);
                alert('Có lỗi xảy ra!');
            }
        });
    }

    // Rating Star with Hover Effects
    const stars = document.querySelectorAll('.rating-star-icon');
    const ratingInput = document.getElementById('ratingValue');
    const ratingText = document.getElementById('ratingText');
    const ratingLabels = ['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Tuyệt vời'];

    function updateStars(rating) {
        stars.forEach(s => {
            const starValue = parseInt(s.dataset.rating);
            if (starValue <= rating) {
                s.classList.add('active');
                s.style.color = '#ffc107';
                s.style.transform = 'scale(1.2)';
            } else {
                s.classList.remove('active');
                s.style.color = '#ccc';
                s.style.transform = 'scale(1)';
            }
        });
        if (ratingText) {
            ratingText.textContent = ratingLabels[rating] || '';
        }
        if (ratingInput) ratingInput.value = rating;
        const formRating = document.getElementById('formRatingValue');
        if (formRating) formRating.value = rating;
    }

    if (ratingInput) {
        updateStars(parseInt(ratingInput.value));
    }

    stars.forEach(star => {
        star.style.cursor = 'pointer';
        star.style.transition = 'all 0.2s ease';
        star.style.transformOrigin = 'center';

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.rating);
                if (starValue <= rating) {
                    s.classList.add('active');
                    s.style.color = '#ffc107';
                    s.style.transform = 'scale(1.2)';
                }
            });
            if (ratingText) {
                ratingText.textContent = ratingLabels[rating];
            }
        });

        star.addEventListener('mouseleave', function() {
            updateStars(parseInt(ratingInput?.value || 5));
        });

        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            updateStars(rating);
        });
    });

    // Combined Form Submit
    const combinedForm = document.getElementById('combinedForm');
    if (combinedForm) {
        const commentInput = document.getElementById('commentInput');
        const hiddenComment = document.getElementById('hiddenComment');

        combinedForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (hiddenComment) {
                hiddenComment.value = commentInput.value;
            }
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Cảm ơn bạn đã đánh giá!');
                    location.reload();
                } else {
                    alert(data.error || 'Có lỗi xảy ra!');
                }
            });
        });
    }

    // Comment Character Count
    const commentInput = document.getElementById('commentInput');
    const charCount = document.getElementById('charCount');
    if (commentInput && charCount) {
        charCount.textContent = commentInput.value.length;
        commentInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Report Form
    document.getElementById('reportForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('{{ route('books.report', $book->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cảm ơn phản hồi của bạn!');
                bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
            } else {
                alert(data.error || 'Có lỗi xảy ra!');
            }
        });
    });

});
</script>
@endpush


