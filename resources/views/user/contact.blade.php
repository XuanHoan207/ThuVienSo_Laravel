@extends('user.component.layout')

@section('title', 'Liên Hệ - Thư Viện Số')

@push('styles')
    @vite('resources/css/contact.css')
@endpush

@push('scripts')
    @vite('resources/js/contact.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
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
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2"><i class="bi bi-envelope me-2 text-orange"></i>Liên Hệ Với Chúng Tôi</h2>
                <p class="text-muted">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-5">
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Thông Tin Liên Hệ</h4>
                            
                            <div class="contact-info-item mb-4">
                                <div class="d-flex">
                                    <div class="contact-icon bg-orange text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Địa chỉ</h6>
                                        <p class="text-muted mb-0">Tòa nhà FPT Software, Khu Công Nghệ Cao, Quận 9, TP. Hồ Chí Minh</p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item mb-4">
                                <div class="d-flex">
                                    <div class="contact-icon bg-orange text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Điện thoại</h6>
                                        <p class="text-muted mb-0">Hotline: 1900 1234<br>Zalo: 0901 234 567</p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item mb-4">
                                <div class="d-flex">
                                    <div class="contact-icon bg-orange text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email</h6>
                                        <p class="text-muted mb-0">contact@thuvienso.vn<br>support@thuvienso.vn</p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item mb-4">
                                <div class="d-flex">
                                    <div class="contact-icon bg-orange text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Giờ làm việc</h6>
                                        <p class="text-muted mb-0">Thứ 2 - Thứ 6: 8:00 - 18:00<br>Thứ 7: 8:00 - 12:00</p>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Kết nối với chúng tôi</h6>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Gửi Tin Nhắn</h4>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên của bạn" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Chủ đề</label>
                                        <select name="subject" class="form-select">
                                            <option value="">Chọn chủ đề</option>
                                            <option value="general">Tư vấn chung</option>
                                            <option value="support">Hỗ trợ kỹ thuật</option>
                                            <option value="billing">Thanh toán</option>
                                            <option value="copyright">Báo cáo bản quyền</option>
                                            <option value="partnership">Hợp tác</option>
                                            <option value="other">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                        <textarea name="message" class="form-control" rows="5" placeholder="Nhập nội dung tin nhắn của bạn..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill px-5">
                                            <i class="bi bi-send me-2"></i>Gửi tin nhắn
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="card border-0 shadow-sm mt-5">
                <div class="card-body p-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.4854754193894!2d106.82931527481845!3d10.841234089407448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175273117b5fCL%3A0x6a2b5f5c5f5c5f5c!2sFPT%20Software!5e0!3m2!1svi!2s!4v1234567890" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection
