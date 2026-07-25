@extends('layouts.app')

@section('title', 'Timeline Kegiatan - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-stone-800">Timeline Kegiatan</h1>
        <p class="text-stone-500 mt-2">Rekam jejak kronologis kegiatan {{ $siteSettings['site_name'] }}</p>
    </div>

    @if($reports->isEmpty())
        <p class="text-center text-stone-500">Belum ada kegiatan yang tercatat.</p>
    @else
        <div class="relative border-l-2 border-emerald-200 ml-3">
            @foreach($reports as $report)
                <div class="mb-8 ml-6">
                    <span class="absolute -left-[9px] flex items-center justify-center w-4 h-4 rounded-full bg-emerald-600 ring-4 ring-white"></span>
                    <time class="text-xs font-semibold text-emerald-700">{{ $report->activity_date->translatedFormat('d F Y') }}</time>
                    <a href="{{ route('reports.show', $report) }}" class="block mt-2 bg-white rounded-xl border border-stone-200 overflow-hidden hover:shadow-lg transition sm:flex">
                        <div class="sm:w-56 aspect-video sm:aspect-auto bg-stone-100 shrink-0">
                            <img src="{{ $report->coverUrl() }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-stone-800 hover:text-emerald-700">{{ $report->title }}</h3>
                            <p class="text-sm text-stone-500 mt-1 line-clamp-2">{{ $report->description }}</p>
                            <p class="text-xs text-stone-400 mt-2">oleh {{ $report->member->user->name }} @if($report->location)&middot; 📍 {{ $report->location }}@endif</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $reports->links() }}</div>
    @endif
</section>
@endsection
