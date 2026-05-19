<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorites = Favorite::with(['book.category', 'book.authors'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.wishlist', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập!',
                'is_authenticated' => false
            ], 401);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($favorite) {
            if ($favorite->status === 'active') {
                $favorite->update(['status' => 'inactive']);
                $favoriteCount = Favorite::where('book_id', $book->id)
                    ->where('status', 'active')
                    ->count();
                return response()->json([
                    'success' => true,
                    'is_favorited' => false,
                    'message' => 'Đã xóa khỏi yêu thích!',
                    'count' => $favoriteCount,
                ]);
            } else {
                $favorite->update(['status' => 'active']);
                $favoriteCount = Favorite::where('book_id', $book->id)
                    ->where('status', 'active')
                    ->count();
                return response()->json([
                    'success' => true,
                    'is_favorited' => true,
                    'message' => 'Đã thêm vào yêu thích!',
                    'count' => $favoriteCount,
                ]);
            }
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => 'active',
            ]);
            $favoriteCount = Favorite::where('book_id', $book->id)
                ->where('status', 'active')
                ->count();
            return response()->json([
                'success' => true,
                'is_favorited' => true,
                'message' => 'Đã thêm vào yêu thích!',
                'count' => $favoriteCount,
            ]);
        }
    }
}
