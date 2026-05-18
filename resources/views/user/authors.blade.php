@extends('user.component.layout')

@section('title', 'Tác Giả - Thư Viện Số')

@push('styles')
    @vite('resources/css/authors.css')
@endpush

@push('scripts')
    @vite('resources/js/authors.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tác giả</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Authors Section -->
    <section class="py-5">
        <div class="container">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="fw-bold text-dark">Danh Sách Tác Giả</h2>
                    <p class="text-muted">Khám phá các tác giả nổi tiếng và những tác phẩm của họ</p>
                </div>
                <div class="col-md-6">
                    <form class="d-flex gap-2" action="{{ route('authors.index') }}" method="GET">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tác giả..." value="{{ request('search') }}">
                        <select name="letter" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="all">Tất cả</option>
                            @foreach(range('A', 'Z') as $letter)
                                <option value="{{ $letter }}" {{ request('letter') == $letter ? 'selected' : '' }}>{{ $letter }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <!-- Authors Grid -->
            <div class="row gy-4" id="authorsGrid">
                @forelse($authors as $author)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('authors.show', $author->slug) }}" class="text-decoration-none">
                        <div class="card author-card border-0 shadow-sm h-100 hover-shadow transition-all">
                            <div class="card-body text-center p-4">
                                @if($author->image)
                                    <img src="{{ asset('storage/' . $author->image) }}" alt="{{ $author->name }}" class="author-avatar mb-3 rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="author-avatar mb-3 rounded-circle d-inline-flex align-items-center justify-content-center bg-light" style="width: 100px; height: 100px;">
                                        <i class="bi bi-person text-orange" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <h5 class="fw-bold mb-1 text-dark">{{ $author->name }}</h5>
                                <div class="d-flex justify-content-center gap-2 mb-2">
                                    <span class="badge bg-primary">{{ $author->authored_books_count ?? 0 }} sách</span>
                                    @if(($author->avg_rating ?? 0) > 0)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ number_format($author->avg_rating ?? 0, 1) }}</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-3">{{ Str::limit($author->bio, 80) }}</p>
                                <span class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Không tìm thấy tác giả nào</h4>
                    <p class="text-muted">Thử thay đổi từ khóa tìm kiếm</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $authors->withQueryString()->links() }}
            </div>
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
