@extends('admin.component-admin.layout')

@section('title', 'Quản lý Sách - Admin Thư Viện Số')

@push('styles')
    @vite('resources/css/admin/books.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/books.js')
@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý Sách</h1>
            <p class="text-muted mb-0">Quản lý tất cả sách trong hệ thống</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Thêm sách mới
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.books.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Tìm kiếm sách..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="category">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
                            <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="sort">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá cao - thấp</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá thấp - cao</option>
                            <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Lượt xem</option>
                            <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Lượt tải</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel me-2"></i>Lọc
                            </button>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary" title="Xóa lọc">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Books Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </th>
                                <th width="80">Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Tác giả</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Lượt xem</th>
                                <th width="180">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books ?? [] as $book)
                                <tr>
                                    <td><input class="form-check-input book-checkbox" type="checkbox" name="book_ids[]" value="{{ $book->id }}"></td>
                                    <td>
                                        <img src="{{ $book->thumbnail
                                            ? asset('storage/' . $book->thumbnail)
                                            : 'https://via.placeholder.com/50x60?text=No+Image' }}"
                                             alt="" class="rounded"
                                             style="width: 50px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($book->title, 40) }}</strong>
                                        <br>
                                        <small class="text-muted">ISBN: {{ $book->isbn ?? 'N/A' }}</small>
                                        <br>
                                        <small class="text-muted">Ngày tạo: {{ $book->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        @forelse($book->authors ?? [] as $author)
                                            <span class="badge bg-secondary mb-1">{{ $author->name }}</span>
                                        @empty
                                            <span class="text-muted">N/A</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $book->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td><strong>{{ number_format($book->price_points) }} điểm</strong></td>
                                    <td>
                                        @switch($book->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Đã duyệt</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Bị từ chối</span>
                                                @break
                                            @case('hidden')
                                                <span class="badge bg-secondary">Ẩn</span>
                                                @break
                                            @default
                                                <span class="badge bg-dark">{{ $book->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <i class="bi bi-eye text-muted"></i> {{ number_format($book->view_count) }}
                                        <br>
                                        <i class="bi bi-download text-muted"></i> {{ number_format($book->download_count) }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-outline-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn btn-outline-info" title="Xem">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($book->status === 'pending')
                                                <form action="{{ route('admin.books.approve', $book->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-success" title="Duyệt">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.books.reject', $book->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-danger" title="Từ chối">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-outline-danger" title="Xóa"
                                                    onclick="confirmDelete('{{ route('admin.books.destroy', $book->id) }}', 'sách này')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <i class="bi bi-book fs-3 d-block mb-2"></i>
                                        Không có sách nào được tìm thấy
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">
                        Hiển thị {{ ($books->currentPage() - 1) * $books->perPage() + 1 }}-{{ min($books->currentPage() * $books->perPage(), $books->total()) }}
                        của {{ $books->total() }} kết quả
                    </span>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $books->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->previousPageUrl() }}">Trước</a>
                        </li>
                        @for($i = 1; $i <= $books->lastPage(); $i++)
                            <li class="page-item {{ $books->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $books->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $books->nextPageUrl() }}">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    const bookCheckboxes = document.querySelectorAll('.book-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            bookCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Delete confirmation
    window.confirmDelete = function(url, itemName) {
        if (confirm('Bạn có chắc chắn muốn xóa ' + itemName + ' không?')) {
            if (document.getElementById('bulkActionForm')) {
                document.getElementById('bulkActionForm').action = url;
                document.getElementById('bulkActionForm').submit();
            } else {
                // Direct delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }
    };
});
</script>
@endpush
