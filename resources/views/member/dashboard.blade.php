@extends('layouts.dashboard')

@section('title', 'Dashboard Saya')

@section('content')

@if(!$member)
    <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-5 text-sm">
        Profil anggota Anda belum lengkap. Hubungi admin untuk melengkapi data.
    </div>
@else
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-stone-200 p-5 sm:col-span-1 flex items-center gap-4">
        <img src="{{ $member->photoUrl() }}" class="w-14 h-14 rounded-full object-cover">
        <div>
            <p class="font-semibold text-stone-800">{{ $member->user->name }}</p>
            <p class="text-xs text-stone-500">{{ $member->jabatan }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-stone-200 p-5 flex flex-col justify-center">
        <div class="text-3xl font-bold text-emerald-700">{{ $totalReports }}</div>
        <div class="text-stone-500 text-sm">Total Laporan Saya</div>
    </div>
    <div class="bg-white rounded-xl border border-stone-200 p-5 flex flex-col justify-center gap-2">
        <a href="{{ route('member.reports.create') }}" class="bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition text-center">
            + Buat Laporan Baru
        </a>
        <a href="{{ route('member.profile.edit') }}" class="text-emerald-700 text-sm text-center hover:underline">
            Update Profil
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-stone-800">Laporan Terbaru Saya</h2>
        <a href="{{ route('member.reports.index') }}" class="text-emerald-700 text-sm hover:underline">Lihat semua →</a>
    </div>

    @if($reports->isEmpty())
        <p class="text-stone-500 text-sm">Anda belum membuat laporan kegiatan.</p>
    @else
        <div class="divide-y divide-stone-100">
            @foreach($reports as $report)
                <div class="py-3 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-medium text-stone-800 truncate">{{ $report->title }}</p>
                        <p class="text-xs text-stone-500">{{ $report->activity_date->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="shrink-0 text-xs px-2 py-1 rounded-full {{ $report->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $report->status === 'published' ? 'Terbit' : 'Draft' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endif
@endsection
