<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = \DB::table('tags')
            ->leftJoin('book_tag', 'tags.id', '=', 'book_tag.tag_id')
            ->leftJoin('books', function ($join) {
                $join->on('book_tag.book_id', '=', 'books.id')
                    ->whereNull('books.deleted_at');
            })
            ->select('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at', \DB::raw('COUNT(DISTINCT books.id) as books_count'))
            ->groupBy('tags.id', 'tags.name', 'tags.slug', 'tags.color', 'tags.created_at', 'tags.updated_at')
            ->latest('tags.created_at')
            ->paginate(15);

        return view('admin.tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được tạo!');
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được cập nhật!');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được xóa!');
    }
}
