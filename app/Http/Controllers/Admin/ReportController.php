<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Book;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'book']);

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(15);

        // Stats
        $pendingCount = Report::where('status', 'pending')->count();
        $resolvedCount = Report::where('status', 'resolved')->count();
        $totalCount = Report::count();

        return view('admin.reports', compact('reports', 'pendingCount', 'resolvedCount', 'totalCount'));
    }

    public function resolve(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'resolved',
            'admin_note' => $request->admin_note,
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        // Handle action
        if ($request->action) {
            switch ($request->action) {
                case 'hide_book':
                    $report->book->update(['status' => 'hidden']);
                    break;
                case 'delete_book':
                    $report->book->delete();
                    break;
                case 'warning_user':
                    if ($report->book->user_id) {
                        Notification::create([
                            'user_id' => $report->book->user_id,
                            'type' => 'warning',
                            'title' => 'Cảnh cáo vi phạm',
                            'content' => 'Nội dung sách "' . $report->book->title . '" đã bị báo cáo vi phạm. Vui lòng kiểm tra lại.',
                            'icon' => 'bi-exclamation-triangle',
                            'icon_color' => 'warning',
                        ]);
                    }
                    break;
                case 'ban_user':
                    if ($report->book->user_id) {
                        User::where('id', $report->book->user_id)->update(['status' => 0]);
                    }
                    break;
            }
        }

        // Notify reporter
        if ($report->user_id) {
            Notification::create([
                'user_id' => $report->user_id,
                'type' => 'report_resolved',
                'title' => 'Báo cáo đã được xử lý',
                'content' => 'Báo cáo của bạn đã được xử lý.',
                'icon' => 'bi-check-circle',
                'icon_color' => 'success',
            ]);
        }

        return redirect()->back()->with('success', 'Báo cáo đã được xử lý!');
    }

    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'rejected']);

        return redirect()->back()->with('info', 'Báo cáo đã bị từ chối!');
    }
}
