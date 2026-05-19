<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'book']);

        if ($request->has('search') && $request->search) {
            $query->where('content', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $comments = $query->latest()->paginate(15);

        // Stats
        $totalComments = Comment::count();
        $pendingComments = Comment::where('status', 'pending')->count();
        $approvedComments = Comment::where('status', 'approved')->count();
        $rejectedComments = Comment::where('status', 'rejected')->count();

        return view('admin.reviews', compact('comments', 'totalComments', 'pendingComments', 'approvedComments', 'rejectedComments'));
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Bình luận đã được duyệt!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa!');
    }
}
