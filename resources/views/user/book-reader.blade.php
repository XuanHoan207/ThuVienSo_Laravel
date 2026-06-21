@extends('user.component.layout')

@section('title', 'Đọc sách - ' . $book->title . ' - Thư Viện Số')

@push('styles')
    <style>
        .reader-container {
            max-width: 100%;
            margin: 0;
            padding: 0;
            background: #1a1a2e;
            min-height: 100vh;
        }
        .reader-header {
            background: #16213e;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .reader-book-cover {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
        }
        .reader-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
            padding: 20px;
            min-height: calc(100vh - 150px);
        }
        .reader-book-page {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            max-width: 800px;
            width: 100%;
            line-height: 1.8;
            font-size: 16px;
        }
        .reader-footer {
            background: #16213e;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);
        }
        .btn-nav {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-nav:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .btn-nav:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .page-info {
            background: rgba(255,255,255,0.1);
            padding: 8px 16px;
            border-radius: 20px;
        }
    </style>
@endpush

@section('content')
    @include('user.component.header')
    
    <div class="reader-container">
        <div class="reader-header">
            <div class="d-flex align-items-center gap-3">
                @if($book->thumbnail)
                    <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="" class="reader-book-cover">
                @endif
                <div>
                    <h5 class="mb-1">{{ $book->title }}</h5>
                    <small class="text-white-50">
                        @if($book->authors && $book->authors->count() > 0)
                            @foreach($book->authors as $author)
                                {{ $author->name }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            Không rõ tác giả
                        @endif
                    </small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <span class="page-info" id="pageIndicator">Trang {{ $currentPage }} / {{ $book->pages ?? '?' }}</span>
                <a href="{{ route('books.show', $book->slug) }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="reader-content">
            <div class="reader-book-page" id="bookContent">
                <h5 class="mb-4 text-center">Trang {{ $currentPage }}</h5>
                <div class="book-content" style="text-align: justify;">
                    <p style="text-indent: 2em;">
                        Nội dung trang {{ $currentPage }}. Đây là nội dung mẫu của cuốn sách. 
                        Bạn có thể thấy cách bố cục và kiểu chữ được hiển thị trong trình đọc sách.
                    </p>
                </div>
            </div>
        </div>

        <div class="reader-footer">
            <button class="btn-nav" id="prevBtn" onclick="changePage(-1)" {{ $currentPage <= 1 ? 'disabled' : '' }}>
                <i class="bi bi-chevron-left"></i> Trang trước
            </button>
            <div class="text-center">
                <span class="fw-bold" id="readingProgressText">{{ round(($currentPage / ($book->pages ?? 1)) * 100) }}% đã đọc</span>
            </div>
            <button class="btn-nav" id="nextBtn" onclick="changePage(1)" {{ $currentPage >= $maxAllowedPage ? 'disabled' : '' }}>
                Trang sau <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
let currentPage = {{ $currentPage }};
const totalPages = {{ $book->pages ?? 0 }};
const maxAllowedPage = {{ $maxAllowedPage }};
const bookId = {{ $book->id }};
const bookSlug = "{{ $book->slug }}";

function changePage(direction) {
    const newPage = currentPage + direction;
    if (newPage >= 1 && newPage <= maxAllowedPage) {
        updatePage(newPage);
    }
}

function updatePage(page) {
    document.getElementById('bookContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Đang tải trang ${page}...</p>
        </div>
    `;
    
    fetch(`/books/${bookSlug}/read/page?page=${page}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('bookContent').innerHTML = `
                    <h5 class="mb-4 text-center">Trang ${data.page}</h5>
                    <div class="book-content" style="text-align: justify;">
                        <p style="text-indent: 2em;">
                            Nội dung trang ${data.page}. Đây là nội dung của cuốn sách.
                        </p>
                    </div>
                `;
                
                document.getElementById('pageIndicator').textContent = `Trang ${data.page} / ${totalPages}`;
                document.getElementById('prevBtn').disabled = data.page <= 1;
                document.getElementById('nextBtn').disabled = data.page >= data.max_allowed_page;
                document.getElementById('readingProgressText').textContent = `${Math.round((data.page / totalPages) * 100)}% đã đọc`;
                
                currentPage = data.page;
            }
        });
    
    // Save progress
    fetch(`/books/${bookSlug}/read/progress`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ page: page })
    });
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') changePage(-1);
    if (e.key === 'ArrowRight') changePage(1);
});
</script>
@endpush
@include('user.Chatbot.chatbot')

