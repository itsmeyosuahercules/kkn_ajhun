@extends('layouts.app')

@section('title', $member->user->name . ' - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 sm:p-8 mb-10">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <img src="{{ $member->photoUrl() }}" alt="{{ $member->user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-emerald-50 shrink-0">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold text-stone-800">{{ $member->user->name }}</h1>
                <p class="text-emerald-700 font-medium">{{ $member->jabatan }}</p>
                <p class="text-stone-500 text-sm mt-1">{{ $member->jurusan }} @if($member->fakultas)&middot; {{ $member->fakultas }}@endif</p>
                <p class="text-stone-500 text-sm">{{ $member->universitas }}</p>

                @if($member->age || $member->nim)
                    <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3">
                        @if($member->age)<span class="inline-flex items-center text-xs font-medium text-emerald-800 bg-emerald-50 rounded-full px-3 py-1">🎂 {{ $member->age }} tahun</span>@endif
                        @if($member->nim)<span class="inline-flex items-center text-xs font-medium text-stone-600 bg-stone-100 rounded-full px-3 py-1">🆔 NIM {{ $member->nim }}</span>@endif
                    </div>
                @endif

                <div class="flex flex-wrap justify-center sm:justify-start gap-3 mt-3 text-sm text-stone-500">
                    @if($member->phone)<span>📞 {{ $member->phone }}</span>@endif
                    @if($member->instagram)<span>📷 {{ $member->instagram }}</span>@endif
                    @if($member->hobi)<span>🎯 Hobi: {{ $member->hobi }}</span>@endif
                </div>

                @if($member->bio)
                    <p class="text-stone-600 mt-4 leading-relaxed">{{ $member->bio }}</p>
                @endif

                @if($member->cvUrl())
                    <a href="{{ $member->cvUrl() }}" target="_blank"
                       class="inline-flex items-center gap-2 mt-4 bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                        📄 Download CV
                    </a>
                @endif
            </div>
        </div>
    </div>

    <h2 class="text-xl font-bold text-stone-800 mb-4">Laporan Kegiatan</h2>

    @if($reports->isEmpty())
        <p class="text-stone-500 text-sm">Belum ada laporan kegiatan dari anggota ini.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($reports as $report)
                <a href="{{ route('reports.show', $report) }}" class="group bg-white rounded-xl border border-stone-200 overflow-hidden hover:shadow-lg transition">
                    <div class="aspect-video bg-stone-100 overflow-hidden">
                        <img src="{{ $report->coverUrl() }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-stone-400 mb-1">{{ $report->activity_date->translatedFormat('d F Y') }}</div>
                        <h3 class="font-semibold text-stone-800 line-clamp-2 group-hover:text-emerald-700">{{ $report->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $reports->links() }}</div>
    @endif

    <div class="mt-8">
        <a href="{{ route('directory') }}" class="text-emerald-700 text-sm font-medium hover:underline">← Kembali ke Direktori</a>
    </div>
</section>
@endsection
