<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ReportPhotoController extends Controller
{
    public function destroy(Report $report, ReportPhoto $photo): RedirectResponse
    {
        abort_if($photo->report_id !== $report->id, 404);

        Storage::disk('public')->delete($photo->photo);

        if ($report->cover_photo === $photo->photo) {
            $report->update(['cover_photo' => null]);
        }

        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
