<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Report;
use App\Models\PointsTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalBooks = Book::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalOrders = Purchase::count();

        // Monthly revenue
        $monthlyRevenue = PointsTransaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('type', 'recharge')
            ->where('status', 'completed')
            ->sum('amount');

        // Revenue change
        $lastMonthRevenue = PointsTransaction::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->where('type', 'recharge')
            ->where('status', 'completed')
            ->sum('amount');

        $revenueChange = 0;
        if ($lastMonthRevenue > 0) {
            $revenueChange = round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        }

        // New this month
        $newBooksThisMonth = Book::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();

        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('role', '!=', 'admin')->count();

        // New this week
        $newBooksThisWeek = Book::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->where('role', '!=', 'admin')->count();

        // Pending counts
        $pendingBooksCount = Book::where('status', 'pending')->count();
        $pendingReportsCount = Report::where('status', 'pending')->count();
        $pendingOrdersCount = Purchase::count(); // Simplified - no status column in purchases

        // Recent orders
        $recentOrders = Purchase::with(['user', 'book'])
            ->latest()
            ->limit(5)
            ->get();

        // Pending books
        $pendingBooks = Book::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Top books
        $topBooks = Book::with('category')
            ->orderBy('view_count', 'desc')
            ->limit(10)
            ->get();

        // Share data to all admin views
        view()->share([
            'pendingBooksCount' => $pendingBooksCount,
            'pendingReportsCount' => $pendingReportsCount,
            'unreadNotifications' => 0,
        ]);

        return view('admin.dashboard', compact(
            'totalBooks', 'totalUsers', 'totalOrders', 'monthlyRevenue', 'revenueChange',
            'newBooksThisMonth', 'newUsersThisMonth', 'newBooksThisWeek', 'newUsersThisWeek',
            'pendingBooksCount', 'pendingReportsCount', 'pendingOrdersCount',
            'recentOrders', 'pendingBooks', 'topBooks'
        ));
    }
}
