<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['user', 'book']);

        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('payment_type') && $request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        $orders = $query->latest()->paginate(15);

        // Stats
        $stats = [
            'total' => Purchase::count(),
            'revenue' => Purchase::sum('price_paid'),
            'completed' => Purchase::where('payment_type', '!=', 'cancelled')->count(),
            'cancelled' => Purchase::where('payment_type', 'cancelled')->count(),
        ];

        return view('admin.orders', compact('orders', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        // Handle refund if cancelled
        if ($request->status === 'cancelled' && $purchase->user) {
            $purchase->user->increment('points', $purchase->price_paid);
        }

        $purchase->update(['payment_type' => $request->status]);

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật!');
    }
}
