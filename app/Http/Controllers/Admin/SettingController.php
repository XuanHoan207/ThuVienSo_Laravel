<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        $settingsArray = [];
        foreach ($settings as $group => $items) {
            foreach ($items as $item) {
                $settingsArray[$item->key] = $item->value;
            }
        }

        return view('admin.settings', compact('settingsArray'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Cài đặt đã được lưu!');
    }
}
