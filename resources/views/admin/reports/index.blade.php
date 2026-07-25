@extends('layouts.dashboard')

@section('title', 'Kelola Laporan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <h2 class="font-semibold text-stone-800">Daftar Laporan ({{ $reports->total() }})</h2>
    <div class="flex items-center gap-3">
        <form method="GET" class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                class="rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </form>
        <a href="{{ route('admin.reports.create') }}" class="bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition whitespace-nowrap">
            + Tambah Laporan
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-stone-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 text-left">
                <tr>
                    <th class="px-4 py-3">Laporan</th>
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($reports as $report)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $report->coverUrl() }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                <span class="font-medium text-stone-800 line-clamp-1">{{ $report->title }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-stone-600">{{ $report->member->user->name }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $report->activity_date->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $report->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                                {{ $report->status === 'published' ? 'Terbit' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.reports.edit', $report) }}" class="text-emerald-700 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Hapus laporan ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-stone-500">Belum ada laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $reports->links() }}</div>
@endsection
