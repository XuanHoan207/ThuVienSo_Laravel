<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->avatar->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Hồ sơ đã được cập nhật!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi!');
    }
}
