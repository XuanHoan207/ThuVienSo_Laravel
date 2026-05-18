@extends('user.component.layout')

@section('title', 'Giới Thiệu - Thư Viện Số')

@push('styles')
    @vite('resources/css/about.css')
@endpush

@push('scripts')
    @vite('resources/js/about.js')
@endpush

@section('content')
    @include('user.component.header')

    <!-- Hero Section -->
    <section class="hero-section text-white text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Chào mừng đến với Thư Viện Số</h1>
                    <p class="lead mb-4">Nền tảng thư viện sách trực tuyến hàng đầu Việt Nam, nơi bạn có thể khám phá, đọc và tải hàng ngàn cuốn sách hay từ mọi thể loại.</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ url('/books') }}" class="btn btn-light btn-lg rounded-pill px-4">Khám phá sách</a>
                        <a href="{{ url('/register') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">Đăng ký miễn phí</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-book text-orange mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mb-1">10,000+</h2>
                        <p class="text-muted mb-0">Sách điện tử</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-people text-orange mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mb-1">50,000+</h2>
                        <p class="text-muted mb-0">Độc giả</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-download text-orange mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mb-1">100,000+</h2>
                        <p class="text-muted mb-0">Lượt tải</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <i class="bi bi-star text-orange mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold mb-1">4.8/5</h2>
                        <p class="text-muted mb-0">Đánh giá TB</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Về Thư Viện Số</h2>
                    <p class="text-muted mb-4">
                        Thư Viện Số được thành lập với sứ mệnh mang đến cho độc giả Việt Nam một nền tảng đọc sách tiện lợi, 
                        chất lượng và dễ tiếp cận. Chúng tôi tin rằng kiến thức là vô giá và mọi người đều xứng đáng được tiếp cận 
                        với những cuốn sách hay.
                    </p>
                    <p class="text-muted mb-4">
                        Với đội ngũ chuyên gia và đối tác uy tín, Thư Viện Số cam kết cung cấp:
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Kho sách đa dạng từ nhiều thể loại</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Nội dung chất lượng cao, được kiểm duyệt kỹ lưỡng</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Giá cả hợp lý với nhiều ưu đãi hấp dẫn</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Trải nghiệm đọc mượt mà trên mọi thiết bị</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Hỗ trợ khách hàng 24/7</li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800" alt="Library" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Tại sao chọn Thư Viện Số?</h2>
                <p class="text-muted">Chúng tôi mang đến trải nghiệm đọc sách tốt nhất</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Bản quyền chính hãng</h5>
                            <p class="text-muted mb-0">Tất cả sách đều có bản quyền hợp pháp, đảm bảo quyền lợi cho tác giả và nhà xuất bản.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-lightning-charge" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Tải nhanh chóng</h5>
                            <p class="text-muted mb-0">Máy chủ mạnh mẽ, tốc độ tải nhanh, hỗ trợ nhiều định dạng: PDF, EPUB, MOBI.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-phone" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Đọc mọi nơi</h5>
                            <p class="text-muted mb-0">Đọc trên mọi thiết bị: máy tính, điện thoại, tablet. Đồng bộ tiến độ đọc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-tags" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Giá cả hợp lý</h5>
                            <p class="text-muted mb-0">Nhiều gói giá linh hoạt, ưu đãi hấp dẫn cho thành viên VIP.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Cộng đồng sôi động</h5>
                            <p class="text-muted mb-0">Đánh giá, bình luận, chia sẻ. Kết nối với những người yêu sách.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="feature-icon bg-orange text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-headset" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Hỗ trợ 24/7</h5>
                            <p class="text-muted mb-0">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Đội ngũ của chúng tôi</h2>
                <p class="text-muted">Những người tận tâm xây dựng Thư Viện Số</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-card">
                        <img src="https://via.placeholder.com/200" alt="Team Member" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">Nguyễn Văn A</h5>
                        <p class="text-muted mb-2">Founder & CEO</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-card">
                        <img src="https://via.placeholder.com/200" alt="Team Member" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">Trần Thị B</h5>
                        <p class="text-muted mb-2">CTO</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-card">
                        <img src="https://via.placeholder.com/200" alt="Team Member" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">Lê Văn C</h5>
                        <p class="text-muted mb-2">Product Manager</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="team-card">
                        <img src="https://via.placeholder.com/200" alt="Team Member" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">Phạm Thị D</h5>
                        <p class="text-muted mb-2">Head of Content</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #ff7043 0%, #ff8d4c 100%);">
        <div class="container">
            <h2 class="fw-bold mb-3">Sẵn sàng bắt đầu cuộc hành trình đọc sách?</h2>
            <p class="mb-4 opacity-75">Đăng ký ngay hôm nay và nhận ưu đãi 50% cho lần mua đầu tiên!</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ url('/register') }}" class="btn btn-light btn-lg rounded-pill px-5">Đăng ký miễn phí</a>
                <a href="{{ url('/contact') }}" class="btn btn-outline-light btn-lg rounded-pill px-5">Liên hệ</a>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection
