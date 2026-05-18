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
            <form action="{{ route('books.index') }}" method="GET" id="filterForm">
                <div class="row">
                    <!-- Sidebar Filters -->
                    <div class="col-lg-3">
                        <div class="filter-sidebar">
                            <!-- Search -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Tìm kiếm</h5>
                                    <div class="d-flex gap-2">
                                        <input type="text" name="q" class="form-control" placeholder="Tên sách, tác giả..." value="{{ request('q') }}">
                                        <button type="submit" class="btn btn-sm btn-primary flex-shrink-0"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Danh mục</h5>
                                    <div class="filter-section">
                                        <a href="{{ route('books.index') }}" class="d-block mb-2 text-decoration-none {{ !request('category') ? 'text-primary fw-bold' : 'text-muted' }}">
                                            Tất cả
                                        </a>
                                        @forelse($categories as $category)
                                            <a href="{{ route('books.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}" 
                                               class="d-block mb-2 text-decoration-none {{ request('category') == $category->slug ? 'text-primary fw-bold' : 'text-muted' }}">
                                                {{ $category->name }}
                                                <span class="badge bg-light text-dark ms-1">{{ $category->books_count ?? 0 }}</span>
                                            </a>
                                        @empty
                                            <p class="text-muted">Chưa có danh mục</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Tags</h5>
                                    <div class="filter-section">
                                        @forelse($tags as $tag)
                                            <a href="{{ route('books.index', array_merge(request()->except('tags'), ['tags' => $tag->slug])) }}" 
                                               class="badge {{ request('tags') == $tag->slug ? 'bg-primary' : 'bg-light text-dark' }} me-1 mb-1 text-decoration-none">
                                                {{ $tag->name }}
                                            </a>
                                        @empty
                                            <p class="text-muted">Chưa có tags</p>
                                        @endforelse
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
                                                <input type="number" name="min_price" class="form-control" placeholder="Từ" value="{{ request('min_price') }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="max_price" class="form-control" placeholder="Đến" value="{{ request('max_price') }}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">Áp dụng</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Đánh giá</h5>
                                    <div class="filter-section">
                                        @foreach([5, 4, 3, 2] as $rating)
                                            <a href="{{ route('books.index', array_merge(request()->except('rating'), ['rating' => $rating])) }}" 
                                               class="d-block mb-2 text-decoration-none {{ request('rating') == $rating ? 'text-primary fw-bold' : 'text-muted' }}">
                                                <span class="text-warning">
                                                    @for($i = 0; $i < $rating; $i++)★@endfor
                                                </span>
                                                {{ $rating }}+ sao
                                            </a>
                                        @endforeach
                                        @if(request('rating'))
                                            <a href="{{ route('books.index', request()->except('rating')) }}" class="text-danger small">
                                                Xóa bộ lọc
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-secondary w-100" onclick="window.location.href='{{ route('books.index') }}'">
                                <i class="bi bi-x-circle me-2"></i>Xóa bộ lọc
                            </button>
                        </div>
                    </div>

                    <!-- Book List -->
                    <div class="col-lg-9">
                        <!-- Active Filters -->
                        <div class="mb-3" id="activeFilters">
                            <div class="active-filters d-flex flex-wrap gap-2">
                                @if(request('q'))
                                    <span class="badge bg-primary">Tìm: {{ request('q') }}</span>
                                @endif
                                @if(request('category'))
                                    <span class="badge bg-primary">Danh mục: {{ request('category') }}</span>
                                @endif
                                @if(request('tags'))
                                    <span class="badge bg-primary">Tags: {{ request('tags') }}</span>
                                @endif
                                @if(request('rating'))
                                    <span class="badge bg-primary">Rating: {{ request('rating') }}+</span>
                                @endif
                            </div>
                        </div>

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1">Sách <span class="text-muted">({{ $books->total() }} kết quả)</span></h4>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <select name="sort" class="form-select form-select-sm" style="width: auto;" onchange="document.getElementById('filterForm').submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                                    <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Lượt tải</option>
                                </select>
                            </div>
                        </div>

                        <!-- Books Grid -->
                        <div class="row gy-4" id="booksGrid">
                            @forelse($books as $book)
                            <div class="col-md-4 col-6">
                                <div class="card book-card-grid border-0 shadow-sm h-100">
                                    <div class="position-relative">
                                        <a href="{{ route('books.show', $book->slug) }}">
                                            @if($book->thumbnail)
                                                <img src="{{ asset('storage/' . $book->thumbnail) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/300x200?text=No+Cover" class="card-img-top" alt="No Cover" style="height: 200px; object-fit: cover;">
                                            @endif
                                        </a>
                                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn" 
                                                onclick="toggleWishlist({{ $book->id }}, this)" 
                                                title="Thêm vào yêu thích">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        @if($book->category)
                                            <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">{{ $book->category->name }}</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            @foreach($book->tags->take(2) as $tag)
                                                <span class="badge bg-secondary me-1" style="font-size: 0.65rem;">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                        <h5 class="fw-bold mb-1 text-truncate" title="{{ $book->title }}">
                                            <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none text-dark">{{ $book->title }}</a>
                                        </h5>
                                        <p class="text-muted small mb-2">{{ $book->authors->first()?->name ?? 'N/A' }}</p>
                                        <div class="mb-2">
                                            @if($book->rating_avg > 0)
                                                <span class="text-warning small">
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
                                                <span class="text-muted small">({{ $book->rating_count }})</span>
                                            @else
                                                <span class="text-muted small">Chưa có đánh giá</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-orange fw-bold fs-5">{{ number_format($book->price_points) }} điểm</span>
                                            <button class="btn btn-sm btn-primary" onclick="addToCart({{ $book->id }})"><i class="bi bi-cart-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                                <h4 class="text-muted mt-3">Không tìm thấy sách nào</h4>
                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">Xem tất cả sách</a>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $books->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
}

function toggleWishlist(bookId, btn) {
    fetch('/wishlist/toggle', {
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
            if (data.is_favorited) {
                btn.classList.add('bg-danger', 'text-white');
            } else {
                btn.classList.remove('bg-danger', 'text-white');
            }
            alert(data.message);
        } else {
            alert(data.error || 'Vui lòng đăng nhập!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
}
</script>
@endpush
