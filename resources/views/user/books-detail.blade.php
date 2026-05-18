@extends('user.component.layout')

@section('title', $book->title . ' - Thư Viện Số')

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
                        @if($book->thumbnail)
                            <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="{{ $book->title }}" class="book-detail-img img-fluid w-100 rounded">
                        @else
                            <img src="https://via.placeholder.com/400x600?text=No+Cover" alt="No Cover" class="book-detail-img img-fluid w-100 rounded">
                        @endif
                        @if($book->rating_avg >= 4.5)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3">Hot</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2 mt-3 justify-content-center">
                        <button class="btn {{ $hasFavorited ? 'btn-danger' : 'btn-outline-danger' }}" id="wishlistBtn" onclick="toggleWishlist()">
                            <i class="bi bi-heart"></i> {{ $hasFavorited ? 'Đã yêu thích' : 'Yêu thích' }}
                        </button>
                        <button class="btn btn-outline-secondary" onclick="openReportModal()">
                            <i class="bi bi-flag"></i> Báo cáo
                        </button>
                    </div>
                </div>

                <!-- Right: Book Info -->
                <div class="col-lg-8">
                    <!-- Categories & Tags -->
                    <div class="mb-3">
                        @if($book->category)
                            <span class="badge bg-primary me-2">{{ $book->category->name }}</span>
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
                            <a href="{{ route('authors.show', $author->slug) }}" class="text-decoration-none">{{ $author->name }}</a>@if(!$loop->last), @endif
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
                                    @if($book->price_points > 0)
                                        <span class="text-decoration-line-through ms-2 opacity-75">Miễn phí</span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    @if($hasPurchased)
                                        <a href="{{ route('books.download', $book->id) }}" class="btn btn-success rounded-pill px-4">
                                            <i class="bi bi-download me-2"></i>Tải sách
                                        </a>
                                    @else
                                        <button class="btn btn-orange rounded-pill px-4" onclick="addToCart()" style="background-color: #ff7043; border-color: #ff7043; color: white;">
                                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                                        </button>
                                    @endif
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
                                <p class="mb-0 mt-1"><strong>{{ number_format($book->favorites()->count()) }}</strong></p>
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
                        <i class="bi bi-star me-2"></i>Đánh giá ({{ $book->rating_count }})
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
                            <div class="book-description">
                                {!! nl2br(e($book->description)) !!}
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
                                            @if($i <= $book->rating_avg)
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i - 0.5 <= $book->rating_avg)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0">{{ $book->rating_count }} đánh giá</p>

                                    <hr>

                                    <div class="text-start">
                                        @for($star = 5; $star >= 1; $star--)
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-2">{{ $star }}</span>
                                                <i class="bi bi-star-fill text-warning me-2"></i>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: {{ $ratingDistribution[$star]['percentage'] }}%;"></div>
                                                </div>
                                                <span class="ms-2 text-muted">{{ $ratingDistribution[$star]['percentage'] }}%</span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="col-lg-8">
                            <!-- Write Review -->
                            @auth
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Viết đánh giá của bạn</h5>
                                    @if($userRating)
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>Bạn đã đánh giá cuốn sách này {{ $userRating->stars }} sao.
                                        </div>
                                    @else
                                        <form id="reviewForm">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <div class="mb-3">
                                                <label class="form-label">Xếp hạng của bạn</label>
                                                <div class="star-rating-input" id="ratingInput">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star" data-rating="{{ $i }}" onclick="setRating({{ $i }})"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="stars" id="selectedRating" value="">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Đánh giá của bạn</label>
                                                <textarea name="comment" class="form-control" rows="3" placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @endauth

                            <!-- Review List -->
                            <div id="reviewsList">
                                @forelse($book->ratings->take(10) as $rating)
                                <div class="card review-card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex mb-2">
                                            <img src="{{ $rating->user->avatar ? asset('storage/' . $rating->user->avatar) : 'https://via.placeholder.com/50' }}" 
                                                 alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $rating->user->name ?? 'Người dùng' }}</h6>
                                                <div class="text-warning small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $rating->stars)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="ms-auto text-muted small">{{ $rating->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0">{{ $rating->comment ?? '' }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Tab -->
                <div class="tab-pane fade" id="comments" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <!-- Comment Form -->
                            @auth
                            <div class="mb-4">
                                <form id="commentForm">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <div class="d-flex gap-3">
                                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://via.placeholder.com/50' }}" 
                                             alt="" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                                            <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="alert alert-info mb-4">
                                <a href="{{ route('login') }}">Đăng nhập</a> để viết bình luận.
                            </div>
                            @endauth

                            <hr>

                            <!-- Comments List -->
                            <div id="commentsList">
                                @forelse($comments as $comment)
                                <div class="d-flex gap-3 mb-4">
                                    <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://via.placeholder.com/50' }}" 
                                         alt="" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">{{ $comment->user->name ?? 'Người dùng' }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-2">{{ $comment->content }}</p>
                                            @auth
                                            <div class="d-flex gap-3">
                                                <a href="#" class="text-decoration-none small"><i class="bi bi-hand-thumbs-up me-1"></i> Thích</a>
                                                <a href="#" class="text-decoration-none small" onclick="showReplyForm({{ $comment->id }}); return false;"><i class="bi bi-reply me-1"></i> Trả lời</a>
                                            </div>
                                            @endauth
                                        </div>

                                        <!-- Replies -->
                                        @forelse($comment->approvedReplies as $reply)
                                        <div class="d-flex gap-3 mt-3 ms-5">
                                            <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : 'https://via.placeholder.com/40' }}" 
                                                 alt="" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <div class="bg-light p-3 rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">{{ $reply->user->name ?? 'Người dùng' }}</h6>
                                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-muted">Chưa có bình luận nào.</p>
                                </div>
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

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-flag me-2"></i>Báo cáo sách</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reportForm">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Loại vi phạm</label>
                            <select name="type" class="form-select" required>
                                <option value="">Chọn loại vi phạm</option>
                                <option value="copyright">Vi phạm bản quyền</option>
                                <option value="inappropriate">Nội dung không phù hợp</option>
                                <option value="broken_link">Link hỏng</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="reason" class="form-control" rows="4" placeholder="Mô tả vấn đề của bạn..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Gửi báo cáo</button>
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
let selectedRating = 0;

function setRating(rating) {
    selectedRating = rating;
    document.getElementById('selectedRating').value = rating;
    const stars = document.querySelectorAll('#ratingInput i');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('text-warning');
        } else {
            star.classList.remove('text-warning');
        }
    });
}

function addToCart() {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ book_id: {{ $book->id }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Có lỗi xảy ra!');
        }
    });
}

function toggleWishlist() {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ book_id: {{ $book->id }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('wishlistBtn');
            if (data.is_favorited) {
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
                btn.innerHTML = '<i class="bi bi-heart"></i> Đã yêu thích';
            } else {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
                btn.innerHTML = '<i class="bi bi-heart"></i> Yêu thích';
            }
            alert(data.message);
        } else {
            alert(data.error || 'Vui lòng đăng nhập!');
        }
    });
}

function openReportModal() {
    new bootstrap.Modal(document.getElementById('reportModal')).show();
}

// Review Form
document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    if (selectedRating === 0) {
        alert('Vui lòng chọn số sao đánh giá!');
        return;
    }
    
    const formData = new FormData(this);
    formData.set('stars', selectedRating);
    
    fetch('{{ route('books.review', $book->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Có lỗi xảy ra!');
        }
    });
});

// Comment Form
document.getElementById('commentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('{{ route('books.comment', $book->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Có lỗi xảy ra!');
        }
    });
});

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
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
        } else {
            alert(data.error || 'Có lỗi xảy ra!');
        }
    });
});
</script>
@endpush
