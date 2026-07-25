<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $member = $request->user()->member;

        $reports = $member?->reports()->latest('activity_date')->take(5)->get() ?? collect();
        $totalReports = $member?->reports()->count() ?? 0;

        return view('member.dashboard', compact('member', 'reports', 'totalReports'));
    }
}
