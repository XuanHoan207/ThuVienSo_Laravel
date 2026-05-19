<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Get book details
        $bookIds = array_keys($cart);
        $books = Book::whereIn('id', $bookIds)->get()->keyBy('id');
        
        $cartItems = [];
        foreach ($cart as $id => $item) {
            if (isset($books[$id])) {
                $cartItems[] = [
                    'book' => $books[$id],
                    'quantity' => $item['quantity'] ?? 1,
                ];
            }
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['book']->price_points * $item['quantity'];
        });

        $userPoints = Auth::check() ? Auth::user()->points : 0;
        $discount = 0; // Apply discount logic here
        $total = $subtotal - $discount;

        return view('user.cart', compact('cartItems', 'subtotal', 'discount', 'total', 'userPoints'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (Auth::check() && Auth::user()->hasPurchased($book)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã mua sách này rồi!'
                ]);
            }
            return redirect()->back()->with('error', 'Bạn đã mua sách này rồi!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sách đã có trong giỏ hàng!'
                ]);
            }
            return redirect()->back()->with('error', 'Sách đã có trong giỏ hàng!');
        }

        $cart[$book->id] = [
            'book_id' => $book->id,
            'quantity' => 1,
        ];
        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm "' . $book->title . '" vào giỏ hàng!',
                'cartCount' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function remove(Request $request, $bookId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa khỏi giỏ hàng!');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }

        $user = Auth::user();
        $bookIds = array_keys($cart);
        $books = Book::whereIn('id', $bookIds)->get()->keyBy('id');

        $totalPoints = 0;
        foreach ($cart as $id => $item) {
            if (isset($books[$id])) {
                $totalPoints += $books[$id]->price_points * ($item['quantity'] ?? 1);
            }
        }

        if ($user->points < $totalPoints) {
            return redirect()->route('cart')->with('error', 'Bạn không đủ điểm! Vui lòng nạp thêm.');
        }

        // Process purchase
        foreach ($cart as $bookId => $item) {
            if (isset($books[$bookId]) && !$user->hasPurchased($books[$bookId])) {
                $book = $books[$bookId];
                
                // Deduct points
                $user->deductPoints($book->price_points);
                
                // Create purchase record
                \App\Models\Purchase::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'price_paid' => $book->price_points,
                    'payment_type' => 'points',
                ]);

                // Record transaction
                \App\Models\PointsTransaction::create([
                    'user_id' => $user->id,
                    'amount' => 0,
                    'points' => -$book->price_points,
                    'type' => 'purchase',
                    'status' => 'completed',
                    'note' => 'Mua sách: ' . $book->title,
                ]);
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('history')->with('success', 'Thanh toán thành công! Các sách đã được thêm vào thư viện của bạn.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Đã xóa giỏ hàng!');
    }
}
