<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportComment;
use App\Models\ReportLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportInteractionController extends Controller
{
    public function toggleLike(Request $request, Report $report): JsonResponse
    {
        abort_if($report->status !== 'published', 404);

        $user = $request->user();
        $existing = ReportLike::where('report_id', $report->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
            $message = 'Suka dibatalkan.';
        } else {
            ReportLike::create([
                'report_id' => $report->id,
                'user_id' => $user->id,
            ]);
            $liked = true;
            $message = 'Anda menyukai laporan ini.';
        }

        $likesCount = $report->likes()->count();

        // Selalu JSON: endpoint ini dipanggil via AJAX dari halaman detail
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $message,
        ]);
    }

    public function storeComment(Request $request, Report $report): JsonResponse
    {
        abort_if($report->status !== 'published', 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        $comment = ReportComment::create([
            'report_id' => $report->id,
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        $comment->load('user');

        return response()->json([
            'message' => 'Komentar berhasil dikirim.',
            'comments_count' => $report->comments()->count(),
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'user_name' => $comment->user->name,
                'user_initial' => strtoupper(substr($comment->user->name, 0, 1)),
                'created_at' => $comment->created_at->diffForHumans(),
                'can_delete' => true,
                'delete_url' => route('reports.comments.destroy', $comment),
            ],
        ]);
    }

    public function destroyComment(Request $request, ReportComment $comment): JsonResponse
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || $comment->user_id === $user->id, 403);

        $report = $comment->report;
        $comment->delete();

        return response()->json([
            'message' => 'Komentar dihapus.',
            'comments_count' => $report->comments()->count(),
        ]);
    }
}
