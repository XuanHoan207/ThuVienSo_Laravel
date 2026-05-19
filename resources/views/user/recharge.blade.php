@extends('user.component.layout')

@section('title', 'Nạp Điểm - Thư Viện Số')

@push('styles')
    <style>
        .recharge-container {
            background: linear-gradient(135deg, #fff4ec 0%, #ff8d4c 100%);
        }
        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        .payment-method-card:hover {
            border-color: #ED553B;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(237, 85, 59, 0.15);
        }
        .payment-method-card.active {
            border-color: #ED553B;
            background: #fff5f3;
        }
        .payment-method-card.active .payment-check {
            background: #ED553B;
            border-color: #ED553B;
        }
        .payment-method-card.active .payment-check i {
            display: block;
        }
        .payment-check {
            width: 24px;
            height: 24px;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .payment-check i {
            display: none;
            color: white;
            font-size: 14px;
        }
        .vnpay-logo {
            width: 80px;
            height: auto;
        }
        .momo-logo {
            width: 60px;
            height: auto;
        }
        .zalopay-logo {
            width: 80px;
            height: auto;
        }
        .bank-logo {
            width: 60px;
            height: auto;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/recharge.js')
@endpush

@section('content')
    @include('user.component.header')

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
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-4">
                        <!-- Left: Info -->
                        <div class="col-md-5">
                            <div class="recharge-container text-white p-4 p-md-5 rounded-4 h-100 shadow-lg border-0">
                                <h2 class="fw-bold mb-4">Tại sao nên nạp điểm?</h2>
                                <p class="mb-5 opacity-75">Nạp điểm giúp bạn sở hữu các tài liệu số độc quyền, chất lượng cao và ủng hộ cộng đồng tác giả.</p>
                                
                                <div class="d-flex flex-column gap-4">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                                            <i class="bi bi-shield-check fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Giao dịch an toàn</h6>
                                            <p class="mb-0 small opacity-75">Bảo mật tuyệt đối thông qua các cổng thanh toán uy tín.</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                                            <i class="bi bi-lightning-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Cộng điểm tức thì</h6>
                                            <p class="mb-0 small opacity-75">Nhận điểm ngay sau khi thanh toán thành công.</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                                            <i class="bi bi-gift-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Ưu đãi nạp lớn</h6>
                                            <p class="mb-0 small opacity-75">Thưởng thêm điểm cho các gói nạp từ 50k trở lên.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 pt-4 border-top border-white border-opacity-10 text-center">
                                    <small class="opacity-50">Hỗ trợ 24/7: 1900 1234</small>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Form -->
                        <div class="col-md-7">
                            <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                                <h4 class="fw-bold mb-4 text-dark">Chọn gói nạp điểm</h4>
                                
                                @if(session('error'))
                                    <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success rounded-3 border-0 shadow-sm mb-4">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('recharge.process') }}" method="POST" id="rechargeForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted mb-3">MỆNH GIÁ PHỔ BIẾN</label>
                                        <div class="row g-2 mb-4">
                                            @php $amounts = [10000, 50000, 100000, 200000, 500000, 1000000]; @endphp
                                            @foreach($amounts as $amount)
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-outline-light border text-dark w-100 py-3 rounded-3 amount-btn transition-all" data-amount="{{ $amount }}" style="background: #f8f9fa; border-color: #dee2e6;">
                                                        <span class="fw-bold small">{{ number_format($amount/1000) }}k</span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <label class="form-label small fw-bold text-muted mb-2">NHẬP SỐ TIỀN KHÁC (VND)</label>
                                        <input type="number" name="amount" id="amountInput" 
                                               class="form-control form-control-lg border-light bg-light rounded-3 text-center fw-bold" 
                                               style="color: #ED553B;"
                                               placeholder="Tối thiểu 10,000" min="10000" required>
                                    
                                        <div class="mt-3 p-3 rounded-3 text-center" style="background: #fff4ec; border: 1px solid #ED553B;">
                                            <span class="text-muted small">Bạn sẽ nhận được:</span>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h3 id="pointsPreview" class="fw-bold mb-0" style="color: #ED553B;">0</h3>
                                                <span class="fw-bold" style="color: #ED553B;">ĐIỂM</span>
                                            </div>
                                            <small class="text-muted x-small">Tỷ giá: 1,000 VND = 1 điểm</small>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted mb-3">PHƯƠNG THỨC THANH TOÁN</label>
                                        
                                        <!-- VNPay -->
                                        <div class="payment-method-card mb-3 active" data-method="vnpay" onclick="selectPayment(this)">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-check">
                                                    <i class="bi bi-check"></i>
                                                </div>
                                                <input type="radio" name="payment_method" value="vnpay" class="d-none" checked>
                                                <div class="ms-3 flex-grow-1">
                                                    <img src="https://vnpay.vn/wp-content/uploads/2020/07/Logo-VNPAYQR-no-background.png" alt="VNPay" class="vnpay-logo" style="height: 30px;">
                                                </div>
                                                <div class="text-end">
                                                    <p class="mb-0 fw-bold small text-dark">VNPAY</p>
                                                    <p class="mb-0 x-small text-muted">ATM, QR-Code, Ví điện tử</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MoMo -->
                                        <div class="payment-method-card mb-3" data-method="momo" onclick="selectPayment(this)">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-check">
                                                    <i class="bi bi-check"></i>
                                                </div>
                                                <input type="radio" name="payment_method" value="momo" class="d-none">
                                                <div class="ms-3 flex-grow-1">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/MoMo_Logo.png/1200px-MoMo_Logo.png" alt="MoMo" class="momo-logo" style="height: 35px;">
                                                </div>
                                                <div class="text-end">
                                                    <p class="mb-0 fw-bold small text-dark">MoMo</p>
                                                    <p class="mb-0 x-small text-muted">Ví điện tử MoMo</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ZaloPay -->
                                        <div class="payment-method-card mb-3" data-method="zalo" onclick="selectPayment(this)">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-check">
                                                    <i class="bi bi-check"></i>
                                                </div>
                                                <input type="radio" name="payment_method" value="zalo" class="d-none">
                                                <div class="ms-3 flex-grow-1">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Zalo_pay_logo.svg/1200px-Zalo_pay_logo.svg.png" alt="ZaloPay" class="zalopay-logo" style="height: 30px;">
                                                </div>
                                                <div class="text-end">
                                                    <p class="mb-0 fw-bold small text-dark">ZaloPay</p>
                                                    <p class="mb-0 x-small text-muted">Ví ZaloPay</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Banking -->
                                        <div class="payment-method-card" data-method="banking" onclick="selectPayment(this)">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-check">
                                                    <i class="bi bi-check"></i>
                                                </div>
                                                <input type="radio" name="payment_method" value="banking" class="d-none">
                                                <div class="ms-3 flex-grow-1">
                                                    <i class="bi bi-bank fs-2" style="color: #ED553B;"></i>
                                                </div>
                                                <div class="text-end">
                                                    <p class="mb-0 fw-bold small text-dark">Chuyển khoản</p>
                                                    <p class="mb-0 x-small text-muted">ATM / Internet Banking</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid mt-5">
                                        <button type="submit" class="btn btn-lg rounded-pill py-3 fw-bold shadow-sm transition-all" style="background: linear-gradient(135deg, #ED553B, #FF8A5B); border: none; color: white;">
                                            NẠP ĐIỂM NGAY <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amountInput');
        const pointsPreview = document.getElementById('pointsPreview');
        const amountBtns = document.querySelectorAll('.amount-btn');

        function updatePoints() {
            const val = parseInt(amountInput.value) || 0;
            const points = Math.floor(val / 1000);
            pointsPreview.innerText = points.toLocaleString();
        }

        amountInput.addEventListener('input', function() {
            updatePoints();
            amountBtns.forEach(b => b.classList.remove('active'));
            this.style.borderColor = '#ED553B';
        });

        amountBtns.forEach(btn => {
            btn.style.transition = 'all 0.3s ease';
            btn.addEventListener('click', function() {
                amountInput.value = this.dataset.amount;
                amountBtns.forEach(b => {
                    b.classList.remove('active');
                    b.style.backgroundColor = '#f8f9fa';
                    b.style.borderColor = '#dee2e6';
                    b.style.color = '#333';
                });
                this.classList.add('active');
                this.style.backgroundColor = '#ED553B';
                this.style.borderColor = '#ED553B';
                this.style.color = 'white';
                updatePoints();
            });
        });

        // Set default active button
        const defaultBtn = document.querySelector('.amount-btn[data-amount="50000"]');
        if (defaultBtn) {
            defaultBtn.click();
        }
    });

    function selectPayment(element) {
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('active');
            card.querySelector('input[type="radio"]').checked = false;
        });
        element.classList.add('active');
        element.querySelector('input[type="radio"]').checked = true;
    }
</script>
<style>
    .amount-btn:hover, .amount-btn.active {
        background-color: #ED553B !important;
        border-color: #ED553B !important;
        color: white !important;
    }
    .payment-method-card.active {
        border-color: #ED553B !important;
        background-color: #fff5f3;
    }
    .x-small { font-size: 0.75rem; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endpush
