<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $data = $request->except('status');
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('sliders', 'public');
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider đã được tạo!');
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $data = $request->except('status');
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->image->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider đã được cập nhật!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider đã được xóa!');
    }
}
