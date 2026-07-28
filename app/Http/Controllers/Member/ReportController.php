<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = $request->user()->member->reports()->latest('activity_date')->paginate(10);

        return view('member.reports.index', compact('reports'));
    }

    public function create(): View
    {
        return view('member.reports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $member = $request->user()->member;

        $report = $member->reports()->create(collect($data)->except(['photos', 'video', 'remove_video'])->all());

        $this->storeVideo($request, $report);
        $this->storePhotos($request, $report);

        return redirect()->route('member.reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Request $request, Report $report): View
    {
        $this->authorizeOwner($request, $report);
        $report->load('photos');

        return view('member.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $this->authorizeOwner($request, $report);

        $data = $this->validateData($request);
        $report->update(collect($data)->except(['photos', 'video', 'remove_video'])->all());

        $this->storeVideo($request, $report);
        $this->storePhotos($request, $report);

        return redirect()->route('member.reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Request $request, Report $report): RedirectResponse
    {
        $this->authorizeOwner($request, $report);

        foreach ($report->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }
        if ($report->cover_photo) {
            Storage::disk('public')->delete($report->cover_photo);
        }
        if ($report->hasVideoFile()) {
            Storage::disk('public')->delete($report->video);
        }
        $report->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function destroyPhoto(Request $request, Report $report, ReportPhoto $photo): RedirectResponse
    {
        $this->authorizeOwner($request, $report);
        abort_if($photo->report_id !== $report->id, 404);

        Storage::disk('public')->delete($photo->photo);

        if ($report->cover_photo === $photo->photo) {
            $report->update(['cover_photo' => null]);
        }

        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    private function authorizeOwner(Request $request, Report $report): void
    {
        abort_if($report->member_id !== $request->user()->member?->id, 403);
    }

    private function storeVideo(Request $request, Report $report): void
    {
        if ($request->boolean('remove_video') && $report->video) {
            if ($report->hasVideoFile()) {
                Storage::disk('public')->delete($report->video);
            }
            $report->update(['video' => null]);
        }

        if ($request->hasFile('video')) {
            if ($report->hasVideoFile()) {
                Storage::disk('public')->delete($report->video);
            }
            $path = $request->file('video')->store('reports/videos', 'public');
            $report->update(['video' => $path]);
        }
    }

    private function storePhotos(Request $request, Report $report): void
    {
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $i => $file) {
                $path = $file->store('reports', 'public');
                ReportPhoto::create([
                    'report_id' => $report->id,
                    'photo' => $path,
                    'order' => $i,
                ]);

                if (! $report->cover_photo) {
                    $report->update(['cover_photo' => $path]);
                }
            }
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'photos.*' => ['nullable', 'image', 'max:4096'],
            // 30MB
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:30720'],
            'remove_video' => ['nullable', 'boolean'],
        ], [
            'video.max' => 'Ukuran video maksimal 30MB.',
            'video.mimetypes' => 'Format video harus MP4, WebM, atau MOV.',
        ]);
    }
}
