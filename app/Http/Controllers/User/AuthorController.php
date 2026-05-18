<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        // Search
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Filter by letter
        if ($request->has('letter') && $request->letter && $request->letter !== 'all') {
            $query->where('name', 'LIKE', $request->letter . '%');
        }

        $authors = $query->withCount('authoredBooks')
            ->orderBy('name')
            ->paginate(12);

        return view('user.authors', compact('authors'));
    }

    public function show($slug)
    {
        $author = Author::with(['authoredBooks' => function ($query) {
            $query->where('status', 'approved')->with(['category', 'authors']);
        }])
        ->where('slug', $slug)
        ->firstOrFail();

        // Stats
        $totalBooks = $author->authoredBooks()->count();
        $totalViews = $author->authoredBooks()->sum('view_count');
        $avgRating = $author->authoredBooks()->whereNotNull('rating_avg')->where('rating_avg', '>', 0)->avg('rating_avg') ?? 0;

        // Sorting books
        $sortBy = request()->get('sort', 'newest');
        $booksQuery = $author->authoredBooks();

        switch ($sortBy) {
            case 'popular':
                $booksQuery->orderBy('view_count', 'desc');
                break;
            case 'rating':
                $booksQuery->orderBy('rating_avg', 'desc');
                break;
            case 'price_low':
                $booksQuery->orderBy('price_points', 'asc');
                break;
            case 'price_high':
                $booksQuery->orderBy('price_points', 'desc');
                break;
            default:
                $booksQuery->orderBy('created_at', 'desc');
                break;
        }

        $books = $booksQuery->paginate(12);

        // Related authors (same genre/category)
        $categoryIds = $author->authoredBooks()->pluck('category_id')->unique();
        $relatedAuthors = Author::where('id', '!=', $author->id)
            ->whereHas('authoredBooks', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->withCount('authoredBooks')
            ->limit(4)
            ->get();

        return view('user.author-detail', compact(
            'author',
            'books',
            'totalBooks',
            'totalViews',
            'avgRating',
            'relatedAuthors'
        ));
    }
}
