@extends('admin.component-admin.layout')

@section('title', 'Dashboard - Admin Thư Viện Số')

@push('styles')
    @vite('resources/css/admin/dashboard.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/dashboard.js')
@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Chào mừng bạn quay trở lại, Admin!</p>
        </div>
        <div>
            <span class="text-muted">
                <i class="bi bi-calendar me-1"></i>
                {{ date('d/m/Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format(1250) }}</span>
                        <span class="stat-card-label">Tổng sách</span>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ url('/admin/books') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format(5842) }}</span>
                        <span class="stat-card-label">Người dùng</span>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ url('/admin/users') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format(342) }}</span>
                        <span class="stat-card-label">Đơn hàng</span>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ url('/admin/orders') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="stat-card-info">
                        <span class="stat-card-value">{{ number_format(125000000) }}đ</span>
                        <span class="stat-card-label">Doanh thu tháng</span>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ url('/admin/transactions') }}" class="text-decoration-none">
                        Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng gần đây</h5>
                    <a href="{{ url('/admin/orders') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Sách</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>#ORD001</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span>Nguyễn Văn A</span>
                                        </div>
                                    </td>
                                    <td>Lập trình Laravel</td>
                                    <td><strong>500 điểm</strong></td>
                                    <td><span class="badge bg-success">Hoàn thành</span></td>
                                    <td>17/05/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>#ORD002</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span>Trần Thị B</span>
                                        </div>
                                    </td>
                                    <td>Machine Learning</td>
                                    <td><strong>750 điểm</strong></td>
                                    <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                                    <td>17/05/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>#ORD003</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span>Lê Minh C</span>
                                        </div>
                                    </td>
                                    <td>Mắt Biếc</td>
                                    <td><strong>500 điểm</strong></td>
                                    <td><span class="badge bg-success">Hoàn thành</span></td>
                                    <td>16/05/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>#ORD004</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop" 
                                                 alt="" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span>Phạm Thị D</span>
                                        </div>
                                    </td>
                                    <td>Python Cơ Bản</td>
                                    <td><strong>400 điểm</strong></td>
                                    <td><span class="badge bg-info">Chờ thanh toán</span></td>
                                    <td>16/05/2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sách chờ duyệt</h5>
                    <a href="{{ url('/admin/books') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="pending-list">
                        <div class="pending-item">
                            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=100&h=100&fit=crop" 
                                 alt="" class="rounded">
                            <div class="pending-info">
                                <h6 class="mb-1">Lập trình Node.js</h6>
                                <small class="text-muted">Nguyễn Văn X</small>
                            </div>
                            <div class="pending-actions">
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="pending-item">
                            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=100&h=100&fit=crop" 
                                 alt="" class="rounded">
                            <div class="pending-info">
                                <h6 class="mb-1">JavaScript Nâng Cao</h6>
                                <small class="text-muted">Trần Đức Y</small>
                            </div>
                            <div class="pending-actions">
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="pending-item">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=100&h=100&fit=crop" 
                                 alt="" class="rounded">
                            <div class="pending-info">
                                <h6 class="mb-1">React Thực Chiến</h6>
                                <small class="text-muted">Lê Hùng Z</small>
                            </div>
                            <div class="pending-actions">
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thống kê nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Sách mới tuần này</span>
                        <strong class="text-success">+45</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Người dùng mới</span>
                        <strong class="text-primary">+128</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Đơn hàng chờ</span>
                        <strong class="text-warning">12</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Báo cáo mới</span>
                        <strong class="text-danger">3</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
