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

        // Người đăng sách được đọc miễn phí
        $isUploader = $user && $book->user_id === $user->id;

        if (!$hasPurchased && !$isUploader && $book->price_points > 0) {
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
        $maxAllowedPage = ($hasPurchased || $isUploader) ? $book->pages ?? 999 : self::FREE_PAGES_LIMIT;

        $freePagesLimit = self::FREE_PAGES_LIMIT;

        return view('user.book-reader', compact(
            'book',
            'hasPurchased',
            'isUploader',
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

        $book = Book::where('slug', $id)->orWhere('id', $id)->firstOrFail();
        $user = Auth::user();
        $hasPurchased = $user->hasPurchased($book);
        $isUploader = $book->user_id === $user->id;
        $maxAllowedPage = ($hasPurchased || $isUploader) ? ($book->pages ?? 999) : self::FREE_PAGES_LIMIT;

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
            'is_preview' => !$hasPurchased && !$isUploader,
        ]);
    }

    public function getPage(Request $request, $id)
    {
        $book = Book::where('slug', $id)->orWhere('id', $id)->firstOrFail();
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $isUploader = $user && $book->user_id === $user->id;
        $maxAllowedPage = ($hasPurchased || $isUploader) ? ($book->pages ?? 999) : self::FREE_PAGES_LIMIT;

        $page = $request->get('page', 1);
        $page = max(1, min($page, $maxAllowedPage));

        $isPreview = !$hasPurchased && !$isUploader && $book->price_points > 0;

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
            'is_uploader' => $isUploader,
        ]);
    }

    public function preview(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $isUploader = $user && $book->user_id === $user->id;
        $type = $request->get('t', 'preview');
        $pageParam = $request->get('page', 1);

        $isFullAccess = $hasPurchased || $isUploader || $book->price_points == 0 || $type === 'full';
        $previewPages = self::FREE_PAGES_LIMIT;
        $maxAllowedPage = $isFullAccess ? ($book->pages ?? 999) : $previewPages;

        // Get reading progress
        $readProgress = null;
        if ($user) {
            $readProgress = BookReadProgress::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();
        }
        $currentPage = $readProgress ? $readProgress->last_page : (int)$pageParam;

        return view('user.book-preview', compact(
            'book',
            'hasPurchased',
            'isUploader',
            'isFullAccess',
            'previewPages',
            'currentPage',
            'maxAllowedPage'
        ));
    }

    public function previewPdf(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();
        $user = Auth::user();
        $hasPurchased = $user && $user->hasPurchased($book);
        $isUploader = $user && $book->user_id === $user->id;
        $type = $request->get('t', 'preview');
        $isFullAccess = $hasPurchased || $isUploader || $book->price_points == 0 || $type === 'full';

        // Try multiple possible paths
        $filePaths = [
            storage_path('app/' . $book->file_path),
            storage_path('app/public/' . $book->file_path),
            public_path($book->file_path),
            public_path('storage/' . $book->file_path),
        ];

        // Also check if file_path already contains storage path
        if (str_starts_with($book->file_path, 'storage/')) {
            $filePaths[] = public_path($book->file_path);
            $filePaths[] = storage_path('app/public/' . str_replace('storage/', '', $book->file_path));
        }

        $fullPath = null;
        foreach ($filePaths as $path) {
            \Log::info('Checking path: ' . $path);
            if (file_exists($path)) {
                $fullPath = $path;
                break;
            }
        }

        if (!$fullPath) {
            \Log::error('PDF not found. Tried paths:', $filePaths);
            return abort(404, 'Tài liệu không tồn tại. Path: ' . $book->file_path);
        }

        \Log::info('PDF found at: ' . $fullPath);

        return response()->file($fullPath);
    }
}
