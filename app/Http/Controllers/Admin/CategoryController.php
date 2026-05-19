<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'books'])->withCount('books');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(15);
        $allCategories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.categories', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data = $request->except('image');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Prevent circular reference
        if ($request->parent_id == $id) {
            return redirect()->back()->with('error', 'Danh mục cha không thể là chính nó!');
        }

        $data = $request->except('image');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->image->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Move children to parent null
        $category->children()->update(['parent_id' => null]);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa!');
    }
}
