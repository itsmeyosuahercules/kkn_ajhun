@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6 max-w-3xl">
    <h2 class="font-semibold text-stone-800 mb-5">Update Profil Saya</h2>

    <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" name="password"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $member->jabatan ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $member->nim ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Umur</label>
                <input type="number" name="age" min="15" max="100" value="{{ old('age', $member->age ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">No. HP</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Jurusan</label>
                <input type="text" name="jurusan" value="{{ old('jurusan', $member->jurusan ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Fakultas</label>
                <input type="text" name="fakultas" value="{{ old('fakultas', $member->fakultas ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Universitas</label>
                <input type="text" name="universitas" value="{{ old('universitas', $member->universitas ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $member->instagram ?? '') }}"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Hobi</label>
                <input type="text" name="hobi" value="{{ old('hobi', $member->hobi ?? '') }}" placeholder="Contoh: Fotografi, Badminton"
                    class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-stone-700 mb-1">Bio</label>
                <textarea name="bio" rows="3" class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('bio', $member->bio ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Foto Profil</label>
                @if($member && $member->photo)
                    <img src="{{ $member->photoUrl() }}" class="w-16 h-16 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">CV (opsional, PDF/DOC, maks 5MB)</label>
                @if($member && $member->cv)
                    <p class="mb-2"><a href="{{ $member->cvUrl() }}" target="_blank" class="text-emerald-700 text-sm hover:underline">📄 Lihat CV saat ini</a></p>
                @endif
                <input type="file" name="cv" accept=".pdf,.doc,.docx"
                    class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm">
            </div>
        </div>

        <button type="submit" class="mt-6 bg-emerald-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-emerald-700 transition">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
