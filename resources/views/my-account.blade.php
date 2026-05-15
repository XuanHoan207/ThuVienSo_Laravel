@extends('component.layout')

@section('title', 'Tài Khoản - Thư Viện Số')

@push('styles')
    @vite('resources/css/my-account.css')
@endpush

@section('content')
    @include('component.header')

    <!-- Dashboard Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <!-- User Profile Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body text-center py-4">
                            <div class="position-relative d-inline-block mb-3">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop" 
                                     alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle">
                                    <i class="bi bi-camera"></i>
                                </button>
                            </div>
                            <h5 class="mb-1">Nguyễn Văn User</h5>
                            <p class="text-muted small mb-3">user@email.com</p>
                            <div class="d-flex justify-content-center gap-3 mb-3">
                                <div class="text-center">
                                    <h5 class="mb-0 text-orange fw-bold">1,250</h5>
                                    <small class="text-muted">Điểm</small>
                                </div>
                                <div class="border-start px-3"></div>
                                <div class="text-center">
                                    <h5 class="mb-0 fw-bold">15</h5>
                                    <small class="text-muted">Sách</small>
                                </div>
                            </div>
                            <a href="{{ url('/recharge') }}" class="btn btn-primary btn-sm w-100 rounded-pill">
                                <i class="bi bi-plus-circle me-1"></i> Nạp thêm điểm
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-2">
                            <div class="nav flex-column nav-pills">
                                <a class="nav-link active" href="#dashboard" data-bs-toggle="pill">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                                <a class="nav-link" href="#profile" data-bs-toggle="pill">
                                    <i class="bi bi-person me-2"></i> Hồ sơ
                                </a>
                                <a class="nav-link" href="#purchases" data-bs-toggle="pill">
                                    <i class="bi bi-bag me-2"></i> Sách đã mua
                                </a>
                                <a class="nav-link" href="#downloads" data-bs-toggle="pill">
                                    <i class="bi bi-download me-2"></i> Lịch sử tải
                                </a>
                                <a class="nav-link" href="#favorites" data-bs-toggle="pill">
                                    <i class="bi bi-heart me-2"></i> Yêu thích
                                </a>
                                <a class="nav-link" href="#mybooks" data-bs-toggle="pill">
                                    <i class="bi bi-book me-2"></i> Sách của tôi
                                </a>
                                <a class="nav-link" href="#notifications" data-bs-toggle="pill">
                                    <i class="bi bi-bell me-2"></i> Thông báo
                                </a>
                                <a class="nav-link" href="#security" data-bs-toggle="pill">
                                    <i class="bi bi-shield-lock me-2"></i> Bảo mật
                                </a>
                                <hr>
                                <a class="nav-link text-danger" href="#">
                                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- Dashboard Tab -->
                        <div class="tab-pane fade show active" id="dashboard">
                            <h4 class="fw-bold mb-4">Dashboard</h4>

                            <!-- Stats Cards -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Tổng điểm</p>
                                                    <h3 class="mb-0 fw-bold text-orange">1,250</h3>
                                                </div>
                                                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                                                    <i class="bi bi-coin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Sách đã mua</p>
                                                    <h3 class="mb-0 fw-bold">15</h3>
                                                </div>
                                                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                                    <i class="bi bi-bag"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Sách yêu thích</p>
                                                    <h3 class="mb-0 fw-bold">8</h3>
                                                </div>
                                                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                                    <i class="bi bi-heart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Sách đã tải</p>
                                                    <h3 class="mb-0 fw-bold">42</h3>
                                                </div>
                                                <div class="stat-icon bg-success bg-opacity-10 text-success">
                                                    <i class="bi bi-download"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Đánh giá</p>
                                                    <h3 class="mb-0 fw-bold">5</h3>
                                                </div>
                                                <div class="stat-icon bg-info bg-opacity-10 text-info">
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="text-muted mb-1">Sách đã đăng</p>
                                                    <h3 class="mb-0 fw-bold">2</h3>
                                                </div>
                                                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                                                    <i class="bi bi-cloud-upload"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Hoạt động gần đây</h5>
                                    <a href="{{ url('/history') }}" class="text-orange text-decoration-none">Xem tất cả</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item activity-item d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-success bg-opacity-10 text-success rounded p-2">
                                                    <i class="bi bi-bag"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Mua sách "Lập trình Laravel"</h6>
                                                <small class="text-muted">15/05/2026 10:30</small>
                                            </div>
                                            <span class="badge bg-danger">-500 điểm</span>
                                        </div>
                                        <div class="list-group-item activity-item d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-warning bg-opacity-10 text-warning rounded p-2">
                                                    <i class="bi bi-wallet2"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Nạp điểm qua VNPay</h6>
                                                <small class="text-muted">15/05/2026 10:25</small>
                                            </div>
                                            <span class="badge bg-success">+550 điểm</span>
                                        </div>
                                        <div class="list-group-item activity-item d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded p-2">
                                                    <i class="bi bi-download"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Tải sách "Machine Learning Cơ Bản"</h6>
                                                <small class="text-muted">14/05/2026 16:45</small>
                                            </div>
                                            <span class="badge bg-secondary">Hoàn tất</span>
                                        </div>
                                        <div class="list-group-item activity-item d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-danger bg-opacity-10 text-danger rounded p-2">
                                                    <i class="bi bi-heart"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Thêm "Mắt Biếc" vào yêu thích</h6>
                                                <small class="text-muted">13/05/2026 09:20</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Tab -->
                        <div class="tab-pane fade" id="profile">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white">
                                    <h5 class="fw-bold mb-0">Hồ sơ cá nhân</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Họ và tên</label>
                                                <input type="text" class="form-control" value="Nguyễn Văn User">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" value="user@email.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" value="0912 345 678">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ngày sinh</label>
                                                <input type="date" class="form-control" value="1995-05-15">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Địa chỉ</label>
                                                <textarea class="form-control" rows="2">123 Đường ABC, Quận 1, TP. Hồ Chí Minh</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Bio</label>
                                                <textarea class="form-control" rows="3" placeholder="Giới thiệu về bạn..."></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Purchases Tab -->
                        <div class="tab-pane fade" id="purchases">
                            <h4 class="fw-bold mb-4">Sách đã mua</h4>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="book-item bg-white shadow-sm">
                                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=300&fit=crop" alt="">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold">Lập trình Laravel</h6>
                                            <p class="text-muted small mb-1">Lê Hùng Sơn</p>
                                            <p class="text-orange fw-bold mb-2">500 điểm</p>
                                            <small class="text-muted">Mua: 15/05/2026</small>
                                            <div class="mt-2">
                                                <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Đọc ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="book-item bg-white shadow-sm">
                                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=200&h=300&fit=crop" alt="">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold">Machine Learning Cơ Bản</h6>
                                            <p class="text-muted small mb-1">Vũ Đình Long</p>
                                            <p class="text-orange fw-bold mb-2">750 điểm</p>
                                            <small class="text-muted">Mua: 14/05/2026</small>
                                            <div class="mt-2">
                                                <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-outline-primary">Đọc ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Downloads Tab -->
                        <div class="tab-pane fade" id="downloads">
                            <h4 class="fw-bold mb-4">Lịch sử tải</h4>
                            <div class="card border-0 shadow-sm">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sách</th>
                                                <th>Ngày tải</th>
                                                <th>Điểm</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=50&h=70&fit=crop" 
                                                              alt="" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                                        <span class="ms-2">Lập trình Laravel</span>
                                                    </div>
                                                </td>
                                                <td>15/05/2026</td>
                                                <td><span class="text-danger">-500</span></td>
                                                <td>
                                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Tải lại</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=50&h=70&fit=crop" 
                                                              alt="" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                                        <span class="ms-2">Machine Learning Cơ Bản</span>
                                                    </div>
                                                </td>
                                                <td>14/05/2026</td>
                                                <td><span class="text-danger">-750</span></td>
                                                <td>
                                                    <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Tải lại</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="{{ url('/history') }}" class="btn btn-outline-primary mt-3">Xem tất cả lịch sử</a>
                        </div>

                        <!-- Favorites Tab -->
                        <div class="tab-pane fade" id="favorites">
                            <h4 class="fw-bold mb-4">Sách yêu thích</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="book-item bg-white shadow-sm">
                                        <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?w=200&h=300&fit=crop" alt="">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold">Mắt Biếc</h6>
                                            <p class="text-muted small mb-1">Nguyễn Nhật Ánh</p>
                                            <div class="mb-2">
                                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.9</span>
                                            </div>
                                            <p class="text-orange fw-bold">500 điểm</p>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart-fill"></i> Bỏ thích</button>
                                            <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-primary">Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="book-item bg-white shadow-sm">
                                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=200&h=300&fit=crop" alt="">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold">Cho Tôi Xin Một Vé Đi Tuổi Thơ</h6>
                                            <p class="text-muted small mb-1">Nguyễn Nhật Ánh</p>
                                            <div class="mb-2">
                                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.8</span>
                                            </div>
                                            <p class="text-orange fw-bold">450 điểm</p>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart-fill"></i> Bỏ thích</button>
                                            <a href="{{ url('/books-detail') }}" class="btn btn-sm btn-primary">Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('/wishlist') }}" class="btn btn-outline-primary mt-3">Xem tất cả yêu thích</a>
                        </div>

                        <!-- My Books Tab -->
                        <div class="tab-pane fade" id="mybooks">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">Sách của tôi</h4>
                                <a href="{{ url('/upload-book') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Đăng sách mới
                                </a>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sách</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đăng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=50&h=70&fit=crop" 
                                                              alt="" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                                        <span class="ms-2">Lập trình Laravel</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success">Đã duyệt</span></td>
                                                <td>10/05/2026</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=50&h=70&fit=crop" 
                                                              alt="" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                                        <span class="ms-2">Python Cơ Bản</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                                <td>12/05/2026</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Tab -->
                        <div class="tab-pane fade" id="notifications">
                            <h4 class="fw-bold mb-4">Thông báo</h4>
                            <a href="{{ url('/notifications') }}" class="btn btn-outline-primary mb-3">
                                <i class="bi bi-bell me-1"></i> Xem tất cả thông báo
                            </a>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Sách của bạn đã được duyệt!</h6>
                                        <small class="text-muted">15 phút trước</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">Mới</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Nạp điểm thành công!</h6>
                                        <small class="text-muted">2 giờ trước</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">Mới</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Có sách mới trong giỏ hàng!</h6>
                                        <small class="text-muted">5 giờ trước</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security">
                            <h4 class="fw-bold mb-4">Bảo mật</h4>
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Đổi mật khẩu</h5>
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Mật khẩu hiện tại</label>
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu hiện tại">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mật khẩu mới</label>
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Xác nhận mật khẩu mới</label>
                                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Bảo mật tài khoản</h5>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Xác thực hai yếu tố (2FA)</h6>
                                                <small class="text-muted">Thêm lớp bảo mật cho tài khoản</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="2faSwitch">
                                                <label class="form-check-label" for="2faSwitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Thông báo đăng nhập</h6>
                                                <small class="text-muted">Nhận email khi có đăng nhập mới</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="loginAlertSwitch" checked>
                                                <label class="form-check-label" for="loginAlertSwitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('component.footer')
@endsection
