@extends('user.component.layout')

@section('title', $author->name . ' - Thư Viện Số')

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
                    @if($author->image)
                        <img src="{{ asset('storage/' . $author->image) }}" alt="{{ $author->name }}" class="author-avatar-large mb-3 rounded-circle">
                    @else
                        <div class="author-avatar-large mb-3 rounded-circle d-inline-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-person text-orange" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-1">{{ $author->name }}</h2>
                    <p class="text-muted mb-2">
                        @if($author->website)
                            <a href="{{ $author->website }}" target="_blank" class="text-muted text-decoration-none">
                                <i class="bi bi-globe me-2"></i>Website
                            </a>
                        @endif
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <span class="badge bg-primary"><i class="bi bi-book me-1"></i> {{ $totalBooks }} sách</span>
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> {{ number_format($avgRating, 1) }}/5 ({{ $totalBooks }} đánh giá)</span>
                        <span class="badge bg-success"><i class="bi bi-eye me-1"></i> {{ number_format($totalViews) }} lượt xem</span>
                    </div>

                    @if($author->email)
                        <div class="author-social mb-3">
                            <a href="mailto:{{ $author->email }}" class="text-decoration-none me-3"><i class="bi bi-envelope"></i> {{ $author->email }}</a>
                        </div>
                    @endif

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
                                <h3 class="fw-bold text-orange mb-1">{{ $totalBooks }}</h3>
                                <small class="text-muted">Sách</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">{{ number_format($totalViews) }}</h3>
                                <small class="text-muted">Lượt xem</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">{{ number_format($avgRating, 1) }}</h3>
                                <small class="text-muted">Đánh giá TB</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-light p-3 text-center">
                                <h3 class="fw-bold text-orange mb-1">{{ number_format($author->created_at->diffInDays()) }}</h3>
                                <small class="text-muted">Ngày tham gia</small>
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
                            <p class="mb-3">{{ $author->bio ?? 'Chưa có thông tin giới thiệu.' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if($author->website)
                        <h4 class="fw-bold mb-3"><i class="bi bi-link me-2 text-orange"></i>Liên kết</h4>
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <a href="{{ $author->website }}" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-globe me-2"></i>{{ $author->website }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Author's Books Section -->
    <section class="py-5" id="books">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-book me-2 text-orange"></i>Sách của {{ $author->name }}</h4>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href='?sort=' + this.value">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                    </select>
                </div>
            </div>

            @if($books->count() > 0)
            <div class="row gy-4">
                @foreach($books as $book)
                <div class="col-md-6">
                    <div class="book-card-horizontal bg-white shadow-sm rounded">
                        <a href="{{ route('books.show', $book->slug) }}">
                            @if($book->thumbnail)
                                <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="{{ $book->title }}" style="width: 120px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/120x160?text=No" alt="No Cover" style="width: 120px; object-fit: cover;">
                            @endif
                        </a>
                        <div class="flex-grow-1 p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none text-dark">
                                        <h5 class="fw-bold mb-1">{{ $book->title }}</h5>
                                    </a>
                                    @if($book->category)
                                        <p class="text-muted small mb-2"><i class="bi bi-folder me-1"></i>{{ $book->category->name }}</p>
                                    @endif
                                </div>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="mb-2">
                                @if($book->rating_avg > 0)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ number_format($book->rating_avg, 1) }}</span>
                                @endif
                                @foreach($book->tags->take(2) as $tag)
                                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <p class="text-muted small mb-2">{{ Str::limit($book->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-orange fw-bold fs-5">{{ number_format($book->price_points) }} điểm</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('books.show', $book->slug) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    <button class="btn btn-sm btn-primary" onclick="addToCart({{ $book->id }})"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Tác giả chưa có sách nào</h4>
            </div>
            @endif
        </div>
    </section>

    <!-- Related Authors -->
    @if($relatedAuthors->count() > 0)
    <section class="py-4 bg-light">
        <div class="container">
            <h4 class="fw-bold mb-4"><i class="bi bi-people me-2 text-orange"></i>Tác giả liên quan</h4>
            <div class="row gy-3">
                @foreach($relatedAuthors as $related)
                <div class="col-md-3 col-6">
                    <a href="{{ route('authors.show', $related->slug) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center p-2 rounded bg-white shadow-sm hover-shadow transition-all">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle me-3 bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 text-dark">{{ $related->name }}</h6>
                                <small class="text-muted">{{ $related->authored_books_count ?? 0 }} sách</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
function addToCart(bookId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ book_id: bookId })
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
</script>
@endpush
