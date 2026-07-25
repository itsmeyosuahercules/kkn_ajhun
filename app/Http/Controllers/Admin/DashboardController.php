<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Report;
use App\Models\ReportPhoto;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'members' => Member::count(),
            'reports' => Report::count(),
            'photos' => ReportPhoto::count(),
            'published' => Report::where('status', 'published')->count(),
        ];

        $latestReports = Report::with('member.user')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestReports'));
    }
}
