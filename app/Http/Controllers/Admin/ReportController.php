<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
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
        $reports = Report::with('member.user')
            ->when($request->search, fn ($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->latest('activity_date')
            ->paginate(12)
            ->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function create(): View
    {
        $members = Member::with('user')->get();

        return view('admin.reports.create', compact('members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $report = Report::create($data);

        $this->storePhotos($request, $report);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Report $report): View
    {
        $members = Member::with('user')->get();
        $report->load('photos');

        return view('admin.reports.edit', compact('report', 'members'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $data = $this->validateData($request);

        $report->update($data);

        $this->storePhotos($request, $report);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        foreach ($report->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }
        if ($report->cover_photo) {
            Storage::disk('public')->delete($report->cover_photo);
        }
        $report->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
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
            'member_id' => ['required', 'exists:members,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'photos.*' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
