@extends('layouts.app')

@section('title', 'Galeri Foto - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-stone-800">Galeri Foto</h1>
        <p class="text-stone-500 mt-2">Dokumentasi visual seluruh kegiatan {{ $siteSettings['site_name'] }}</p>
    </div>

    @if($photos->isEmpty())
        <p class="text-center text-stone-500">Belum ada foto dokumentasi.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($photos as $photo)
                <a href="{{ route('reports.show', $photo->report) }}" class="group block aspect-square rounded-lg overflow-hidden bg-stone-100 relative">
                    <img src="{{ $photo->url() }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-end p-2 opacity-0 group-hover:opacity-100">
                        <span class="text-white text-xs line-clamp-2">{{ $photo->report->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $photos->links() }}</div>
    @endif
</section>
@endsection
