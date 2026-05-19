<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Tag;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'authors', 'user']);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_points', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price_points', 'asc');
                break;
            case 'views':
                $query->orderBy('view_count', 'desc');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $books = $query->paginate(15);

        // Get filter options
        $categories = Category::orderBy('name')->get();

        return view('admin.books', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.books.create', compact('categories', 'authors', 'publishers', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:books,slug',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'price_points' => 'required|integer|min:0',
            'file_path' => 'required|file|mimes:pdf,epub|max:51200',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['authors', 'tags', 'thumbnail', 'file_path']);
        
        $slug = $request->slug ?? Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $data['slug'] = $slug;
        $data['user_id'] = auth()->id();
        $data['status'] = $request->status ?? 'approved';

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $data['file_path'] = $file->store('books', 'public');
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->thumbnail->store('covers', 'public');
        }

        $book = Book::create($data);

        // Sync authors
        if ($request->has('authors')) {
            $book->authors()->sync($request->authors);
        }

        // Sync tags
        if ($request->has('tags')) {
            $book->tags()->sync($request->tags);
        }

        return redirect()->route('admin.books.index')->with('success', 'Sách đã được tạo thành công!');
    }

    public function edit($id)
    {
        $book = Book::with(['authors', 'tags'])->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories', 'authors', 'publishers', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:books,slug,' . $id,
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $id,
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'price_points' => 'required|integer|min:0',
            'file_path' => 'nullable|file|mimes:pdf,epub|max:51200',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['authors', 'tags', 'thumbnail', 'file_path']);

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $file = $request->file('file_path');
            $data['file_path'] = $file->store('books', 'public');
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($book->thumbnail) {
                Storage::disk('public')->delete($book->thumbnail);
            }
            $data['thumbnail'] = $request->thumbnail->store('covers', 'public');
        }

        $book->update($data);

        // Sync authors
        if ($request->has('authors')) {
            $book->authors()->sync($request->authors);
        }

        // Sync tags
        if ($request->has('tags')) {
            $book->tags()->sync($request->tags);
        }

        return redirect()->route('admin.books.index')->with('success', 'Sách đã được cập nhật!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Delete files
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        if ($book->thumbnail) {
            Storage::disk('public')->delete($book->thumbnail);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Sách đã được xóa!');
    }

    public function approve($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['status' => 'approved']);

        // Notify user
        if ($book->user_id) {
            Notification::create([
                'user_id' => $book->user_id,
                'type' => 'book_approved',
                'title' => 'Sách được duyệt',
                'content' => 'Sách "' . $book->title . '" đã được duyệt và hiển thị trên website.',
                'link' => route('books.show', $book->slug),
                'icon' => 'bi-check-circle',
                'icon_color' => 'success',
            ]);
        }

        return redirect()->back()->with('success', 'Sách đã được duyệt!');
    }

    public function reject($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['status' => 'rejected']);

        // Notify user
        if ($book->user_id) {
            Notification::create([
                'user_id' => $book->user_id,
                'type' => 'book_rejected',
                'title' => 'Sách bị từ chối',
                'content' => 'Sách "' . $book->title . '" không được duyệt. Vui lòng kiểm tra lại.',
                'link' => route('books.show', $book->slug),
                'icon' => 'bi-x-circle',
                'icon_color' => 'danger',
            ]);
        }

        return redirect()->back()->with('error', 'Sách đã bị từ chối!');
    }
}
