<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $stats = [
            'members' => Member::count(),
            'reports' => Report::published()->count(),
            'photos' => \App\Models\ReportPhoto::count(),
        ];

        $latestReports = Report::published()->with('member.user')->latest('activity_date')->take(6)->get();
        $members = Member::with('user')->take(8)->get();

        return view('public.home', compact('stats', 'latestReports', 'members'));
    }

    public function directory(): View
    {
        $members = Member::with(['user', 'reports'])->paginate(12);

        return view('public.directory', compact('members'));
    }

    public function profile(Member $member): View
    {
        $member->load('user');
        $reports = $member->reports()->published()->latest('activity_date')->paginate(6);

        return view('public.profile', compact('member', 'reports'));
    }

    public function timeline(): View
    {
        $reports = Report::published()->with('member.user')->latest('activity_date')->paginate(10);

        return view('public.timeline', compact('reports'));
    }

    public function gallery(): View
    {
        $photos = \App\Models\ReportPhoto::with('report.member.user')
            ->whereHas('report', fn ($q) => $q->published())
            ->latest()
            ->paginate(24);

        return view('public.gallery', compact('photos'));
    }

    public function reportDetail(Report $report): View
    {
        abort_if($report->status !== 'published', 404);
        $report->load('member.user', 'photos');

        return view('public.report-detail', compact('report'));
    }
}
