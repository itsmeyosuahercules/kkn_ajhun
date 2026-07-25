@extends('layouts.dashboard')

@section('title', 'Pengaturan Website')

@section('content')
<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6 max-w-3xl">
    <h2 class="font-semibold text-stone-800 mb-5">Pengaturan Website</h2>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-stone-700 mb-1">Nama Situs</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-stone-700 mb-1">Tagline</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-stone-700 mb-1">Tentang Kami</label>
                <textarea name="about" rows="4" class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('about', $settings['about']) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $settings['location']) }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Email Kontak</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">No. Telepon</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $settings['instagram']) }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <button type="submit" class="mt-6 bg-emerald-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-emerald-700 transition">
            Simpan Pengaturan
        </button>
    </form>
</div>
@endsection
