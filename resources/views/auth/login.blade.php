@extends('layouts.app')

@section('title', 'Login - ' . $siteSettings['site_name'])

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-white text-xl font-bold mb-3">KT</span>
            <h1 class="text-2xl font-bold text-stone-800">Masuk ke Akun</h1>
            <p class="text-stone-500 text-sm mt-1">{{ $siteSettings['site_name'] }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-stone-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-lg border border-stone-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <label class="flex items-center gap-2 text-sm text-stone-600">
                    <input type="checkbox" name="remember" class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>
                <button type="submit" class="w-full rounded-lg bg-emerald-600 text-white py-2.5 text-sm font-semibold hover:bg-emerald-700 transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-stone-500 mt-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-700">← Kembali ke Beranda</a>
        </p>
    </div>
</div>
@endsection
