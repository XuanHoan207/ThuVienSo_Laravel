<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = PointsTransaction::with('user');

        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(15);

        // Stats
        $totalRecharge = PointsTransaction::where('type', 'recharge')->where('status', 'completed')->sum('amount');
        $totalPointsGiven = PointsTransaction::where('status', 'completed')->sum('points');
        $totalTransactions = PointsTransaction::count();
        $monthlyRecharge = PointsTransaction::where('type', 'recharge')
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        return view('admin.transactions', compact(
            'transactions', 'totalRecharge', 'totalPointsGiven', 'totalTransactions', 'monthlyRecharge'
        ));
    }
}
