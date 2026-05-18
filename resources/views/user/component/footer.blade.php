    <!-- Footer -->
    <footer class="py-5" style="background: linear-gradient(90deg, #fffaf9, #fefbf5);">
        <div class="container">
            <div class="row gy-4">
                <!-- Logo & Description -->
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/sample logo 1.png') }}" alt="Logo" width="80">
                        <span class="ms-2 fw-bold fs-4 text-orange">Thư Viện Số</span>
                    </div>
                    <p class="text-muted small mb-4">
                        Thư viện sách trực tuyến hàng đầu Việt Nam. Khám phá, đọc và tải hàng ngàn cuốn sách hay từ nhiều thể loại đa dạng.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-orange fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-youtube"></i></a>
                    </div>
                    <div class="mt-4">
                        <h6 class="fw-bold text-orange mb-2">Liên hệ</h6>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt me-2"></i>Tòa nhà FPT, Quận 9, TP. HCM</p>
                        <p class="text-muted small mb-1"><i class="bi bi-telephone me-2"></i>Hotline: 1900 1234</p>
                        <p class="text-muted small mb-1"><i class="bi bi-envelope me-2"></i>contact@thuvienso.vn</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-orange mb-3">LIÊN KẾT NHANH</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-dark text-decoration-none d-block mb-2">Trang chủ</a></li>
                        <li><a href="{{ url('/about') }}" class="text-dark text-decoration-none d-block mb-2">Giới thiệu</a></li>
                        <li><a href="{{ url('/books') }}" class="text-dark text-decoration-none d-block mb-2">Sách</a></li>
                        <li><a href="{{ url('/authors') }}" class="text-dark text-decoration-none d-block mb-2">Tác giả</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-dark text-decoration-none d-block mb-2">Liên hệ</a></li>
                    </ul>
                </div>

                <!-- User Links -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-orange mb-3">TÀI KHOẢN</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/my-account') }}" class="text-dark text-decoration-none d-block mb-2">Tài khoản của tôi</a></li>
                        <li><a href="{{ url('/cart') }}" class="text-dark text-decoration-none d-block mb-2">Giỏ hàng</a></li>
                        <li><a href="{{ url('/wishlist') }}" class="text-dark text-decoration-none d-block mb-2">Sách yêu thích</a></li>
                        <li><a href="{{ url('/history') }}" class="text-dark text-decoration-none d-block mb-2">Lịch sử tải</a></li>
                        <li><a href="{{ url('/recharge') }}" class="text-dark text-decoration-none d-block mb-2">Nạp điểm</a></li>
                        <li><a href="{{ url('/upload-book') }}" class="text-dark text-decoration-none d-block mb-2">Đăng sách mới</a></li>
                        <li><a href="{{ url('/notifications') }}" class="text-dark text-decoration-none d-block mb-2">Thông báo</a></li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted small mb-0">© 2026 Thư Viện Số. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-orange small text-decoration-none">Chính sách bảo mật</a>
                    <span class="text-muted mx-2">|</span>
                    <a href="#" class="text-dark small text-decoration-none">Điều khoản sử dụng</a>
                </div>
            </div>
        </div>
    </footer>
