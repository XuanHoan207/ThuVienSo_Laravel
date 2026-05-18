@extends('user.component.layout')

@section('title', 'Nạp Điểm - Thư Viện Số')

@push('styles')
    @vite('resources/css/recharge.css')
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
    <section class="py-5">
        <div class="container">
            <form action="{{ route('recharge.process') }}" method="POST" id="rechargeForm">
                @csrf
                <div class="row">
                    <!-- Left: Recharge Form -->
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-2"><i class="bi bi-wallet2 me-2 text-orange"></i>Nạp Điểm</h2>
                        <p class="text-muted mb-4">Chọn gói nạp phù hợp với nhu cầu của bạn</p>

                        <!-- Current Points -->
                        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fff4ec 0%, #ff8d4c 100%); border: 1px solid #f06728;">
                            <div class="card-body text-center py-4">
                                <p class="mb-1 text-orange"><i class="bi bi-coin me-2"></i>Số dư hiện tại</p>
                                <h2 class="mb-0 fw-bold text-dark">{{ number_format(Auth::user()->points) }} điểm</h2>
                            </div>
                        </div>

                        <!-- Package Selection -->
                        <h5 class="fw-bold mb-3">Chọn gói nạp</h5>
                        <div class="row g-4 mb-4" id="packageGrid">
                            <div class="col-md-4">
                                <label class="package-card {{ old('amount') == 10000 ? 'selected' : '' }}">
                                    <input type="radio" name="amount" value="10000" class="d-none" {{ old('amount') == 10000 ? 'checked' : '' }}>
                                    <h6 class="text-muted mb-2">Cơ bản</h6>
                                    <div class="points-amount text-dark mb-2">100 điểm</div>
                                    <div class="price-amount mb-2">10.000đ</div>
                                    <p class="text-muted small mb-0">Tỷ lệ: 100 điểm/10k</p>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="package-card {{ old('amount') == 50000 ? 'selected' : '' }}">
                                    <input type="radio" name="amount" value="50000" class="d-none" {{ old('amount') == 50000 ? 'checked' : '' }}>
                                    <h6 class="text-muted mb-2">Phổ biến</h6>
                                    <div class="points-amount text-dark mb-2">550 điểm</div>
                                    <div class="price-amount mb-2">50.000đ</div>
                                    <p class="text-success small mb-0">+10% bonus</p>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="package-card {{ old('amount') == 100000 ? 'selected' : '' }}">
                                    <input type="radio" name="amount" value="100000" class="d-none" {{ old('amount') == 100000 ? 'checked' : '' }}>
                                    <h6 class="text-muted mb-2">Tiết kiệm</h6>
                                    <div class="points-amount text-dark mb-2">1,200 điểm</div>
                                    <div class="price-amount mb-2">100.000đ</div>
                                    <p class="text-success small mb-0">+20% bonus</p>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="package-card {{ old('amount') == 200000 ? 'selected' : '' }}">
                                    <input type="radio" name="amount" value="200000" class="d-none" {{ old('amount') == 200000 ? 'checked' : '' }}>
                                    <h6 class="text-muted mb-2">Cao cấp</h6>
                                    <div class="points-amount text-dark mb-2">2,600 điểm</div>
                                    <div class="price-amount mb-2">200.000đ</div>
                                    <p class="text-success small mb-0">+30% bonus</p>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="package-card popular {{ old('amount') == 500000 ? 'selected' : '' }}">
                                    <input type="radio" name="amount" value="500000" class="d-none" {{ old('amount') == 500000 ? 'checked' : '' }}>
                                    <h6 class="text-muted mb-2">VIP</h6>
                                    <div class="points-amount text-dark mb-2">7,500 điểm</div>
                                    <div class="price-amount mb-2">500.000đ</div>
                                    <p class="text-success small mb-0">+50% bonus</p>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="package-card" onclick="document.getElementById('customAmountCard').style.display='block'">
                                    <i class="bi bi-plus-circle text-orange mb-2" style="font-size: 2rem;"></i>
                                    <h6 class="mb-2">Tùy chỉnh</h6>
                                    <p class="text-muted small mb-0">Nhập số tiền bất kỳ</p>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Amount Input -->
                        <div class="card border-0 shadow-sm mb-4" id="customAmountCard" style="display: none;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Nhập số tiền tùy chỉnh</h5>
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label">Số tiền (VNĐ)</label>
                                        <input type="number" name="custom_amount" class="form-control form-control-lg" id="customAmountInput" 
                                               placeholder="Nhập số tiền" min="10000" step="1000">
                                        <small class="text-muted">Tối thiểu: 10,000đ</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ước tính nhận được</label>
                                        <div class="fs-4 fw-bold text-orange" id="customPointsPreview">0 điểm</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="payment-method {{ old('payment_method') == 'vnpay' || !old('payment_method') ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="vnpay" class="d-none" {{ old('payment_method') == 'vnpay' || !old('payment_method') ? 'checked' : '' }}>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-credit-card text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h6 class="mb-0">VNPay</h6>
                                            <small class="text-muted">Thanh toán qua VNPay</small>
                                        </div>
                                        <i class="bi bi-check-circle-fill text-orange ms-auto"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-method {{ old('payment_method') == 'momo' ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="momo" class="d-none" {{ old('payment_method') == 'momo' ? 'checked' : '' }}>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-qr-code text-danger me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h6 class="mb-0">MoMo</h6>
                                            <small class="text-muted">Thanh toán qua MoMo</small>
                                        </div>
                                        <i class="bi bi-check-circle-fill text-orange ms-auto"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-method {{ old('payment_method') == 'zalo' ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="zalo" class="d-none" {{ old('payment_method') == 'zalo' ? 'checked' : '' }}>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-hexagon text-info me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h6 class="mb-0">ZaloPay</h6>
                                            <small class="text-muted">Thanh toán qua ZaloPay</small>
                                        </div>
                                        <i class="bi bi-check-circle-fill text-orange ms-auto"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-method {{ old('payment_method') == 'banking' ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="banking" class="d-none" {{ old('payment_method') == 'banking' ? 'checked' : '' }}>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-bank text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h6 class="mb-0">Chuyển khoản</h6>
                                            <small class="text-muted">ATM/Internet Banking</small>
                                        </div>
                                        <i class="bi bi-check-circle-fill text-orange ms-auto"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill" id="submitBtn">
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
                                    @forelse($transactions as $transaction)
                                    <div class="list-group-item transaction-item px-3 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $transaction->type === 'recharge' ? 'Nạp tiền ' . ucfirst($transaction->payment_method) : 'Thanh toán sách' }}</h6>
                                                <small class="text-muted">{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                                <p class="mb-0 mt-1">
                                                    @if($transaction->points > 0)
                                                        <span class="badge bg-success">+{{ $transaction->points }} điểm</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $transaction->points }} điểm</span>
                                                    @endif
                                                </p>
                                            </div>
                                            @if($transaction->amount > 0)
                                                <span class="text-success fw-bold">{{ number_format($transaction->amount) }}đ</span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="list-group-item text-center py-4">
                                        <p class="text-muted mb-0">Chưa có giao dịch</p>
                                    </div>
                                    @endforelse
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
            </form>
        </div>
    </section>

    @include('user.component.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Package selection
    document.querySelectorAll('.package-card input[type="radio"]').forEach(input => {
        input.closest('.package-card').addEventListener('click', function() {
            document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Payment method selection
    document.querySelectorAll('.payment-method input[type="radio"]').forEach(input => {
        input.closest('.payment-method').addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(m => {
                m.classList.remove('selected');
                m.querySelector('.bi-check-circle-fill').style.display = 'none';
            });
            this.classList.add('selected');
            this.querySelector('.bi-check-circle-fill').style.display = 'block';
        });
    });
});
</script>
@endpush
