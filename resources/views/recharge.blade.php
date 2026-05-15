@extends('component.layout')

@section('title', 'Nạp Điểm - Thư Viện Số')

@push('styles')
    @vite('resources/css/recharge.css')
@endpush

@push('scripts')
    @vite('resources/js/recharge.js')
@endpush

@section('content')
    @include('component.header')

    <!-- Page Header -->
    <div class="bg-light py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/my-account') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nạp điểm</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Recharge Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Left: Recharge Form -->
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2"><i class="bi bi-wallet2 me-2 text-orange"></i>Nạp Điểm</h2>
                    <p class="text-muted mb-4">Chọn gói nạp phù hợp with nhu cầu của bạn</p>

                    <!-- Current Points -->
                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fff4ec 0%, #ff8d4c 100%); border: 1px solid #f06728;">
                        <div class="card-body text-center py-4">
                            <p class="mb-1 text-orange"><i class="bi bi-coin me-2"></i>Số dư hiện tại</p>
                            <h2 class="mb-0 fw-bold text-dark">1,250 điểm</h2>
                        </div>
                    </div>

                    <!-- Package Selection -->
                    <h5 class="fw-bold mb-3">Chọn gói nạp</h5>
                    <div class="row g-4 mb-4" id="packageGrid">
                        <!-- Package 1 -->
                        <div class="col-md-4">
                            <div class="package-card" onclick="selectPackage(this, 10000, 100)">
                                <h6 class="text-muted mb-2">Cơ bản</h6>
                                <div class="points-amount text-dark mb-2">100 điểm</div>
                                <div class="price-amount mb-2">10.000đ</div>
                                <p class="text-muted small mb-0">Tỷ lệ: 100 điểm/10k</p>
                            </div>
                        </div>

                        <!-- Package 2 -->
                        <div class="col-md-4">
                            <div class="package-card selected" onclick="selectPackage(this, 50000, 550)">
                                <h6 class="text-muted mb-2">Phổ biến</h6>
                                <div class="points-amount text-dark mb-2">550 điểm</div>
                                <div class="price-amount mb-2">50.000đ</div>
                                <p class="text-success small mb-0">+10% bonus</p>
                            </div>
                        </div>

                        <!-- Package 3 -->
                        <div class="col-md-4">
                            <div class="package-card" onclick="selectPackage(this, 100000, 1200)">
                                <h6 class="text-muted mb-2">Tiết kiệm</h6>
                                <div class="points-amount text-dark mb-2">1,200 điểm</div>
                                <div class="price-amount mb-2">100.000đ</div>
                                <p class="text-success small mb-0">+20% bonus</p>
                            </div>
                        </div>

                        <!-- Package 4 -->
                        <div class="col-md-4">
                            <div class="package-card" onclick="selectPackage(this, 200000, 2600)">
                                <h6 class="text-muted mb-2">Cao cấp</h6>
                                <div class="points-amount text-dark mb-2">2,600 điểm</div>
                                <div class="price-amount mb-2">200.000đ</div>
                                <p class="text-success small mb-0">+30% bonus</p>
                            </div>
                        </div>

                        <!-- Package 5 -->
                        <div class="col-md-4">
                            <div class="package-card popular" onclick="selectPackage(this, 500000, 7500)">
                                <h6 class="text-muted mb-2">VIP</h6>
                                <div class="points-amount text-dark mb-2">7,500 điểm</div>
                                <div class="price-amount mb-2">500.000đ</div>
                                <p class="text-success small mb-0">+50% bonus</p>
                            </div>
                        </div>

                        <!-- Custom Amount -->
                        <div class="col-md-4">
                            <div class="package-card" onclick="showCustomAmount()">
                                <i class="bi bi-plus-circle text-orange mb-2" style="font-size: 2rem;"></i>
                                <h6 class="mb-2">Tùy chỉnh</h6>
                                <p class="text-muted small mb-0">Nhập số tiền bất kỳ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Amount Input (Hidden) -->
                    <div class="card border-0 shadow-sm mb-4" id="customAmountCard" style="display: none;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Nhập số tiền tùy chỉnh</h5>
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label">Số tiền (VNĐ)</label>
                                    <input type="number" class="form-control form-control-lg" id="customAmount" 
                                           placeholder="Nhập số tiền" min="10000" step="1000">
                                    <small class="text-muted">Tối thiểu: 10,000đ</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ước tính nhận được</label>
                                    <div class="fs-4 fw-bold text-orange" id="customPoints">0 điểm</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                    <div class="row g-3 mb-4" id="paymentMethods">
                        <div class="col-md-6">
                            <div class="payment-method selected" onclick="selectPayment(this, 'vnpay')">
                                <div class="d-flex align-items-center">
                                    <img src="https://cdn.hlop.eu.org/images/vnpay.png" alt="VNPay" width="50" class="me-3">
                                    <div>
                                        <h6 class="mb-0">VNPay</h6>
                                        <small class="text-muted">Thanh toán qua VNPay</small>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-orange ms-auto"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-method" onclick="selectPayment(this, 'momo')">
                                <div class="d-flex align-items-center">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/MoMo_Logo.png/200px-Momo_Logo.png" alt="MoMo" width="50" class="me-3">
                                    <div>
                                        <h6 class="mb-0">MoMo</h6>
                                        <small class="text-muted">Thanh toán qua MoMo</small>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-orange ms-auto" style="display: none;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-method" onclick="selectPayment(this, 'zalo')">
                                <div class="d-flex align-items-center">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/Zalo_logo.svg/200px-Zalo_logo.svg.png" alt="ZaloPay" width="50" class="me-3">
                                    <div>
                                        <h6 class="mb-0">ZaloPay</h6>
                                        <small class="text-muted">Thanh toán qua ZaloPay</small>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-orange ms-auto" style="display: none;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-method" onclick="selectPayment(this, 'banking')">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-bank text-primary me-3" style="font-size: 2rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Chuyển khoản</h6>
                                        <small class="text-muted">ATM/Internet Banking</small>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-orange ms-auto" style="display: none;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="card border-0 shadow-sm mb-4" style="background: #f8f9fa;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Tóm tắt</h5>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-1">Gói nạp:</p>
                                    <p class="text-muted mb-1">Phương thức:</p>
                                    <p class="text-muted mb-1">Tỷ lệ:</p>
                                    <hr>
                                    <p class="fw-bold mb-1">Số điểm nhận được:</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="fw-semibold mb-1" id="summaryPackage">550 điểm</p>
                                    <p class="fw-semibold mb-1" id="summaryPayment">VNPay</p>
                                    <p class="fw-semibold mb-1">100 điểm / 10,000đ</p>
                                    <hr>
                                    <p class="fw-bold text-orange mb-1" id="summaryPoints">550 điểm</p>
                                    <p class="text-muted" id="summaryAmount">Thanh toán: 50,000đ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-primary btn-lg w-100 rounded-pill" onclick="processPayment()">
                        <i class="bi bi-credit-card me-2"></i> Thanh toán ngay
                    </button>
                </div>

                <!-- Right: Transaction History -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-orange"></i>Lịch sử giao dịch</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <!-- Transaction 1 -->
                                <div class="list-group-item transaction-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Nạp tiền VNPay</h6>
                                            <small class="text-muted">15/05/2026 10:30</small>
                                            <p class="mb-0 mt-1"><span class="badge bg-success">+550 điểm</span></p>
                                        </div>
                                        <span class="text-success fw-bold">50,000đ</span>
                                    </div>
                                </div>

                                <!-- Transaction 2 -->
                                <div class="list-group-item transaction-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Nạp tiền MoMo</h6>
                                            <small class="text-muted">10/05/2026 14:20</small>
                                            <p class="mb-0 mt-1"><span class="badge bg-success">+100 điểm</span></p>
                                        </div>
                                        <span class="text-success fw-bold">10,000đ</span>
                                    </div>
                                </div>

                                <!-- Transaction 3 -->
                                <div class="list-group-item transaction-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Thanh toán sách</h6>
                                            <small class="text-muted">08/05/2026 09:15</small>
                                            <p class="mb-0 mt-1"><span class="badge bg-danger">-500 điểm</span></p>
                                        </div>
                                        <span class="text-danger fw-bold">500 điểm</span>
                                    </div>
                                </div>

                                <!-- Transaction 4 -->
                                <div class="list-group-item transaction-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Nạp tiền Banking</h6>
                                            <small class="text-muted">01/05/2026 16:45</small>
                                            <p class="mb-0 mt-1"><span class="badge bg-success">+1,200 điểm</span></p>
                                        </div>
                                        <span class="text-success fw-bold">100,000đ</span>
                                    </div>
                                </div>

                                <!-- Transaction 5 -->
                                <div class="list-group-item transaction-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Thưởng đăng nhập</h6>
                                            <small class="text-muted">01/05/2026 08:00</small>
                                            <p class="mb-0 mt-1"><span class="badge bg-success">+10 điểm</span></p>
                                        </div>
                                        <span class="text-success fw-bold">Bonus</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ url('/history') }}" class="text-orange text-decoration-none">Xem tất cả lịch sử <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="card border-0 shadow-sm mt-4" style="background: linear-gradient(135deg, #ED553B 0%, #FF8A5B 100%);">
                        <div class="card-body text-white">
                            <h5><i class="bi bi-info-circle me-2"></i>Lưu ý</h5>
                            <ul class="mb-0 ps-3">
                                <li>Tỷ lệ quy đổi: <strong>100 điểm = 10,000 VNĐ</strong></li>
                                <li>Điểm được cộng ngay sau khi thanh toán thành công</li>
                                <li>Hỗ trợ nạp 24/7</li>
                                <li>Liên hệ hotline 1900 1234 nếu cần hỗ trợ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('component.footer')
@endsection

