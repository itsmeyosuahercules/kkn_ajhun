@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-stone-200 p-5">
        <div class="text-3xl font-bold text-emerald-700">{{ $stats['members'] }}</div>
        <div class="text-stone-500 text-sm mt-1">Total Anggota</div>
    </div>
    <div class="bg-white rounded-xl border border-stone-200 p-5">
        <div class="text-3xl font-bold text-emerald-700">{{ $stats['reports'] }}</div>
        <div class="text-stone-500 text-sm mt-1">Total Laporan</div>
    </div>
    <div class="bg-white rounded-xl border border-stone-200 p-5">
        <div class="text-3xl font-bold text-emerald-700">{{ $stats['published'] }}</div>
        <div class="text-stone-500 text-sm mt-1">Laporan Terbit</div>
    </div>
    <div class="bg-white rounded-xl border border-stone-200 p-5">
        <div class="text-3xl font-bold text-emerald-700">{{ $stats['photos'] }}</div>
        <div class="text-stone-500 text-sm mt-1">Total Foto</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-stone-800">Laporan Terbaru</h2>
        <a href="{{ route('admin.reports.index') }}" class="text-emerald-700 text-sm hover:underline">Lihat semua →</a>
    </div>

    @if($latestReports->isEmpty())
        <p class="text-stone-500 text-sm">Belum ada laporan.</p>
    @else
        <div class="divide-y divide-stone-100">
            @foreach($latestReports as $report)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-medium text-stone-800 truncate">{{ $report->title }}</p>
                        <p class="text-xs text-stone-500">{{ $report->member->user->name }} &middot; {{ $report->activity_date->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="shrink-0 text-xs px-2 py-1 rounded-full {{ $report->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $report->status === 'published' ? 'Terbit' : 'Draft' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
