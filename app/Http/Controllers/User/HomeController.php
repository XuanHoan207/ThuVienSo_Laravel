<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['books' => function ($query) {
            $query->where('status', 'approved');
        }])->whereNull('parent_id')->orderBy('order')->get();

        $newBooks = Book::with(['category', 'authors', 'tags'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        $featuredBooks = Book::with(['category', 'authors', 'tags'])
            ->where('status', 'approved')
            ->whereNotNull('rating_avg')
            ->orderBy('rating_avg', 'desc')
            ->orderBy('rating_count', 'desc')
            ->limit(6)
            ->get();

        $topDownloadedBooks = Book::with(['category', 'authors'])
            ->where('status', 'approved')
            ->orderBy('download_count', 'desc')
            ->limit(6)
            ->get();

        $topRatedBooks = Book::with(['category', 'authors'])
            ->where('status', 'approved')
            ->where('rating_avg', '>=', 4.0)
            ->orderBy('rating_avg', 'desc')
            ->limit(6)
            ->get();

        $trendingTags = DB::table('tags')
            ->leftJoin('book_tag', 'tags.id', '=', 'book_tag.tag_id')
            ->leftJoin('books', function ($join) {
                $join->on('book_tag.book_id', '=', 'books.id')
                    ->where('books.status', 'approved')
                    ->whereNull('books.deleted_at');
            })
            ->select('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at', DB::raw('COUNT(DISTINCT books.id) as books_count'))
            ->groupBy('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at')
            ->orderBy('books_count', 'desc')
            ->limit(10)
            ->get();

        $sliders = Slider::active()->get();

        return view('user.index', compact(
            'categories',
            'newBooks',
            'featuredBooks',
            'topDownloadedBooks',
            'topRatedBooks',
            'trendingTags',
            'sliders'
        ));
    }
}
