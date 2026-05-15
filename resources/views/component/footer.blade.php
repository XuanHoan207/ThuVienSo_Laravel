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
                        Thư viện sách trực tuyến hàng đầu Việt Nam. Khám phá, đọc và tải hàng ngàn cuốn sách hay.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-orange fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-orange fs-5"><i class="bi bi-youtube"></i></a>
                    </div>
                    <p class="text-muted small mt-4 mb-0">© 2026 Thư Viện Số. All Rights Reserved.</p>
                </div>

                <!-- Company Links -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-orange mb-3">LIÊN KẾT</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-dark text-decoration-none d-block mb-2">Trang chủ</a></li>
                        <li><a href="{{ url('/about') }}" class="text-dark text-decoration-none d-block mb-2">Giới thiệu</a></li>
                        <li><a href="{{ url('/books') }}" class="text-dark text-decoration-none d-block mb-2">Sách</a></li>
                        <li><a href="{{ url('/authors') }}" class="text-dark text-decoration-none d-block mb-2">Tác giả</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-dark text-decoration-none d-block mb-2">Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-orange mb-3">HỖ TRỢ</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/my-account') }}" class="text-dark text-decoration-none d-block mb-2">Tài khoản</a></li>
                        <li><a href="{{ url('/recharge') }}" class="text-dark text-decoration-none d-block mb-2">Nạp điểm</a></li>
                        <li><a href="{{ url('/history') }}" class="text-dark text-decoration-none d-block mb-2">Lịch sử tải</a></li>
                        <li><a href="{{ url('/notifications') }}" class="text-dark text-decoration-none d-block mb-2">Thông báo</a></li>
                        <li><a href="{{ url('/upload-book') }}" class="text-dark text-decoration-none d-block mb-2">Đăng sách</a></li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-center">
                <a href="#" class="text-orange small text-decoration-none">Chính sách bảo mật</a>
                <span class="text-muted mx-2">|</span>
                <a href="#" class="text-dark small text-decoration-none">Điều khoản sử dụng</a>
            </div>
        </div>
    </footer>
