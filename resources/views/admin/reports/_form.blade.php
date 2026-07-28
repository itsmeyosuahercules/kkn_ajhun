@csrf
@if($report ?? null) @method('PUT') @endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Judul Laporan</label>
        <input type="text" name="title" value="{{ old('title', $report->title ?? '') }}" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Anggota / Penulis</label>
        <select name="member_id" required class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">-- Pilih Anggota --</option>
            @foreach($members as $m)
                <option value="{{ $m->id }}" @selected(old('member_id', $report->member_id ?? '') == $m->id)>{{ $m->user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Tanggal Kegiatan</label>
        <input type="date" name="activity_date" value="{{ old('activity_date', isset($report) ? $report->activity_date->format('Y-m-d') : '') }}" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Lokasi</label>
        <input type="text" name="location" value="{{ old('location', $report->location ?? '') }}"
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Status</label>
        <select name="status" required class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="published" @selected(old('status', $report->status ?? 'published') == 'published')>Terbit</option>
            <option value="draft" @selected(old('status', $report->status ?? '') == 'draft')>Draft</option>
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Deskripsi Lengkap</label>
        <textarea name="description" rows="6" required class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $report->description ?? '') }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Upload Video (opsional)</label>
        <p class="text-xs text-stone-500 mb-2">Format: MP4 / WebM / MOV &middot; Maksimal <strong>30MB</strong>. Kompres video dulu jika terlalu besar.</p>
        @if(isset($report) && $report->videoUrl())
            <div class="mb-3">
                <video src="{{ $report->videoUrl() }}" controls class="w-full max-w-md rounded-lg bg-stone-900"></video>
                <label class="inline-flex items-center gap-2 mt-2 text-sm text-red-600">
                    <input type="checkbox" name="remove_video" value="1" class="rounded border-stone-300">
                    Hapus video saat ini
                </label>
            </div>
        @endif
        <input type="file" name="video" accept="video/mp4,video/webm,video/quicktime"
            class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm">
        @error('video')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    @if(isset($report) && $report->photos->isNotEmpty())
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-stone-700 mb-2">Foto Saat Ini</label>
            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                @foreach($report->photos as $photo)
                    <div class="relative group aspect-square">
                        <img src="{{ $photo->url() }}" class="w-full h-full object-cover rounded-lg">
                        <button type="submit" form="delete-photo-{{ $photo->id }}"
                            class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Tambah Foto (bisa lebih dari 1)</label>
        <input type="file" name="photos[]" accept="image/*" multiple
            class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm">
    </div>
</div>

<div class="flex items-center gap-3 mt-6">
    <button type="submit" class="bg-emerald-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-emerald-700 transition">
        Simpan
    </button>
    <a href="{{ route('admin.reports.index') }}" class="text-stone-600 text-sm hover:underline">Batal</a>
</div>

@if(isset($report))
    @foreach($report->photos as $photo)
        <form id="delete-photo-{{ $photo->id }}" method="POST" action="{{ route('admin.reports.photos.destroy', [$report, $photo]) }}" class="hidden" onsubmit="return confirm('Hapus foto ini?');">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endif
