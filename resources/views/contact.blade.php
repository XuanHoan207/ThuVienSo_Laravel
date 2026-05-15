@extends('component.layout')

@section('title', 'Liên Hệ - Thư Viện Số')

@push('scripts')
    @vite('resources/js/contact.js')
@endpush

@section('content')
    @include('component.header')

    <!-- Page Header -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="contact-section py-5" style="background-color:#fff;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Liên Hệ Với Chúng Tôi</h2>
                <p class="text-muted">Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn!</p>
            </div>

            <div class="row g-4">
                <!-- Left: Contact Info -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100 p-4">
                        <h5 class="fw-bold mb-4 text-orange"><i class="bi bi-info-circle me-2"></i>Thông Tin Liên Hệ</h5>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="bi bi-geo-alt-fill fs-5 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Địa chỉ</h6>
                                <p class="text-muted mb-0">Tòa nhà FPT, Quận 9, TP. HCM</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                <i class="bi bi-telephone-fill fs-5 text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Điện thoại</h6>
                                <p class="text-muted mb-0">Hotline: 1900 1234</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                <i class="bi bi-envelope-fill fs-5 text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Email</h6>
                                <p class="text-muted mb-0">contact@thuvienso.vn</p>
                            </div>
                        </div>
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-semibold mb-3">Kết nối với chúng tôi</h6>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="btn btn-outline-danger rounded-circle"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="btn btn-outline-info rounded-circle"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-send me-2"></i>Gửi Tin Nhắn</h5>
                        <form id="contactForm">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Nhập họ và tên" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-sm" placeholder="Nhập email" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Chủ đề <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" required>
                                        <option value="">Chọn chủ đề</option>
                                        <option>Hỗ trợ sử dụng</option>
                                        <option>Báo lỗi</option>
                                        <option>Góp ý</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Nội dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" rows="3" placeholder="Nhập nội dung..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">
                                        <i class="bi bi-send me-2"></i>Gửi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter-section">
        <h3>Đăng Ký Nhận Tin</h3>
        <p>Đăng ký để nhận thông tin về sách mới.</p>
        <div class="newsletter-input">
            <input type="email" placeholder="Nhập email của bạn">
            <button>ĐĂNG KÝ</button>
        </div>
    </section>

    @include('component.footer')
@endsection
