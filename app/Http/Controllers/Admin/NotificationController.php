<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('user');

        $notifications = $query->latest()->paginate(15);
        $users = User::orderBy('name')->get();

        return view('admin.notifications', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        if ($request->user_id) {
            // Send to specific user
            Notification::create([
                'user_id' => $request->user_id,
                'type' => $request->type ?? 'system',
                'title' => $request->title,
                'content' => $request->content,
                'icon' => 'bi-bell',
                'icon_color' => 'info',
            ]);
        } else {
            // Send to all users
            $users = User::where('role', '!=', 'admin')->get();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => $request->type ?? 'system',
                    'title' => $request->title,
                    'content' => $request->content,
                    'icon' => 'bi-bell',
                    'icon_color' => 'info',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Thông báo đã được gửi!');
    }
}
