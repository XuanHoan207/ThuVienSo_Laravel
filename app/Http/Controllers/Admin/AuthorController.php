<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::select('authors.*')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('book_author')
                    ->whereColumn('author_id', 'authors.id');
            }, 'books_count')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('admin.authors', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:authors,email',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('authors', 'public');
        }

        Author::create($data);

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được tạo!');
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:authors,email,' . $id,
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($author->image) {
                Storage::disk('public')->delete($author->image);
            }
            $data['image'] = $request->image->store('authors', 'public');
        }

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được cập nhật!');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        if ($author->authoredBooks()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa tác giả có sách!');
        }

        if ($author->image) {
            Storage::disk('public')->delete($author->image);
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được xóa!');
    }
}
