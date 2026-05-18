@extends('user.component.layout')

@section('title', 'Lịch Sử Tải - Thư Viện Số')

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
                        <button class="btn btn-outline-primary active" onclick="filterHistory('all', this)">
                            <i class="bi bi-list me-1"></i> Tất cả
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterHistory('purchase', this)">
                            <i class="bi bi-bag me-1"></i> Mua sách
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterHistory('download', this)">
                            <i class="bi bi-download me-1"></i> Tải về
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterHistory('points', this)">
                            <i class="bi bi-coin me-1"></i> Điểm
                        </button>
                        <button class="btn btn-outline-primary" onclick="filterHistory('upload', this)">
                            <i class="bi bi-cloud-upload me-1"></i> Đăng sách
                        </button>
                    </div>

                    <!-- History List -->
                    <div id="historyList">
                        <!-- Purchase Item -->
                        <div class="card history-card mb-3" data-type="purchase">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                                            <i class="bi bi-bag" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Mua sách "Lập trình Laravel"</h5>
                                                <p class="text-muted small mb-2">
                                                    Tác giả: Lê Hùng Sơn | Thể loại: CNTT
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>15/05/2026 10:30</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-danger mb-1">-500 điểm</h5>
                                                <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Đọc ngay
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Points Recharge -->
                        <div class="card history-card mb-3" data-type="points">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                                            <i class="bi bi-wallet2" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Nạp điểm qua VNPay</h5>
                                                <p class="text-muted small mb-2">
                                                    Gói: 550 điểm | Thanh toán: 50,000 VNĐ
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Thành công</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>15/05/2026 10:25</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-1">+550 điểm</h5>
                                                <small class="text-muted">Mã: #TXN12345</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Download Item -->
                        <div class="card history-card mb-3" data-type="download">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-info bg-opacity-10 text-info rounded p-3">
                                            <i class="bi bi-download" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Tải sách "Machine Learning Cơ Bản"</h5>
                                                <p class="text-muted small mb-2">
                                                    Tác giả: Vũ Đình Long | File: PDF (15MB)
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-info">Hoàn tất</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>14/05/2026 16:45</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download me-1"></i> Tải lại
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Item -->
                        <div class="card history-card mb-3" data-type="upload">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded p-3">
                                            <i class="bi bi-cloud-upload" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Đăng sách "Python Cơ Bản"</h5>
                                                <p class="text-muted small mb-2">
                                                    Trạng thái: Chờ duyệt
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>12/05/2026 09:30</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil me-1"></i> Chỉnh sửa
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Points Purchase -->
                        <div class="card history-card mb-3" data-type="points">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                                            <i class="bi bi-wallet2" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Nạp điểm qua MoMo</h5>
                                                <p class="text-muted small mb-2">
                                                    Gói: 100 điểm | Thanh toán: 10,000 VNĐ
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Thành công</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>10/05/2026 14:20</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-1">+100 điểm</h5>
                                                <small class="text-muted">Mã: #TXN12344</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Item 2 -->
                        <div class="card history-card mb-3" data-type="purchase">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                                            <i class="bi bi-bag" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Mua sách "Mắt Biếc"</h5>
                                                <p class="text-muted small mb-2">
                                                    Tác giả: Nguyễn Nhật Ánh | Thể loại: Văn học
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>08/05/2026 09:15</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-danger mb-1">-500 điểm</h5>
                                                <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Đọc ngay
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Item 2 -->
                        <div class="card history-card mb-3" data-type="upload">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded p-3">
                                            <i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Đăng sách "Lập trình Laravel"</h5>
                                                <p class="text-muted small mb-2">
                                                    Đã được duyệt and công khai
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>10/05/2026 15:00</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Xem
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Points Bonus -->
                        <div class="card history-card mb-3" data-type="points">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded p-3">
                                            <i class="bi bi-gift" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">Thưởng đăng nhập</h5>
                                                <p class="text-muted small mb-2">
                                                    Thưởng đăng nhập hàng ngày
                                                </p>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="badge bg-secondary">Bonus</span>
                                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>01/05/2026 08:00</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-1">+10 điểm</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Trước</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Summary Card -->
                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ffcaa5 0%, #ffb088 100%);">
                        <div class="card-body text-dark text-center py-4">
                            <i class="bi bi-coin mb-3" style="font-size: 3rem;"></i>
                            <h2 class="fw-bold mb-1">1,250</h2>
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
                                <span class="fw-bold">15</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Sách đã tải</span>
                                <span class="fw-bold">42</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Sách đã đăng</span>
                                <span class="fw-bold">2</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Đánh giá</span>
                                <span class="fw-bold">5</span>
                            </div>
                        </div>
                    </div>

                    <!-- Export -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0">Xuất dữ liệu</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Tải về lịch sử hoạt động của bạn</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Xuất PDF
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="bi bi-file-earmark-excel me-2"></i> Xuất Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('user.component.footer')
@endsection

