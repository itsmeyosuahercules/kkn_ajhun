<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportComment;
use App\Models\ReportLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportInteractionController extends Controller
{
    public function toggleLike(Request $request, Report $report): RedirectResponse
    {
        abort_if($report->status !== 'published', 404);

        $user = $request->user();
        $existing = ReportLike::where('report_id', $report->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Suka dibatalkan.');
        }

        ReportLike::create([
            'report_id' => $report->id,
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Anda menyukai laporan ini.');
    }

    public function storeComment(Request $request, Report $report): RedirectResponse
    {
        abort_if($report->status !== 'published', 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        ReportComment::create([
            'report_id' => $report->id,
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function destroyComment(Request $request, ReportComment $comment): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || $comment->user_id === $user->id, 403);

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
