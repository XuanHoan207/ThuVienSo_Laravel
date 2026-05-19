<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use App\Models\Book;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadBookController extends Controller
{
    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();

        return view('user.upload-book', compact('categories', 'tags', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price_points' => 'required|integer|min:0',
            'book_file' => 'required|file|mimes:pdf,epub,mobi|max:51200',
            'thumbnail' => 'nullable|image|max:5120',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
            'tags' => 'nullable|array',
            'authors' => 'nullable|array',
        ]);

        // Handle file uploads
        $filePath = $request->file('book_file')->store('books', 'public');
        
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('covers', 'public');
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Create book
        $book = Book::create([
            'title' => $request->title,
            'slug' => $slug,
            'isbn' => $request->isbn,
            'thumbnail' => $thumbnailPath,
            'file_path' => $filePath,
            'file_size' => $request->file('book_file')->getSize(),
            'file_type' => $request->file('book_file')->getClientOriginalExtension(),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'publisher_id' => 1, // Default publisher
            'user_id' => Auth::id(),
            'published_year' => $request->published_year,
            'pages' => $request->pages,
            'language' => $request->language ?? 'Vietnamese',
            'price_points' => $request->price_points,
            'status' => 'pending',
        ]);

        // Attach authors
        if ($request->has('authors') && is_array($request->authors)) {
            $book->authors()->sync($request->authors);
        }

        // Attach tags
        if ($request->has('tags') && is_array($request->tags)) {
            $book->tags()->attach($request->tags);
        }

        // Create notification for admin
        // Notification::create([
        //     'user_id' => Auth::id(),
        //     'type' => 'book_uploaded',
        //     'title' => 'Sách mới được đăng tải',
        //     'content' => 'Sách "' . $book->title . '" đang chờ duyệt.',
        //     'link' => route('admin.books.show', $book->id),
        // ]);

        return redirect()->to('/my-account')->with('success', 'Sách đã được đăng tải thành công! Sách của bạn sẽ được kiểm duyệt trong 24-48 giờ.');
    }
}
