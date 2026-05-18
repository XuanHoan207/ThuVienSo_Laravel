@extends('user.component.layout')

@section('title', 'Lịch Sử Hoạt Động - Thư Viện Số')

@push('styles')
    @vite('resources/css/history.css')
@endpush

@push('scripts')
    @vite('resources/js/history.js')
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
                    <li class="breadcrumb-item active" aria-current="page">Lịch sử</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- History Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-orange"></i>Lịch Sử Hoạt Động</h2>

                    <!-- Filter Tabs -->
                    <div class="filter-tabs mb-4">
                        <a href="{{ route('history', ['type' => 'all']) }}" class="btn {{ !request('type') || request('type') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-list me-1"></i> Tất cả
                        </a>
                        <a href="{{ route('history', ['type' => 'purchase']) }}" class="btn {{ request('type') == 'purchase' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-bag me-1"></i> Mua sách
                        </a>
                        <a href="{{ route('history', ['type' => 'points']) }}" class="btn {{ request('type') == 'points' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-coin me-1"></i> Điểm
                        </a>
                        <a href="{{ route('history', ['type' => 'download']) }}" class="btn {{ request('type') == 'download' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-download me-1"></i> Tải về
                        </a>
                        <a href="{{ route('history', ['type' => 'upload']) }}" class="btn {{ request('type') == 'upload' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-cloud-upload me-1"></i> Đăng sách
                        </a>
                    </div>

                    <!-- History List -->
                    <div id="historyList">
                        @forelse($history as $item)
                        <div class="card history-card mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        @if($item['type'] === 'purchase')
                                            <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                                                <i class="bi bi-bag" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @elseif($item['type'] === 'points')
                                            <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                                                <i class="bi bi-wallet2" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @elseif($item['type'] === 'download')
                                            <div class="bg-info bg-opacity-10 text-info rounded p-3">
                                                <i class="bi bi-download" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @elseif($item['type'] === 'upload')
                                            <div class="bg-success bg-opacity-10 text-success rounded p-3">
                                                <i class="bi bi-cloud-upload" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @else
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded p-3">
                                                <i class="bi bi-activity" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">{{ $item['title'] }}</h5>
                                                <p class="text-muted small mb-2">{{ $item['description'] ?? '' }}</p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Hoàn tất</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i') }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                @if($item['points'] != 0)
                                                    <h5 class="{{ $item['points'] > 0 ? 'text-success' : 'text-danger' }} mb-1">
                                                        {{ $item['points'] > 0 ? '+' : '' }}{{ $item['points'] }} điểm
                                                    </h5>
                                                @endif
                                                @if(isset($item['book']))
                                                    <a href="{{ route('books.show', $item['book']->slug) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i> Chi tiết
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">Chưa có lịch sử</h4>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $history->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Summary Card -->
                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ffcaa5 0%, #ffb088 100%);">
                        <div class="card-body text-dark text-center py-4">
                            <i class="bi bi-coin mb-3" style="font-size: 3rem;"></i>
                            <h2 class="fw-bold mb-1">{{ number_format(Auth::user()->points) }}</h2>
                            <p class="mb-0">Điểm hiện có</p>
                            <a href="{{ url('/recharge') }}" class="btn mt-3 rounded-pill" style="background-color:#ff7043;border-color:#ff7043;color:#fff;">
                                <i class="bi bi-plus-circle me-1"></i> Nạp thêm
                            </a>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0">Thống kê</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Sách đã mua</span>
                                <span class="fw-bold">{{ $stats['total_purchases'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Sách đã tải</span>
                                <span class="fw-bold">{{ $stats['total_downloads'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Điểm đã tiêu</span>
                                <span class="fw-bold">{{ number_format(abs($stats['total_points_spent'])) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection
