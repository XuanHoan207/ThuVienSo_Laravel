<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\BookDownload;
use App\Models\PointsTransaction;
use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $type = $request->get('type', 'all');

        // Get purchases
        $purchases = Purchase::with('book')
            ->where('user_id', $user->id)
            ->when($type === 'purchase', function ($q) {
                return $q;
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get downloads
        $downloads = BookDownload::with('book')
            ->where('user_id', $user->id)
            ->when($type === 'download', function ($q) {
                return $q;
            })
            ->orderBy('downloaded_at', 'desc')
            ->get();

        // Get point transactions
        $pointTransactions = PointsTransaction::where('user_id', $user->id)
            ->when($type === 'points', function ($q) {
                return $q;
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get uploaded books
        $uploads = Book::where('user_id', $user->id)
            ->when($type === 'upload', function ($q) {
                return $q;
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Stats
        $stats = [
            'total_purchases' => $purchases->count(),
            'total_downloads' => $downloads->count(),
            'total_points_spent' => $pointTransactions->where('type', 'purchase')->sum('points'),
            'total_points_earned' => $pointTransactions->whereIn('type', ['recharge', 'bonus'])->sum('points'),
        ];

        // Merge all history items
        $history = collect();
        
        if ($type === 'all' || $type === 'purchase') {
            foreach ($purchases as $p) {
                $history->push([
                    'type' => 'purchase',
                    'title' => 'Mua sách "' . $p->book->title . '"',
                    'description' => $p->book->category->name ?? '',
                    'points' => -$p->price_paid,
                    'status' => 'completed',
                    'created_at' => $p->created_at,
                    'book' => $p->book,
                ]);
            }
        }

        if ($type === 'all' || $type === 'points') {
            foreach ($pointTransactions as $pt) {
                if ($pt->type === 'purchase') continue; // Skip, already added in purchases
                $history->push([
                    'type' => 'points',
                    'title' => $this->getPointTransactionTitle($pt),
                    'description' => $pt->payment_method ?? '',
                    'points' => $pt->points,
                    'status' => $pt->status,
                    'created_at' => $pt->created_at,
                ]);
            }
        }

        if ($type === 'all' || $type === 'download') {
            foreach ($downloads as $d) {
                $history->push([
                    'type' => 'download',
                    'title' => 'Tải sách "' . $d->book->title . '"',
                    'description' => $d->book->category->name ?? '',
                    'points' => 0,
                    'status' => 'completed',
                    'created_at' => $d->downloaded_at,
                    'book' => $d->book,
                ]);
            }
        }

        if ($type === 'all' || $type === 'upload') {
            foreach ($uploads as $u) {
                $history->push([
                    'type' => 'upload',
                    'title' => 'Đăng sách "' . $u->title . '"',
                    'description' => 'Trạng thái: ' . $u->status,
                    'points' => 0,
                    'status' => $u->status,
                    'created_at' => $u->created_at,
                    'book' => $u,
                ]);
            }
        }

        // Merge and sort history
        $history = $history->sortByDesc('created_at')->values();
        
        // Manual pagination
        $perPage = 20;
        $currentPage = \Illuminate\Support\Facades\Request::input('page', 1);
        $total = $history->count();
        $paginatedHistory = $history->forPage($currentPage, $perPage);
        
        $history = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedHistory,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('history')]
        );

        return view('user.history', compact('history', 'stats'));
    }

    private function getPointTransactionTitle($transaction)
    {
        switch ($transaction->type) {
            case 'recharge':
                return 'Nạp điểm qua ' . ($transaction->payment_method ?? 'không rõ');
            case 'bonus':
                return 'Thưởng ' . $transaction->note;
            case 'refund':
                return 'Hoàn điểm';
            default:
                return 'Giao dịch điểm';
        }
    }
}
