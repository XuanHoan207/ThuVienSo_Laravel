<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use App\Models\Notification;
use Illuminate\Http\Request;
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

        $user = Auth::user();
        $amount = $request->amount;

        // Calculate points with bonus
        $points = $this->calculatePoints($amount);

        // Create pending transaction
        $transaction = PointsTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'points' => $points,
            'type' => 'recharge',
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'reference_id' => 'REF' . time(),
        ]);

        // For demo purposes, auto-complete the recharge
        // In production, redirect to payment gateway
        $this->completeRecharge($transaction);

        return redirect()->back()->with('success', "Nạp điểm thành công! Bạn đã nhận được {$points} điểm.");
    }

    private function calculatePoints($amount)
    {
        // Base rate: 100 points per 10,000 VND
        $basePoints = ($amount / 10000) * 100;

        // Bonus based on amount
        $bonus = 0;
        if ($amount >= 500000) {
            $bonus = 0.5; // 50% bonus
        } elseif ($amount >= 200000) {
            $bonus = 0.3; // 30% bonus
        } elseif ($amount >= 100000) {
            $bonus = 0.2; // 20% bonus
        } elseif ($amount >= 50000) {
            $bonus = 0.1; // 10% bonus
        }

        return (int) floor($basePoints * (1 + $bonus));
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
