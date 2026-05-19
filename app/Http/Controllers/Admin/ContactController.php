<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'unread')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.contacts', compact('contacts', 'stats'));
    }

    public function show($id)
    {
        $contact = ContactMessage::with('user')->findOrFail($id);

        if ($contact->status === 'unread') {
            $contact->markAsRead();
        }

        return view('admin.contacts-show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);

        $contact = ContactMessage::findOrFail($id);
        $contact->reply($request->admin_reply);

        return redirect()->route('admin.contacts.show', $id)->with('success', 'Đã gửi phản hồi thành công.');
    }

    public function destroy($id)
    {
        $contact = ContactMessage::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Đã xóa liên hệ thành công.');
    }

    public function markAsRead($id)
    {
        $contact = ContactMessage::findOrFail($id);
        $contact->markAsRead();

        return redirect()->back()->with('success', 'Đã đánh dấu là đã đọc.');
    }
}
