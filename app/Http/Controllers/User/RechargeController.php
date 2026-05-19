<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RechargeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $transactions = PointsTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('user.recharge', compact('transactions'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:vnpay,momo,zalo,banking',
        ]);

        $paymentMethod = $request->payment_method;

        if ($paymentMethod === 'vnpay') {
            return $this->checkout($request);
        }

        $points = $this->calculatePoints($request->amount);

        $transaction = PointsTransaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'points' => $points,
            'type' => 'recharge',
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'reference_id' => 'REF' . time(),
        ]);

        $this->completeRecharge($transaction);

        return redirect()->back()->with('success', "Nạp điểm thành công! Bạn đã nhận được {$points} điểm.");
    }

    public function checkout(Request $request)
    {
        $minRecharge = (int) (Setting::get('min_recharge') ?: 10000);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $minRecharge],
        ]);

        $vnpTmnCode = $this->getVnpTmnCode();
        $vnpHashSecret = $this->getVnpHashSecret();
        $vnpUrl = config('services.vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnpReturnUrl = $this->getVnpReturnUrl();

        if (!$vnpTmnCode || !$vnpHashSecret) {
            return back()->withInput()->with('error', 'Thiếu cấu hình VNPAY. Vui lòng cập nhật TmnCode và HashSecret trong trang quản trị.');
        }
        
        $vnpTxnRef = $this->generateTxnRef();
        $vnpOrderInfo = 'Nạp điểm cho người dùng ' . Auth::user()->name;
        $vnpAmount = (int) $request->amount * 100;
        $vnpBankCode = $request->payment_method === 'vnpay' ? $request->bank_code : null;
        $createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $expireAt = (clone $createdAt)->addMinutes(15);

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnpTmnCode,
            'vnp_Amount' => $vnpAmount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => $createdAt->format('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $request->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => $vnpOrderInfo,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $vnpReturnUrl,
            'vnp_TxnRef' => $vnpTxnRef,
            'vnp_ExpireDate' => $expireAt->format('YmdHis'),
        ];

        if (!empty($vnpBankCode)) {
            $inputData['vnp_BankCode'] = $vnpBankCode;
        }

        ksort($inputData);

        $hashData = http_build_query($inputData);
        $query = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        $points = $this->calculatePoints($request->amount);

        PointsTransaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'points' => $points,
            'type' => 'recharge',
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'vnpay',
            'reference_id' => $vnpTxnRef,
        ]);

        return redirect($vnpUrl . '?' . $query . '&vnp_SecureHashType=SHA512&vnp_SecureHash=' . $vnpSecureHash);
    }

    public function vnpayReturn(Request $request)
    {
        $vnpHashSecret = $this->getVnpHashSecret();

        if (!$vnpHashSecret || !$request->has('vnp_SecureHash')) {
            return redirect('/recharge')->with('error', 'Không thể xác thực giao dịch do thiếu cấu hình chữ ký.');
        }

        $inputData = $request->query();
        $vnpSecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);
        ksort($inputData);

        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        if (!hash_equals($secureHash, $vnpSecureHash)) {
            return redirect('/recharge')->with('error', 'Chữ ký thanh toán không hợp lệ.');
        }

        $transaction = PointsTransaction::where('reference_id', $request->vnp_TxnRef)->first();

        if (!$transaction) {
            return redirect('/recharge')->with('error', 'Không tìm thấy giao dịch nạp điểm.');
        }

        if ($request->vnp_ResponseCode === '00') {
            if ($transaction->status === 'pending') {
                $transaction->update(['status' => 'completed']);
                $transaction->user->increment('points', $transaction->points);

                Notification::create([
                    'user_id' => $transaction->user_id,
                    'type' => 'points_recharged',
                    'title' => 'Nạp điểm thành công!',
                    'content' => "Bạn đã nạp thành công {$transaction->points} điểm qua VNPAY.",
                    'icon' => 'bi-wallet2',
                ]);

                return redirect('/recharge')->with('success', 'Nạp điểm thành công! Số dư tài khoản đã được cập nhật.');
            }

            return redirect('/recharge')->with('success', 'Giao dịch đã được xử lý trước đó.');
        }

        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'failed']);
        }

        $errorMessages = [
            '01' => 'Giao dịch đã tồn tại.',
            '02' => 'Truy cập API không hợp lệ.',
            '03' => 'Dữ liệu gửi sang không đúng format.',
            '04' => 'Khóa checksum không hợp lệ.',
            '05' => 'Địa chỉ IP gọi API không hợp lệ.',
            '06' => 'Tài khoản hoặc mật khẩu không đúng.',
            '07' => 'Số tiền giao dịch không hợp lệ.',
            '09' => 'Thẻ/Tài khoản chưa đăng ký dịch vụ.',
            '10' => 'Xác thực thông tin thuê bao không đúng.',
            '11' => 'Đã ghi nhận giao dịch thanh toán.',
            '12' => 'Thẻ bị khóa.',
            '13' => 'Nhập sai thông tin xác thực.',
            '24' => 'Khách hàng đã hủy giao dịch.',
            '75' => 'Ngân hàng đang bảo trì.',
            '79' => 'Nhập sai số lần otp.',
            '99' => 'Người dùng hủy giao dịch.',
        ];

        $errorMsg = $errorMessages[$request->vnp_ResponseCode] ?? 'Thanh toán không thành công hoặc đã bị hủy.';

        return redirect('/recharge')->with('error', $errorMsg);
    }

    private function getVnpTmnCode(): ?string
    {
        return Setting::get('vnp_TmnCode') ?: config('services.vnpay.tmn_code');
    }

    private function getVnpHashSecret(): ?string
    {
        return Setting::get('vnp_HashSecret') ?: config('services.vnpay.hash_secret');
    }

    private function getVnpReturnUrl(): string
    {
        return config('services.vnpay.return_url') ?: route('recharge.vnpay_return');
    }

    private function generateTxnRef(): string
    {
        return Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis') . random_int(1000, 9999);
    }

    private function calculatePoints($amount)
    {
        // Base rate: 1,000 VND = 1 point
        return (int) floor($amount / 1000);
    }

    private function completeRecharge(PointsTransaction $transaction)
    {
        $user = Auth::user();

        // Update transaction status
        $transaction->update(['status' => 'completed']);

        // Add points to user
        $user->addPoints($transaction->points);

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'type' => 'points_recharged',
            'title' => 'Nạp điểm thành công!',
            'content' => "Bạn đã nạp thành công {$transaction->points} điểm qua {$transaction->payment_method}.",
            'icon' => 'bi-wallet2',
        ]);
    }

    public function callback(Request $request)
    {
        // Handle payment gateway callback
        // This would be implemented based on the payment provider

        return redirect()->route('recharge')->with('success', 'Thanh toán thành công!');
    }
}
