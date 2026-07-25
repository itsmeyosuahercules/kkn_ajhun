@extends('layouts.app')

@section('title', $report->title . ' - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <a href="{{ route('timeline') }}" class="text-emerald-700 text-sm font-medium hover:underline">← Kembali ke Timeline</a>

    <div class="mt-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-stone-800">{{ $report->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-stone-500">
            <span>🗓️ {{ $report->activity_date->translatedFormat('d F Y') }}</span>
            @if($report->location)<span>📍 {{ $report->location }}</span>@endif
            <a href="{{ route('members.show', $report->member) }}" class="flex items-center gap-2 hover:text-emerald-700">
                <img src="{{ $report->member->photoUrl() }}" class="w-6 h-6 rounded-full object-cover">
                {{ $report->member->user->name }}
            </a>
        </div>
    </div>

    <div class="aspect-video bg-stone-100 rounded-xl overflow-hidden mb-6">
        <img src="{{ $report->coverUrl() }}" class="w-full h-full object-cover">
    </div>

    <div class="prose max-w-none text-stone-700 leading-relaxed whitespace-pre-line mb-10">
        {{ $report->description }}
    </div>

    @if($report->photos->isNotEmpty())
        <h2 class="text-xl font-bold text-stone-800 mb-4">Dokumentasi Foto</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach($report->photos as $photo)
                <div class="aspect-square rounded-lg overflow-hidden bg-stone-100">
                    <img src="{{ $photo->url() }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
