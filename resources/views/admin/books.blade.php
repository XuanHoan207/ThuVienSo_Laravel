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
        <a href="{{ url('/admin/books/create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Thêm sách mới
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sách...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">Tất cả danh mục</option>
                        <option>CNTT</option>
                        <option>Khoa học</option>
                        <option>Kinh tế</option>
                        <option>Văn học</option>
                        <option>Kỹ năng sống</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option>Đã duyệt</option>
                        <option>Chờ duyệt</option>
                        <option>Bị từ chối</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">Sắp xếp theo</option>
                        <option>Mới nhất</option>
                        <option>Cũ nhất</option>
                        <option>Giá cao - thấp</option>
                        <option>Giá thấp - cao</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-funnel me-2"></i>Lọc
                    </button>
                </div>
            </div>
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
                            <th width="150">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=100&h=100&fit=crop" 
                                     alt="" class="rounded" style="width: 50px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Lập trình Laravel</strong>
                                <br><small class="text-muted">ISBN: 978-0123456789</small>
                            </td>
                            <td>Lê Hùng Sơn</td>
                            <td><span class="badge bg-primary">CNTT</span></td>
                            <td><strong>500 điểm</strong></td>
                            <td><span class="badge bg-success">Đã duyệt</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/admin/books/edit/1') }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ url('/books-detail') }}" target="_blank" class="btn btn-outline-info" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" title="Xóa" onclick="deleteBook(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=100&h=100&fit=crop" 
                                     alt="" class="rounded" style="width: 50px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Machine Learning Cơ Bản</strong>
                                <br><small class="text-muted">ISBN: 978-0123456790</small>
                            </td>
                            <td>Vũ Đình Long</td>
                            <td><span class="badge bg-success">Khoa học</span></td>
                            <td><strong>750 điểm</strong></td>
                            <td><span class="badge bg-success">Đã duyệt</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/admin/books/edit/2') }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-info" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" title="Xóa" onclick="deleteBook(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=100&h=100&fit=crop" 
                                     alt="" class="rounded" style="width: 50px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Mắt Biếc</strong>
                                <br><small class="text-muted">ISBN: 978-0123456791</small>
                            </td>
                            <td>Nguyễn Nhật Ánh</td>
                            <td><span class="badge bg-info text-dark">Văn học</span></td>
                            <td><strong>500 điểm</strong></td>
                            <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/admin/books/edit/3') }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-outline-success" title="Duyệt">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="Từ chối">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" 
                                     alt="" class="rounded" style="width: 50px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Python Cơ Bản</strong>
                                <br><small class="text-muted">ISBN: 978-0123456792</small>
                            </td>
                            <td>Lê Hùng Sơn</td>
                            <td><span class="badge bg-primary">CNTT</span></td>
                            <td><strong>400 điểm</strong></td>
                            <td><span class="badge bg-danger">Bị từ chối</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/admin/books/edit/4') }}" class="btn btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-info" title="Xem">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" title="Xóa" onclick="deleteBook(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Hiển thị 1-4 của 1250 kết quả</span>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Trước</a>
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
        </div>
    </div>
@endsection
