@extends('layouts.app')

@section('title', $siteSettings['site_name'] . ' - ' . $siteSettings['site_tagline'])

@section('content')

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-[#123a5c] via-[#166f80] to-[#1fa4b3] text-white">
    <!-- dekorasi blob -->
    <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-[#f2b134]/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-[#3bbecb]/30 blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-20 grid lg:grid-cols-2 gap-10 items-center">
        <!-- kiri: teks -->
        <div class="text-center lg:text-left">
            <div class="flex items-center justify-center lg:justify-start gap-3 mb-5">
                <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Logo KKN Taman Sari" class="h-16 w-16 rounded-full object-cover ring-4 ring-white/25 shadow-lg">
                <span class="inline-block bg-[#f2b134] text-[#123a5c] text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full">
                    {{ $siteSettings['location'] }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-bold leading-tight mb-4">{{ $siteSettings['site_name'] }}</h1>
            <p class="text-teal-50/90 text-lg max-w-xl mx-auto lg:mx-0 mb-8">{{ $siteSettings['site_tagline'] }}</p>
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3">
                <a href="{{ route('directory') }}" class="bg-[#f2b134] text-[#123a5c] font-semibold px-6 py-3 rounded-lg hover:bg-amber-300 transition shadow-lg shadow-amber-900/20">Lihat Anggota</a>
                <a href="{{ route('timeline') }}" class="border border-white/70 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition">Lihat Kegiatan</a>
            </div>
        </div>

        <!-- kanan: foto tim -->
        <div class="relative">
            <div class="absolute -inset-3 bg-white/10 rounded-3xl rotate-3"></div>
            <img src="{{ asset('assets/images/hero/hero.jpeg') }}" alt="Tim KKN Taman Sari"
                 class="relative w-full h-72 sm:h-96 object-cover rounded-2xl shadow-2xl ring-1 ring-white/20">
        </div>
    </div>
</section>

<!-- Stats -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 -mt-10 relative z-10">
    <div class="grid grid-cols-3 gap-4 bg-white rounded-2xl shadow-lg border border-stone-100 p-6 sm:p-8">
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-bold text-emerald-700">{{ $stats['members'] }}</div>
            <div class="text-stone-500 text-xs sm:text-sm mt-1">Anggota</div>
        </div>
        <div class="text-center border-x border-stone-100">
            <div class="text-3xl sm:text-4xl font-bold text-emerald-700">{{ $stats['reports'] }}</div>
            <div class="text-stone-500 text-xs sm:text-sm mt-1">Laporan Kegiatan</div>
        </div>
        <div class="text-center">
            <div class="text-3xl sm:text-4xl font-bold text-emerald-700">{{ $stats['photos'] }}</div>
            <div class="text-stone-500 text-xs sm:text-sm mt-1">Dokumentasi Foto</div>
        </div>
    </div>
</section>

<!-- About -->
@if($siteSettings['about'])
<section class="max-w-4xl mx-auto px-4 sm:px-6 py-14 text-center">
    <h2 class="text-2xl font-bold text-stone-800 mb-4">Tentang Kami</h2>
    <p class="text-stone-600 leading-relaxed">{{ $siteSettings['about'] }}</p>
</section>
@endif

<!-- Latest Activities -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-stone-800">Kegiatan Terbaru</h2>
        <a href="{{ route('timeline') }}" class="text-emerald-700 text-sm font-medium hover:underline">Lihat semua →</a>
    </div>

    @if($latestReports->isEmpty())
        <p class="text-stone-500 text-sm">Belum ada laporan kegiatan.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestReports as $report)
                <a href="{{ route('reports.show', $report) }}" class="group bg-white rounded-xl border border-stone-200 overflow-hidden hover:shadow-lg transition">
                    <div class="aspect-video bg-stone-100 overflow-hidden">
                        <img src="{{ $report->coverUrl() }}" alt="{{ $report->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-stone-400 mb-1">{{ $report->activity_date->translatedFormat('d F Y') }}</div>
                        <h3 class="font-semibold text-stone-800 line-clamp-2 group-hover:text-emerald-700">{{ $report->title }}</h3>
                        <p class="text-xs text-stone-500 mt-2">oleh {{ $report->member->user->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

<!-- Members preview -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-stone-800">Anggota Tim</h2>
        <a href="{{ route('directory') }}" class="text-emerald-700 text-sm font-medium hover:underline">Lihat semua →</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
        @foreach($members as $member)
            <a href="{{ route('members.show', $member) }}" class="text-center group">
                <div class="aspect-square rounded-full overflow-hidden border-4 border-white shadow-md mx-auto w-24 sm:w-28">
                    <img src="{{ $member->photoUrl() }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="mt-3 font-medium text-sm text-stone-800 group-hover:text-emerald-700">{{ $member->user->name }}</div>
                <div class="text-xs text-stone-500">{{ $member->jabatan }}</div>
            </a>
        @endforeach
    </div>
</section>

@endsection
