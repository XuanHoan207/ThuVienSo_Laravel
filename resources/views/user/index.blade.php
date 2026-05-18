@extends('user.component.layout')

@section('title', 'Trang Chủ - Thư Viện Số')

@section('content')
    @include('user.component.header')

    <!-- Slider Section -->
    @if(isset($sliders) && $sliders->count() > 0)
    <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $key => $slider)
                <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $key => $slider)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <a href="{{ $slider->link ?? '#' }}">
                        <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->title }}" style="height: 400px; object-fit: cover;">
                    </a>
                    @if($slider->title)
                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 10px; padding: 20px;">
                        <h3 class="fw-bold">{{ $slider->title }}</h3>
                        @if($slider->subtitle)
                            <p>{{ $slider->subtitle }}</p>
                        @endif
                        @if($slider->link_text)
                            <a href="{{ $slider->link ?? '#' }}" class="btn btn-primary rounded-pill">{{ $slider->link_text }}</a>
                        @endif
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @else
    <!-- Default Banner -->
    <div class="bg-primary py-5 text-center text-white">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Chào mừng đến với Thư Viện Số</h1>
            <p class="lead mb-4">Khám phá hàng ngàn cuốn sách hay từ mọi thể loại</p>
            <a href="{{ url('/books') }}" class="btn btn-light btn-lg rounded-pill px-4">Khám phá ngay</a>
        </div>
    </div>
    @endif

    <!-- Top Categories Section -->
    <section class="categories-section py-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h6 class="text-uppercase text-orange fw-semibold mb-1">Danh mục</h6>
                    <h2 class="fw-bold text-dark">Khám phá các danh mục hàng đầu</h2>
                </div>
                <a href="{{ url('/books') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">Xem tất cả →</a>
            </div>
            <div class="row g-4">
                @forelse($categories as $category)
                <div class="col-md-4">
                    <a href="{{ route('books.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="category-card text-center p-3 h-100 border rounded-3 shadow-sm hover-shadow transition-all">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid rounded mb-3" alt="{{ $category->name }}" style="height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <i class="bi bi-book text-orange" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <h5 class="fw-semibold mb-2 text-dark">{{ $category->name }}</h5>
                            <p class="text-muted small mb-0">{{ $category->books_count ?? 0 }} sách</p>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Chưa có danh mục nào.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- eBook Section -->
    <section class="ebook-section py-5" style="background: linear-gradient(135deg, #fff4ec 0%, #fff 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h6 class="text-uppercase text-orange fw-semibold mb-2">eBook</h6>
                    <h2 class="fw-bold text-dark mb-3">
                        Truy cập, Đọc, Thực hành & Tương tác <br>
                        với nội dung số (eBook)
                    </h2>
                    <p class="text-muted mb-4">
                        Trải nghiệm đọc sách hiện đại với hàng ngàn đầu sách số đa dạng thể loại, dễ dàng truy cập mọi lúc mọi nơi.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ url('/books') }}" class="btn btn-primary rounded-pill px-4 py-2">Khám phá ngay</a>
                        <a href="{{ url('/register') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">Đăng ký miễn phí</a>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800" alt="Person with Books" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- New Release Section -->
    @if($newBooks->count() > 0)
    <section class="new-release-section py-5">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="text-uppercase text-orange fw-semibold mb-1">Mới nhất</h6>
                    <h2 class="fw-bold text-dark">Sách mới phát hành</h2>
                </div>
                <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="btn btn-outline-primary rounded-pill">Xem thêm →</a>
            </div>
            <div class="book-carousel-wrapper overflow-hidden position-relative">
                <div class="book-carousel d-flex transition-all" style="gap: 1rem;">
                    @foreach($newBooks as $book)
                    <div class="book-card card border-0 shadow-sm flex-shrink-0" style="width: 200px;">
                        <a href="{{ route('books.show', $book->slug) }}">
                            @if($book->thumbnail)
                                <img src="{{ asset('storage/' . $book->thumbnail) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/200x250?text=No+Cover" class="card-img-top" alt="No Cover" style="height: 250px; object-fit: cover;">
                            @endif
                        </a>
                        <div class="card-body">
                            <h6 class="fw-bold mb-1 text-truncate" title="{{ $book->title }}">{{ $book->title }}</h6>
                            <p class="text-muted small mb-1">{{ $book->authors->first()?->name ?? 'N/A' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-orange fw-bold">{{ number_format($book->price_points) }} điểm</span>
                                @if($book->rating_avg > 0)
                                    <span class="text-warning small"><i class="bi bi-star-fill"></i> {{ number_format($book->rating_avg, 1) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Books Section -->
    @if($featuredBooks->count() > 0)
    <section class="featured-section py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="text-uppercase text-orange fw-semibold mb-1">Nổi bật</h6>
                    <h2 class="fw-bold text-dark">Sách được đánh giá cao</h2>
                </div>
                <a href="{{ route('books.index', ['sort' => 'rating']) }}" class="btn btn-outline-primary rounded-pill">Xem thêm →</a>
            </div>
            <div class="row g-4">
                @foreach($featuredBooks->take(4) as $book)
                <div class="col-md-3 col-6">
                    <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none">
                        <div class="card book-card-grid border-0 shadow-sm h-100">
                            <div class="position-relative">
                                @if($book->thumbnail)
                                    <img src="{{ asset('storage/' . $book->thumbnail) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Cover" class="card-img-top" alt="No Cover" style="height: 200px; object-fit: cover;">
                                @endif
                                @if($book->category)
                                    <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">{{ $book->category->name }}</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h6 class="fw-bold mb-1 text-truncate" title="{{ $book->title }}">{{ $book->title }}</h6>
                                <p class="text-muted small mb-2">{{ $book->authors->first()?->name ?? 'N/A' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-orange fw-bold">{{ number_format($book->price_points) }} điểm</span>
                                    @if($book->rating_avg > 0)
                                        <span class="text-warning small"><i class="bi bi-star-fill"></i> {{ number_format($book->rating_avg, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Top Downloaded Section -->
    @if($topDownloadedBooks->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="text-uppercase text-orange fw-semibold mb-1">Hot</h6>
                    <h2 class="fw-bold text-dark">Sách được tải nhiều nhất</h2>
                </div>
                <a href="{{ route('books.index', ['sort' => 'downloads']) }}" class="btn btn-outline-primary rounded-pill">Xem thêm →</a>
            </div>
            <div class="row g-4">
                @foreach($topDownloadedBooks->take(4) as $book)
                <div class="col-md-3 col-6">
                    <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="row g-0 align-items-center">
                                <div class="col-4">
                                    @if($book->thumbnail)
                                        <img src="{{ asset('storage/' . $book->thumbnail) }}" class="img-fluid rounded-start" alt="{{ $book->title }}" style="height: 100px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/100?text=No" class="img-fluid rounded-start" alt="No Cover" style="height: 100px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.9rem;">{{ $book->title }}</h6>
                                        <p class="text-muted small mb-1">{{ $book->authors->first()?->name ?? 'N/A' }}</p>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-orange fw-bold" style="font-size: 0.85rem;">{{ number_format($book->price_points) }} đ</span>
                                            <span class="text-muted small"><i class="bi bi-download"></i> {{ number_format($book->download_count) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Trending Tags Section -->
    @if($trendingTags->count() > 0)
    <section class="py-4 bg-light">
        <div class="container">
            <h6 class="text-uppercase text-orange fw-semibold mb-3">Tags trending</h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach($trendingTags as $tag)
                    <a href="{{ route('books.index', ['tags' => $tag->slug]) }}" class="badge rounded-pill px-3 py-2 text-decoration-none" style="background-color: {{ $tag->color ?? '#ED553B' }}; color: white;">
                        {{ $tag->name }}
                        <span class="badge bg-light text-dark ms-1">{{ $tag->books_count ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Offer Section -->
    <section class="offer-section container py-5">
        <div class="row align-items-center" style="background: linear-gradient(135deg, #ff7043 0%, #ff8d4c 100%); border-radius: 20px; padding: 40px; color: white;">
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">Tất cả sách đang giảm giá 50%! Đừng bỏ lỡ!</h2>
                <p class="mb-4 opacity-75">Cơ hội duy nhất trong năm để sở hữu những cuốn sách giá trị với mức giá cực kỳ ưu đãi.</p>
                <a href="{{ url('/books') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold">Mua ngay</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/Unsplash.png') }}" alt="Books" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng ký nhận bản tin của chúng tôi</h3>
        <p>Nhận những cập nhật mới nhất về sách và khuyến mãi trực tiếp qua email của bạn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập địa chỉ email của bạn tại đây">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    @include('user.component.footer')
@endsection
