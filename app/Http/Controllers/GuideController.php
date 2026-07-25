<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GuideController extends Controller
{
    public function admin(): View
    {
        return view('admin.guide');
    }

    public function member(): View
    {
        return view('member.guide');
    }
}
