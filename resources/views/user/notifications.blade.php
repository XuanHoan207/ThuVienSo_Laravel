@extends('user.component.layout')

@section('title', 'Thông Báo - Thư Viện Số')

@push('styles')
    @vite('resources/css/notifications.css')
@endpush

@push('scripts')
    @vite('resources/js/notifications.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thông báo</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Notifications Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0"><i class="bi bi-bell me-2 text-orange"></i>Thông Báo</h2>
                        @if($unreadCount > 0)
                        <button class="btn btn-outline-danger btn-sm" onclick="markAllAsRead()">
                            <i class="bi bi-check-all me-1"></i> Đánh dấu tất cả đã đọc
                        </button>
                        @endif
                    </div>

                    <!-- Filter Tabs -->
                    <div class="mb-4">
                        <a href="{{ route('notifications', ['type' => 'all']) }}" class="btn {{ !request('type') || request('type') == 'all' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                            <i class="bi bi-list me-1"></i> Tất cả
                        </a>
                        <a href="{{ route('notifications', ['type' => 'book_approved']) }}" class="btn {{ request('type') == 'book_approved' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                            <i class="bi bi-book me-1"></i> Sách
                        </a>
                        <a href="{{ route('notifications', ['type' => 'points_recharged']) }}" class="btn {{ request('type') == 'points_recharged' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                            <i class="bi bi-coin me-1"></i> Điểm
                        </a>
                        <a href="{{ route('notifications', ['type' => 'system']) }}" class="btn {{ request('type') == 'system' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-gear me-1"></i> Hệ thống
                        </a>
                    </div>

                    <!-- Notifications List -->
                    <div id="notificationsList">
                        @forelse($notifications as $notification)
                        <div class="card notification-card mb-3 {{ !$notification->is_read ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="notification-icon bg-{{ $notification->type === 'points_recharged' ? 'warning' : ($notification->type === 'book_approved' ? 'success' : ($notification->type === 'book_rejected' ? 'danger' : 'primary')) }} text-white me-3">
                                        <i class="bi {{ $notification->icon ?? 'bi-bell' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $notification->title }}</h6>
                                                <p class="text-muted small mb-1">{{ $notification->content ?? '' }}</p>
                                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</small>

                                                {{-- Hiển thị thông tin sách khi có data --}}
                                                @if($notification->data && isset($notification->data['book']))
                                                <div class="book-notification-card mt-3 p-3 bg-light rounded border">
                                                    <div class="d-flex align-items-center">
                                                        @if(isset($notification->data['book']['thumbnail']) && $notification->data['book']['thumbnail'])
                                                            <img src="{{ asset('storage/' . $notification->data['book']['thumbnail']) }}"
                                                                 alt="{{ $notification->data['book']['title'] ?? 'Sách' }}"
                                                                 class="rounded me-3 shadow-sm"
                                                                 style="width: 70px; height: 95px; object-fit: cover;">
                                                        @else
                                                            <div class="book-placeholder me-3 d-flex align-items-center justify-content-center bg-secondary text-white rounded shadow-sm"
                                                                 style="width: 70px; height: 95px;">
                                                                <i class="bi bi-book fs-3"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1 text-primary fw-bold">{{ $notification->data['book']['title'] ?? 'Không có tiêu đề' }}</h6>
                                                            @if(isset($notification->data['book']['authors']) && $notification->data['book']['authors'])
                                                                <p class="text-muted small mb-1">
                                                                    <i class="bi bi-person me-1"></i>{{ $notification->data['book']['authors'] }}
                                                                </p>
                                                            @endif
                                                            @if(isset($notification->data['book']['category']) && $notification->data['book']['category'])
                                                                <p class="text-muted small mb-0">
                                                                    <i class="bi bi-tag me-1"></i>{{ $notification->data['book']['category'] }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if(isset($notification->data['book']['status']))
                                                    <div class="mt-2">
                                                        @php
                                                            $statusConfig = [
                                                                'approved' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Đã duyệt'],
                                                                'rejected' => ['class' => 'danger', 'icon' => 'x-circle', 'text' => 'Bị từ chối'],
                                                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Đang chờ duyệt'],
                                                            ];
                                                            $status = $notification->data['book']['status'];
                                                            $statusInfo = $statusConfig[$status] ?? ['class' => 'secondary', 'icon' => 'info-circle', 'text' => ucfirst($status)];
                                                        @endphp
                                                        <span class="badge bg-{{ $statusInfo['class'] }}">
                                                            <i class="bi bi-{{ $statusInfo['icon'] }} me-1"></i>{{ $statusInfo['text'] }}
                                                        </span>
                                                    </div>
                                                    @endif
                                                    {{-- Link xem sách --}}
                                                    @if(isset($notification->data['book']['id']))
                                                    <div class="mt-2">
                                                        <a href="{{ route('books.show', $notification->data['book']['id']) }}"
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye me-1"></i>Xem sách
                                                        </a>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if($notification->link)
                                                        <li><a class="dropdown-item" href="{{ $notification->link }}"><i class="bi bi-eye me-2"></i>Xem</a></li>
                                                    @endif
                                                    @if($notification->data && isset($notification->data['book']['id']))
                                                        <li><a class="dropdown-item" href="{{ route('books.show', $notification->data['book']['id']) }}"><i class="bi bi-book me-2"></i>Xem sách</a></li>
                                                    @endif
                                                    @if(!$notification->is_read)
                                                        <li><a class="dropdown-item" href="#" onclick="markAsRead({{ $notification->id }}); return false;"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteNotification({{ $notification->id }}); return false;"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-bell text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">Không có thông báo nào</h4>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- User Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/60' }}"
                                     alt="Avatar" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around text-center">
                                <div>
                                    <h5 class="mb-0 text-orange">{{ number_format(Auth::user()->points) }}</h5>
                                    <small class="text-muted">Điểm</small>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ Auth::user()->purchases()->count() }}</h5>
                                    <small class="text-muted">Sách đã mua</small>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ Auth::user()->ratings()->count() }}</h5>
                                    <small class="text-muted">Đánh giá</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0"><i class="bi bi-lightning me-2 text-orange"></i>Truy cập nhanh</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ url('/my-account') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-person me-3 text-orange"></i> Tài khoản của tôi
                                </a>
                                <a href="{{ url('/recharge') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-wallet2 me-3 text-orange"></i> Nạp điểm
                                </a>
                                <a href="{{ url('/history') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-clock-history me-3 text-orange"></i> Lịch sử tải
                                </a>
                                <a href="{{ url('/upload-book') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-cloud-upload me-3 text-orange"></i> Đăng sách mới
                                </a>
                                <a href="{{ url('/wishlist') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bi bi-heart me-3 text-orange"></i> Sách yêu thích
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(id) {
    if (confirm('Bạn có chắc muốn xóa thông báo này?')) {
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
