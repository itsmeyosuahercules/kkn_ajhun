@php
    $navClass = fn($active) => 'flex items-center gap-2 px-3 py-2 rounded-lg transition ' . ($active ? 'bg-emerald-600 text-white' : 'hover:bg-stone-800 text-stone-300');
@endphp
<a href="{{ route('member.dashboard') }}" class="{{ $navClass(request()->routeIs('member.dashboard')) }}">
    <span>🏠</span> Dashboard
</a>
<a href="{{ route('member.reports.index') }}" class="{{ $navClass(request()->routeIs('member.reports.*')) }}">
    <span>📝</span> Laporan Saya
</a>
<a href="{{ route('member.profile.edit') }}" class="{{ $navClass(request()->routeIs('member.profile.*')) }}">
    <span>👤</span> Profil Saya
</a>
<a href="{{ route('member.guide') }}" class="{{ $navClass(request()->routeIs('member.guide')) }}">
    <span>❓</span> Panduan
</a>
