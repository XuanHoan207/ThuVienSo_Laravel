<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'authors', 'tags'])
            ->where('status', 'approved');

        // Search
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by tags
        if ($request->has('tags') && $request->tags) {
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('slug', $tags);
            });
        }

        // Filter by author
        if ($request->has('author') && $request->author) {
            $author = Author::where('slug', $request->author)->first();
            if ($author) {
                $query->whereHas('authors', function ($q) use ($author) {
                    $q->where('authors.id', $author->id);
                });
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_points', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_points', '<=', $request->max_price);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating_avg', '>=', $request->rating);
        }

        // Sort
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating_avg', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price_points', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_points', 'desc');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $books = $query->paginate(12)->withQueryString();

        $categories = Category::whereNull('parent_id')->withCount('books')->get();
        
        $tags = \DB::table('tags')
            ->leftJoin('book_tag', 'tags.id', '=', 'book_tag.tag_id')
            ->leftJoin('books', function ($join) {
                $join->on('book_tag.book_id', '=', 'books.id')
                    ->where('books.status', 'approved')
                    ->whereNull('books.deleted_at');
            })
            ->select('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at', \DB::raw('COUNT(DISTINCT books.id) as books_count'))
            ->groupBy('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at')
            ->orderBy('books_count', 'desc')
            ->limit(10)
            ->get();
            
        $authors = \DB::table('authors')
            ->leftJoin('book_author', 'authors.id', '=', 'book_author.author_id')
            ->leftJoin('books', function ($join) {
                $join->on('book_author.book_id', '=', 'books.id')
                    ->whereNull('books.deleted_at');
            })
            ->select('authors.id', 'authors.name', 'authors.slug', 'authors.bio', 'authors.image', 'authors.email', 'authors.website', 'authors.created_at', 'authors.updated_at', \DB::raw('COUNT(DISTINCT books.id) as authored_books_count'))
            ->groupBy('authors.id', 'authors.name', 'authors.slug', 'authors.bio', 'authors.image', 'authors.email', 'authors.website', 'authors.created_at', 'authors.updated_at')
            ->orderBy('authored_books_count', 'desc')
            ->limit(20)
            ->get();

        return view('user.books', compact(
            'books',
            'categories',
            'tags',
            'authors'
        ));
    }

    public function show($slug)
    {
        $book = Book::with(['category', 'authors', 'tags', 'publisher', 'ratings'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        // Increment view count
        $book->incrementViewCount();

        // Record view
        $book->bookViews()->create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Get related books (same category or overlapping tags)
        $relatedBookIds = \DB::table('book_tag')
            ->whereIn('tag_id', $book->tags->pluck('id'))
            ->where('book_id', '!=', $book->id)
            ->pluck('book_id')
            ->toArray();

        $relatedBooks = Book::with(['authors'])
            ->where('id', '!=', $book->id)
            ->where(function ($query) use ($book, $relatedBookIds) {
                $query->where('category_id', $book->category_id)
                    ->orWhereIn('id', $relatedBookIds);
            })
            ->where('status', 'approved')
            ->limit(4)
            ->get();

        // Check if user has purchased
        $hasPurchased = auth()->check() && auth()->user()->hasPurchased($book);

        // Check if user has favorited
        $hasFavorited = auth()->check() && auth()->user()->hasFavorited($book);

        // Get user's rating if exists
        $userRating = null;
        if (auth()->check()) {
            $userRating = $book->ratings()->where('user_id', auth()->id())->first();
        }

        // Get comments
        $comments = $book->comments()
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $book->ratings()->where('stars', $i)->count();
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $book->rating_count > 0 ? round(($count / $book->rating_count) * 100) : 0,
            ];
        }

        return view('user.books-detail', compact(
            'book',
            'relatedBooks',
            'hasPurchased',
            'hasFavorited',
            'userRating',
            'comments',
            'ratingDistribution'
        ));
    }
}
