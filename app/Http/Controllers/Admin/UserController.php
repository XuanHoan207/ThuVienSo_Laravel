<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('status', 1);
            } elseif ($request->status === 'banned') {
                $query->where('status', 0);
            }
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'points' => 'nullable|integer|min:0',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được cập nhật!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản admin!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa!');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Không thể khóa tài khoản admin!');
        }

        $user->update(['status' => 0]);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_banned',
            'title' => 'Tài khoản bị khóa',
            'content' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ admin để được hỗ trợ.',
            'icon' => 'bi-ban',
            'icon_color' => 'danger',
        ]);

        return redirect()->back()->with('success', 'Tài khoản đã bị khóa!');
    }

    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 1]);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_unbanned',
            'title' => 'Tài khoản đã được mở khóa',
            'content' => 'Tài khoản của bạn đã được mở khóa.',
            'icon' => 'bi-unlock',
            'icon_color' => 'success',
        ]);

        return redirect()->back()->with('success', 'Tài khoản đã được mở khóa!');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:user,author,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Vai trò đã được cập nhật!');
    }

    public function export(Request $request)
    {
        // Return Excel export (simplified)
        return redirect()->back();
    }
}
