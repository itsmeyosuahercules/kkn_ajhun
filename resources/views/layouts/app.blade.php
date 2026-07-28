<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $siteSettings['site_name'])</title>
    <meta name="description" content="{{ $siteSettings['site_tagline'] }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo/logo.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-stone-50 text-stone-800 min-h-screen flex flex-col">

    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-stone-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-emerald-700 text-lg">
                <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Logo KKN Taman Sari" class="h-10 w-10 rounded-full object-cover ring-2 ring-emerald-100">
                <span class="hidden sm:inline">{{ $siteSettings['site_name'] }}</span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-stone-600">
                <a href="{{ route('home') }}" class="hover:text-emerald-700 {{ request()->routeIs('home') ? 'text-emerald-700' : '' }}">Beranda</a>
                <a href="{{ route('directory') }}" class="hover:text-emerald-700 {{ request()->routeIs('directory') ? 'text-emerald-700' : '' }}">Direktori</a>
                <a href="{{ route('timeline') }}" class="hover:text-emerald-700 {{ request()->routeIs('timeline') ? 'text-emerald-700' : '' }}">Timeline</a>
                <a href="{{ route('gallery') }}" class="hover:text-emerald-700 {{ request()->routeIs('gallery') ? 'text-emerald-700' : '' }}">Galeri</a>
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('member.dashboard') }}"
                       class="rounded-lg bg-emerald-600 text-white px-4 py-2 text-sm font-medium hover:bg-emerald-700 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg border border-emerald-600 text-emerald-700 px-4 py-2 text-sm font-medium hover:bg-emerald-50 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
        <nav class="md:hidden flex items-center gap-4 text-sm font-medium text-stone-600 px-4 pb-3 overflow-x-auto">
            <a href="{{ route('home') }}" class="whitespace-nowrap hover:text-emerald-700 {{ request()->routeIs('home') ? 'text-emerald-700' : '' }}">Beranda</a>
            <a href="{{ route('directory') }}" class="whitespace-nowrap hover:text-emerald-700 {{ request()->routeIs('directory') ? 'text-emerald-700' : '' }}">Direktori</a>
            <a href="{{ route('timeline') }}" class="whitespace-nowrap hover:text-emerald-700 {{ request()->routeIs('timeline') ? 'text-emerald-700' : '' }}">Timeline</a>
            <a href="{{ route('gallery') }}" class="whitespace-nowrap hover:text-emerald-700 {{ request()->routeIs('gallery') ? 'text-emerald-700' : '' }}">Galeri</a>
        </nav>
    </header>

    @if (session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4">
            <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-stone-900 text-stone-300 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Logo KKN Taman Sari" class="h-12 w-12 rounded-full object-cover ring-2 ring-white/20">
                    <h3 class="text-white font-semibold text-lg">{{ $siteSettings['site_name'] }}</h3>
                </div>
                <p class="text-sm text-stone-400">{{ $siteSettings['site_tagline'] }}</p>
                <p class="text-sm text-stone-400 mt-2">📍 {{ $siteSettings['location'] }}</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-2">Navigasi</h4>
                <ul class="text-sm space-y-1 text-stone-400">
                    <li><a href="{{ route('directory') }}" class="hover:text-emerald-400">Direktori Anggota</a></li>
                    <li><a href="{{ route('timeline') }}" class="hover:text-emerald-400">Timeline Kegiatan</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-emerald-400">Galeri Foto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-2">Kontak</h4>
                <ul class="text-sm space-y-1 text-stone-400">
                    @if($siteSettings['contact_email'])<li>✉️ {{ $siteSettings['contact_email'] }}</li>@endif
                    @if($siteSettings['contact_phone'])<li>📞 {{ $siteSettings['contact_phone'] }}</li>@endif
                    @if($siteSettings['instagram'])<li>📷 {{ $siteSettings['instagram'] }}</li>@endif
                </ul>
            </div>
        </div>
        <div class="border-t border-stone-800 py-4 text-center text-xs text-stone-500">
            &copy; {{ date('Y') }} {{ $siteSettings['site_name'] }}. All rights reserved.
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
