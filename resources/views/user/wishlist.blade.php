@extends('user.component.layout')

@section('title', 'Sách Yêu Thích - Thư Viện Số')

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yêu thích</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Wishlist Section -->
    <section class="container py-5">
        <h2 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>Sách Yêu Thích</h2>
        
        @if($favorites->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($favorites as $favorite)
            @if($favorite->book && $favorite->book->status === 'approved')
            <div class="col">
                <div class="book-card card border-0 shadow-sm p-2 h-100">
                    <div class="position-relative">
                        <a href="{{ route('books.show', $favorite->book->slug) }}">
                            @if($favorite->book->thumbnail)
                                <img src="{{ asset('storage/' . $favorite->book->thumbnail) }}" class="card-img-top" alt="{{ $favorite->book->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Cover" class="card-img-top" alt="No Cover" style="height: 200px; object-fit: cover;">
                            @endif
                        </a>
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" onclick="removeFromWishlist({{ $favorite->book->id }})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1 text-truncate" title="{{ $favorite->book->title }}">{{ $favorite->book->title }}</h6>
                        <p class="text-muted small mb-1">{{ $favorite->book->authors->first()?->name ?? 'N/A' }}</p>
                        @if($favorite->book->rating_avg > 0)
                        <div class="text-warning small mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $favorite->book->rating_avg)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                            <span class="text-muted">({{ $favorite->book->rating_count }})</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-orange fw-bold">{{ number_format($favorite->book->price_points) }} điểm</span>
                            <button class="btn btn-sm btn-primary" onclick="addToCart({{ $favorite->book->id }})"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Chưa có sách yêu thích</h4>
            <p class="text-muted">Hãy thêm sách vào danh sách yêu thích để xem lại sau.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">Khám phá sách</a>
        </div>
        @endif
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
function removeFromWishlist(bookId) {
    if (confirm('Bạn có chắc muốn xóa khỏi yêu thích?')) {
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
                location.reload();
            }
        });
    }
}

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
        alert(data.message);
        location.reload();
    });
}
</script>
@endpush
