@php
    $navClass = fn($active) => 'flex items-center gap-2 px-3 py-2 rounded-lg transition ' . ($active ? 'bg-emerald-600 text-white' : 'hover:bg-stone-800 text-stone-300');
@endphp
<a href="{{ route('admin.dashboard') }}" class="{{ $navClass(request()->routeIs('admin.dashboard')) }}">
    <span>🏠</span> Dashboard
</a>
<a href="{{ route('admin.members.index') }}" class="{{ $navClass(request()->routeIs('admin.members.*')) }}">
    <span>👥</span> Kelola Anggota
</a>
<a href="{{ route('admin.reports.index') }}" class="{{ $navClass(request()->routeIs('admin.reports.*')) }}">
    <span>📝</span> Kelola Laporan
</a>
<a href="{{ route('admin.settings.edit') }}" class="{{ $navClass(request()->routeIs('admin.settings.*')) }}">
    <span>⚙️</span> Pengaturan Website
</a>
<a href="{{ route('admin.guide') }}" class="{{ $navClass(request()->routeIs('admin.guide')) }}">
    <span>❓</span> Panduan
</a>
