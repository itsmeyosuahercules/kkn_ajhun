@extends('layouts.app')

@section('title', 'Direktori Anggota - ' . $siteSettings['site_name'])

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-stone-800">Direktori Anggota</h1>
        <p class="text-stone-500 mt-2">Kenali seluruh anggota tim {{ $siteSettings['site_name'] }}</p>
    </div>

    @if($members->isEmpty())
        <p class="text-center text-stone-500">Belum ada data anggota.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($members as $member)
                <a href="{{ route('members.show', $member) }}" class="bg-white rounded-xl border border-stone-200 p-6 text-center hover:shadow-lg transition group">
                    <div class="w-24 h-24 rounded-full overflow-hidden mx-auto border-4 border-emerald-50">
                        <img src="{{ $member->photoUrl() }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="mt-4 font-semibold text-stone-800 group-hover:text-emerald-700">{{ $member->user->name }}</h3>
                    <p class="text-xs text-emerald-700 font-medium mt-0.5">{{ $member->jabatan }}</p>
                    <p class="text-xs text-stone-500 mt-1">{{ $member->jurusan }}@if($member->age) &middot; {{ $member->age }} th @endif</p>
                    <div class="flex items-center justify-center gap-2 mt-3">
                        <span class="inline-flex items-center text-[11px] text-stone-500 bg-stone-100 rounded-full px-2.5 py-0.5">{{ $member->reports->count() }} kegiatan</span>
                        @if($member->cv)
                            <span class="inline-flex items-center text-[11px] text-emerald-700 bg-emerald-50 rounded-full px-2.5 py-0.5">📄 CV</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $members->links() }}
        </div>
    @endif
</section>
@endsection
