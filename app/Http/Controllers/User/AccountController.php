<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use App\Models\Purchase;
use App\Models\Book;
use App\Models\Favorite;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Stats
        $stats = [
            'total_points' => $user->points,
            'books_purchased' => $user->purchases()->count(),
            'books_downloaded' => $user->bookDownloads()->count(),
            'favorites_count' => $user->favorites()->where('status', 'active')->count(),
            'reviews_count' => $user->ratings()->count(),
            'books_uploaded' => $user->books()->count(),
        ];

        // Tab data
        $purchases = Purchase::with('book.authors')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $downloads = \App\Models\BookDownload::with('book.authors')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $favorites = Favorite::with('book.authors')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $myBooks = Book::with('authors')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Recent activity
        $recentActivity = collect();

        // Recent purchases
        $recentPurchases = Purchase::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentPurchases as $p) {
            if ($p->book) {
                $recentActivity->push([
                    'type' => 'purchase',
                    'title' => 'Mua sách "' . $p->book->title . '"',
                    'points' => -$p->price_paid,
                    'created_at' => $p->created_at,
                ]);
            }
        }

        // Recent point transactions
        $recentPoints = PointsTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentPoints as $pt) {
            $recentActivity->push([
                'type' => 'points',
                'title' => $this->getTransactionTitle($pt),
                'points' => $pt->points,
                'created_at' => $pt->created_at,
            ]);
        }

        $recentActivity = $recentActivity->sortByDesc('created_at')->take(5);

        return view('user.my-account', compact('stats', 'recentActivity', 'purchases', 'downloads', 'favorites', 'myBooks'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'phone', 'address', 'bio']));

        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function getPurchases()
    {
        $purchases = Purchase::with('book.category')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.my-account', compact('purchases'))->with('tab', 'purchases');
    }

    public function getDownloads()
    {
        $downloads = \App\Models\BookDownload::with('book.category')
            ->where('user_id', Auth::id())
            ->orderBy('downloaded_at', 'desc')
            ->paginate(12);

        return view('user.my-account', compact('downloads'))->with('tab', 'downloads');
    }

    public function getFavorites()
    {
        $favorites = Favorite::with(['book.category', 'book.authors'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.my-account', compact('favorites'))->with('tab', 'favorites');
    }

    public function getMyBooks()
    {
        $myBooks = Book::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.my-account', compact('myBooks'))->with('tab', 'mybooks');
    }

    private function getTransactionTitle($transaction)
    {
        switch ($transaction->type) {
            case 'recharge':
                return 'Nạp điểm';
            case 'bonus':
                return 'Thưởng: ' . ($transaction->note ?? '');
            case 'purchase':
                return 'Mua sách';
            case 'download':
                return 'Tải sách';
            default:
                return 'Giao dịch';
        }
    }
}
