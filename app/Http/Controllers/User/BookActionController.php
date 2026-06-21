<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Favorite;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Report;
use App\Models\BookDownload;
use App\Models\Purchase;
use App\Models\Notification;
use App\Models\PointsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookActionController extends Controller
{
    // Add to cart (store in session)
    public function addToCart(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Check if already purchased
        if (Auth::check() && Auth::user()->hasPurchased($book)) {
            return response()->json(['error' => 'Bạn đã mua sách này rồi!'], 400);
        }

        // Get cart from session
        $cart = session()->get('cart', []);

        // Add to cart if not exists
        if (!isset($cart[$book->id])) {
            $cart[$book->id] = [
                'book_id' => $book->id,
                'title' => $book->title,
                'price' => $book->price_points,
                'thumbnail' => $book->thumbnail,
            ];
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng!',
            'cart_count' => count($cart),
        ]);
    }

    // Toggle wishlist
    public function toggleWishlist(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập!',
            ], 401);
        }

        $book = Book::findOrFail($id);
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($favorite) {
            if ($favorite->status === 'active') {
                $favorite->update(['status' => 'inactive']);
                $isFavorited = false;
                $message = 'Đã xóa khỏi yêu thích!';
            } else {
                $favorite->update(['status' => 'active']);
                $isFavorited = true;
                $message = 'Đã thêm vào yêu thích!';
            }
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => 'active',
            ]);
            $isFavorited = true;
            $message = 'Đã thêm vào yêu thích!';
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $message,
        ]);
    }

    // Store review/rating
    public function storeReview(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập!'], 401);
        }

        $book = Book::findOrFail($request->book_id);

        // Check if already reviewed
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingRating) {
            return response()->json(['error' => 'Bạn đã đánh giá sách này rồi!'], 400);
        }

        // Create rating
        $rating = Rating::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        // Update book rating avg
        $book->updateRating();

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã đánh giá!',
        ]);
    }

    // Store comment
    public function storeComment(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập!'], 401);
        }

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'status' => 'approved', // Auto approve for now
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được đăng!',
            'comment' => $comment->load('user'),
        ]);
    }

    // Report book
    public function reportBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'type' => 'required|in:copyright,inappropriate,broken_link,other',
            'reason' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã báo cáo! Chúng tôi sẽ xem xét sớm nhất.',
        ]);
    }

    // Download book
    public function downloadBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Check if user has purchased or has enough points
        if (Auth::check()) {
            $user = Auth::user();
            
            if (!$user->hasPurchased($book) && $user->points < $book->price_points) {
                return redirect()->back()->with('error', 'Bạn không đủ điểm để tải sách này!');
            }

            if (!$user->hasPurchased($book)) {
                // Deduct points
                $user->deductPoints($book->price_points);
                
                // Create purchase
                Purchase::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'price_paid' => $book->price_points,
                    'payment_type' => 'points',
                ]);

                // Record transaction
                PointsTransaction::create([
                    'user_id' => $user->id,
                    'amount' => 0,
                    'points' => -$book->price_points,
                    'type' => 'purchase',
                    'status' => 'completed',
                    'note' => 'Mua sách: ' . $book->title,
                ]);
            }

            // Record download
            BookDownload::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
            ]);

            // Increment download count
            $book->incrementDownloadCount();

            // Return file download
            return response()->download(storage_path('app/public/' . $book->file_path));
        }

        return redirect()->route('login');
    }
}
