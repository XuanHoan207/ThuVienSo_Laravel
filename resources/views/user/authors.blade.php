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
                    <p class="text-muted">Khám phá các tác giả nổi tiếng and những tác phẩm của họ</p>
                </div>
                <div class="col-md-6">
                    <form class="d-flex gap-2">
                        <input type="text" class="form-control" placeholder="Tìm kiếm tác giả..." id="searchAuthor">
                        <select class="form-select" id="letterFilter" style="width: auto;">
                            <option value="all">Tất cả</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                        <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <!-- Authors Grid -->
            <div class="row gy-4" id="authorsGrid">
                <!-- Author 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop" 
                                 alt="Nguyễn Nhật Ánh" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Nguyễn Nhật Ánh</h5>
                            <p class="text-muted small mb-2">Tác giả văn học</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">12 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.8</span>
                            </div>
                            <p class="text-muted small mb-3">Tác giả nổi tiếng with các tác phẩm về tuổi thơ and tình yêu</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop" 
                                 alt="Trần Đức Shins" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Trần Đức Shins</h5>
                            <p class="text-muted small mb-2">Tác giả Self-help</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">8 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.9</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia về phát triển bản thân and kỹ năng sống</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 3 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop" 
                                 alt="Phạm Thị Vân" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Phạm Thị Vân</h5>
                            <p class="text-muted small mb-2">Chuyên gia Marketing</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">5 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.7</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia marketing with hơn 15 năm kinh nghiệm</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 4 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop" 
                                 alt="Lê Hùng Sơn" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Lê Hùng Sơn</h5>
                            <p class="text-muted small mb-2">Lập trình viên</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">15 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.6</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia về Laravel, PHP and JavaScript</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 5 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop" 
                                 alt="Trần Minh Tuệ" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Trần Minh Tuệ</h5>
                            <p class="text-muted small mb-2">Tác giả kinh tế</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">7 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.5</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia tài chính and đầu tư</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 6 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&h=200&fit=crop" 
                                 alt="Hoàng Nam" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Hoàng Nam</h5>
                            <p class="text-muted small mb-2">Khoa học</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">10 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.8</span>
                            </div>
                            <p class="text-muted small mb-3">Nhà văn khoa học with nhiều giải thưởng</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 7 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop" 
                                 alt="Đặng Thị Lan" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Đặng Thị Lan</h5>
                            <p class="text-muted small mb-2">Tâm lý học</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">6 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.7</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia tâm lý and phát triển con người</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Author 8 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card author-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face" 
                                 alt="Vũ Đình Long" class="author-avatar mb-3">
                            <h5 class="fw-bold mb-1">Vũ Đình Long</h5>
                            <p class="text-muted small mb-2">CNTT</p>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="badge bg-primary">9 sách</span>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 4.6</span>
                            </div>
                            <p class="text-muted small mb-3">Chuyên gia AI and Machine Learning</p>
                            <a href="{{ url('/author-detail') }}" class="btn btn-outline-primary btn-sm rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="mt-5">
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
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới and ưu đãi hấp dẫn.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    <!-- Footer -->
    @include('user.component.footer')
@endsection

