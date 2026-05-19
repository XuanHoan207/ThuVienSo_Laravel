<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->paginate(15);
        return view('admin.publishers', compact('publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->except('logo');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->logo->store('publishers', 'public');
        }

        Publisher::create($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã được tạo!');
    }

    public function update(Request $request, $id)
    {
        $publisher = Publisher::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->except('logo');
        $data['slug'] = $request->slug ?? Str::slug($request->name);

        if ($request->hasFile('logo')) {
            if ($publisher->logo) {
                Storage::disk('public')->delete($publisher->logo);
            }
            $data['logo'] = $request->logo->store('publishers', 'public');
        }

        $publisher->update($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã được cập nhật!');
    }

    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);

        if ($publisher->books()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa nhà xuất bản có sách!');
        }

        if ($publisher->logo) {
            Storage::disk('public')->delete($publisher->logo);
        }

        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã được xóa!');
    }
}
