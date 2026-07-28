@csrf
@if($report ?? null) @method('PUT') @endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Judul Laporan</label>
        <input type="text" name="title" value="{{ old('title', $report->title ?? '') }}" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
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
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Status</label>
        <select name="status" required class="w-full sm:w-64 rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="published" @selected(old('status', $report->status ?? 'published') == 'published')>Terbit (tampil di website)</option>
            <option value="draft" @selected(old('status', $report->status ?? '') == 'draft')>Draft (belum tampil)</option>
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">Deskripsi Lengkap</label>
        <textarea name="description" rows="6" required class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $report->description ?? '') }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-stone-700 mb-1">ID Video YouTube (opsional)</label>
        <input type="text" name="video" value="{{ old('video', isset($report) ? ($report->youtubeId() ?? '') : '') }}"
            placeholder="Contoh: ocFxGIdj6GI"
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <p class="text-xs text-stone-500 mt-1">Cukup isi ID-nya saja. Dari link <code class="bg-stone-100 px-1 rounded">youtube.com/watch?v=ocFxGIdj6GI</code> ambil bagian <strong>ocFxGIdj6GI</strong>. Kosongkan untuk menghapus video.</p>
        @if(isset($report) && $report->youtubeEmbedUrl())
            <div class="mt-3 aspect-video max-w-md rounded-lg overflow-hidden bg-stone-900">
                <iframe src="{{ $report->youtubeEmbedUrl() }}" class="w-full h-full" allowfullscreen loading="lazy"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
            </div>
        @endif
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
        <label class="block text-sm font-medium text-stone-700 mb-1">Upload Foto (bisa lebih dari 1)</label>
        <input type="file" name="photos[]" accept="image/*" multiple
            class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm">
    </div>
</div>

<div class="flex items-center gap-3 mt-6">
    <button type="submit" class="bg-emerald-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-emerald-700 transition">
        Simpan
    </button>
    <a href="{{ route('member.reports.index') }}" class="text-stone-600 text-sm hover:underline">Batal</a>
</div>

@if(isset($report))
    @foreach($report->photos as $photo)
        <form id="delete-photo-{{ $photo->id }}" method="POST" action="{{ route('member.reports.photos.destroy', [$report, $photo]) }}" class="hidden" onsubmit="return confirm('Hapus foto ini?');">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endif
