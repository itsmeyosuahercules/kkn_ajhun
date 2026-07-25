@extends('layouts.dashboard')

@section('title', 'Kelola Anggota')

@section('content')
@if(session('import_errors'))
    <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-lg px-4 py-3">
        <p class="font-medium mb-1">Beberapa baris gagal diimpor:</p>
        <p>{{ session('import_errors') }}</p>
    </div>
@endif

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="font-semibold text-stone-800">Daftar Anggota ({{ $members->total() }})</h2>
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.members.import.template') }}" class="bg-white border border-stone-300 text-stone-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-stone-50 transition">
            Unduh Template
        </a>
        <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')"
            class="inline-flex items-center gap-1 bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <span>&#8681;</span> Import Excel
        </button>
        <a href="{{ route('admin.members.create') }}" class="bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
            + Tambah Anggota
        </a>
    </div>
</div>

<div id="import-modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-stone-800">Import Anggota dari Excel</h3>
            <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-stone-400 hover:text-stone-600">✕</button>
        </div>
        <p class="text-sm text-stone-500 mb-4">Unduh template terlebih dahulu, isi data anggota, lalu unggah file di sini. Kolom wajib: <strong>nama</strong> dan <strong>email</strong>.</p>
        <form method="POST" action="{{ route('admin.members.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 mb-3">
            @error('file')<p class="text-red-600 text-xs mb-2">{{ $message }}</p>@enderror
            <button type="submit" class="w-full bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                Upload &amp; Import
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-stone-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 text-left">
                <tr>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3">Jurusan</th>
                    <th class="px-4 py-3">Umur</th>
                    <th class="px-4 py-3">CV</th>
                    <th class="px-4 py-3">Laporan</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($members as $member)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $member->photoUrl() }}" class="w-9 h-9 rounded-full object-cover">
                                <div>
                                    <p class="font-medium text-stone-800">{{ $member->user->name }}</p>
                                    <p class="text-xs text-stone-500">{{ $member->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-stone-600">{{ $member->jabatan }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $member->jurusan }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $member->age ?? '-' }}</td>
                        <td class="px-4 py-3 text-stone-600">
                            @if($member->cv)
                                <a href="{{ $member->cvUrl() }}" target="_blank" class="text-emerald-700 hover:underline">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-stone-600">{{ $member->reports_count ?? $member->reports()->count() }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.members.edit', $member) }}" class="text-emerald-700 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Hapus anggota ini beserta seluruh laporannya?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-stone-500">Belum ada anggota.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $members->links() }}</div>

@error('file')
<script>document.getElementById('import-modal').classList.remove('hidden');</script>
@enderror
@endsection
