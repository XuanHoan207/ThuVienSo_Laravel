<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReadProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReaderController extends Controller
{
    protected const FREE_PAGES_LIMIT = 5;

    public function show($slug)
    {
        $book = Book::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);

        if (!$hasPurchased && $book->price_points > 0) {
            return redirect()->route('books.show', $slug)
                ->with('error', 'Bạn cần mua sách để đọc toàn bộ nội dung.');
        }

        $readProgress = null;
        if ($user) {
            $readProgress = BookReadProgress::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();
        }

        $currentPage = $readProgress ? $readProgress->last_page : 1;
        $maxAllowedPage = $hasPurchased ? $book->pages ?? 999 : self::FREE_PAGES_LIMIT;

        $freePagesLimit = self::FREE_PAGES_LIMIT;

        return view('user.book-reader', compact(
            'book',
            'hasPurchased',
            'readProgress',
            'currentPage',
            'maxAllowedPage',
            'freePagesLimit'
        ));
    }

    public function updateProgress(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập!'], 401);
        }

        $request->validate([
            'page' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($id);
        $user = Auth::user();
        $hasPurchased = $user->hasPurchased($book);
        $maxAllowedPage = $hasPurchased ? ($book->pages ?? 999) : self::FREE_PAGES_LIMIT;

        $page = min($request->page, $maxAllowedPage);

        $progress = BookReadProgress::updateOrCreate(
            ['user_id' => $user->id, 'book_id' => $book->id],
            [
                'last_page' => $page,
                'max_pages_read' => $page,
                'last_read_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'current_page' => $page,
            'max_allowed_page' => $maxAllowedPage,
            'is_preview' => !$hasPurchased,
        ]);
    }

    public function getPage(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $maxAllowedPage = $hasPurchased ? ($book->pages ?? 999) : self::FREE_PAGES_LIMIT;

        $page = $request->get('page', 1);
        $page = max(1, min($page, $maxAllowedPage));

        $isPreview = !$hasPurchased && $book->price_points > 0;

        return response()->json([
            'success' => true,
            'page' => $page,
            'total_pages' => $book->pages,
            'max_allowed_page' => $maxAllowedPage,
            'is_preview' => $isPreview,
            'is_preview_ended' => $isPreview && $page >= self::FREE_PAGES_LIMIT,
            'preview_message' => $isPreview 
                ? 'Bạn đã xem miễn phí ' . self::FREE_PAGES_LIMIT . ' trang đầu. Hãy mua sách để đọc tiếp.'
                : null,
            'has_purchased' => $hasPurchased,
        ]);
    }

    public function preview(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $type = $request->get('t', 'preview');

        $isFullAccess = $hasPurchased || $book->price_points == 0 || $type === 'full';
        $previewPages = self::FREE_PAGES_LIMIT;

        return view('user.book-preview', compact(
            'book',
            'hasPurchased',
            'isFullAccess',
            'previewPages'
        ));
    }

    public function previewPdf(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $type = $request->get('t', 'preview');
        $isFullAccess = $hasPurchased || $book->price_points == 0 || $type === 'full';

        // Get the file path
        $filePath = $book->file_path;
        $fullPath = storage_path('app/public/' . $filePath);

        // Check if file exists
        if (!file_exists($fullPath)) {
            return abort(404, 'Tài liệu không tồn tại.');
        }

        // For preview (not purchased), limit to 5 pages
        if (!$isFullAccess) {
            // For now, return the full PDF - in production you'd create a limited PDF
            // or check PDF.js on frontend to limit display
            return response()->file($fullPath);
        }

        return response()->file($fullPath);
    }
}
