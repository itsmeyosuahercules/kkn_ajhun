<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ $siteSettings['site_name'] }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo/logo.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-stone-100 text-stone-800 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-col w-64 bg-stone-900 text-stone-300 shrink-0">
            <div class="h-16 flex items-center gap-2 px-5 border-b border-stone-800">
                <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Logo KKN Taman Sari" class="h-9 w-9 rounded-full object-cover ring-2 ring-white/20">
                <span class="font-semibold text-white text-sm">{{ $siteSettings['site_name'] }}</span>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                @if(auth()->user()->isAdmin())
                    @include('layouts.partials.admin-nav')
                @else
                    @include('layouts.partials.member-nav')
                @endif
            </nav>
            <div class="p-3 border-t border-stone-800">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-stone-800 text-stone-400 text-sm mb-1">← Lihat Website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-red-900/40 text-red-400 text-sm">Logout</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-4 sm:px-6">
                <div class="lg:hidden font-semibold text-emerald-700">{{ $siteSettings['site_name'] }}</div>
                <h1 class="hidden lg:block text-lg font-semibold text-stone-800">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-stone-600 hidden sm:inline">Halo, {{ auth()->user()->name }}</span>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
            </header>

            <!-- Mobile nav -->
            <nav class="lg:hidden flex items-center gap-3 overflow-x-auto px-4 py-2 bg-white border-b border-stone-200 text-sm">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Dashboard</a>
                    <a href="{{ route('admin.members.index') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.members.*') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Anggota</a>
                    <a href="{{ route('admin.reports.index') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Laporan</a>
                    <a href="{{ route('admin.settings.edit') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Pengaturan</a>
                    <a href="{{ route('admin.guide') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.guide') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Panduan</a>
                @else
                    <a href="{{ route('member.dashboard') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('member.dashboard') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Dashboard</a>
                    <a href="{{ route('member.reports.index') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('member.reports.*') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Laporan</a>
                    <a href="{{ route('member.profile.edit') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('member.profile.*') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Profil</a>
                    <a href="{{ route('member.guide') }}" class="whitespace-nowrap px-3 py-1.5 rounded-lg {{ request()->routeIs('member.guide') ? 'bg-emerald-600 text-white' : 'text-stone-600' }}">Panduan</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button class="whitespace-nowrap px-3 py-1.5 rounded-lg text-red-600">Logout</button>
                </form>
            </nav>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
