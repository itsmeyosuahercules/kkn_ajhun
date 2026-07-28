@extends('layouts.app')

@section('title', $report->title . ' - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <a href="{{ route('timeline') }}" class="text-emerald-700 text-sm font-medium hover:underline">&larr; Kembali ke Timeline</a>

    <div class="mt-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-stone-800">{{ $report->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-stone-500">
            <span>&#128197; {{ $report->activity_date->translatedFormat('d F Y') }}</span>
            @if($report->location)<span>&#128205; {{ $report->location }}</span>@endif
            <a href="{{ route('members.show', $report->member) }}" class="flex items-center gap-2 hover:text-emerald-700">
                <img src="{{ $report->member->photoUrl() }}" class="w-6 h-6 rounded-full object-cover" alt="">
                {{ $report->member->user->name }}
            </a>
        </div>
    </div>

    {{-- Media utama: YouTube embed jika ada ID, kalau tidak tampil cover foto --}}
    @if($report->youtubeEmbedUrl())
        <div class="mb-8">
            <h2 class="text-xl font-bold text-stone-800 mb-4">Dokumentasi Video</h2>
            <div class="aspect-video rounded-xl overflow-hidden bg-stone-900 shadow-lg">
                <iframe
                    src="{{ $report->youtubeEmbedUrl() }}"
                    title="{{ $report->title }}"
                    class="w-full h-full"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>
        </div>
    @else
        <div class="aspect-video bg-stone-100 rounded-xl overflow-hidden mb-6">
            <img src="{{ $report->coverUrl() }}" alt="{{ $report->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <div class="prose max-w-none text-stone-700 leading-relaxed whitespace-pre-line mb-8">
        {{ $report->description }}
    </div>

    {{-- Like & ringkasan interaksi --}}
    <div class="flex flex-wrap items-center gap-4 mb-10 pb-6 border-b border-stone-200">
        <div class="flex items-center gap-2 text-sm text-stone-600">
            <span class="font-semibold text-stone-800">{{ $report->likes_count }}</span> suka
            <span class="text-stone-300">&middot;</span>
            <span class="font-semibold text-stone-800">{{ $report->comments_count }}</span> komentar
        </div>

        @auth
            <form method="POST" action="{{ route('reports.like', $report) }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-1.5 text-sm font-medium px-4 py-2 rounded-lg transition {{ $liked ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'border border-emerald-600 text-emerald-700 hover:bg-emerald-50' }}">
                    {{ $liked ? 'Batal Suka' : 'Suka' }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-sm text-emerald-700 hover:underline">
                Login untuk suka &amp; berkomentar
            </a>
        @endauth
    </div>

    {{-- Dokumentasi Foto: selalu di section sendiri (di bawah video jika ada) --}}
    @if($report->photos->isNotEmpty())
        <div class="mb-12">
            <h2 class="text-xl font-bold text-stone-800 mb-4">Dokumentasi Foto</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($report->photos as $photo)
                    <div class="aspect-square rounded-lg overflow-hidden bg-stone-100">
                        <img src="{{ $photo->url() }}" alt="Dokumentasi foto" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Komentar --}}
    <div>
        <h2 class="text-xl font-bold text-stone-800 mb-4">Komentar</h2>

        @auth
            <form method="POST" action="{{ route('reports.comments.store', $report) }}" class="mb-6">
                @csrf
                <textarea name="body" rows="3" required maxlength="1000" placeholder="Tulis komentar Anda..."
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-2 bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                    Kirim Komentar
                </button>
            </form>
        @else
            <p class="text-sm text-stone-500 mb-6">
                <a href="{{ route('login') }}" class="text-emerald-700 hover:underline">Login</a> dulu untuk menulis komentar.
            </p>
        @endauth

        @forelse($report->comments as $comment)
            <div class="border border-stone-200 rounded-xl p-4 mb-3 bg-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-stone-800">{{ $comment->user->name }}</p>
                        <p class="text-xs text-stone-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
                            <form method="POST" action="{{ route('reports.comments.destroy', $comment) }}" onsubmit="return confirm('Hapus komentar ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                            </form>
                        @endif
                    @endauth
                </div>
                <p class="text-sm text-stone-700 mt-2 whitespace-pre-line">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-sm text-stone-500">Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse
    </div>
</section>
@endsection
