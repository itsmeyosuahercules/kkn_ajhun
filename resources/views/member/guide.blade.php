@extends('layouts.dashboard')

@section('title', 'Panduan')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-stone-800">Panduan Penggunaan</h2>
        <p class="text-stone-500 mt-1">Cara mengisi profil dan membuat laporan kegiatan. Ikuti langkahnya, gampang kok.</p>
    </div>

    {{-- Daftar isi --}}
    <div class="bg-white rounded-xl border border-stone-200 p-5 mb-8">
        <p class="text-sm font-semibold text-stone-700 mb-3">Isi Panduan</p>
        <div class="grid sm:grid-cols-2 gap-2 text-sm">
            <a href="#login" class="text-emerald-700 hover:underline">1. Masuk (Login)</a>
            <a href="#profil" class="text-emerald-700 hover:underline">2. Melengkapi Profil</a>
            <a href="#buat-laporan" class="text-emerald-700 hover:underline">3. Membuat Laporan Kegiatan</a>
            <a href="#kelola-laporan" class="text-emerald-700 hover:underline">4. Mengubah / Menghapus Laporan</a>
            <a href="#faq" class="text-emerald-700 hover:underline">5. Pertanyaan Umum</a>
        </div>
    </div>

    {{-- 1. Login --}}
    <section id="login" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128273;</span>
            Masuk (Login)
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Gunakan <strong>email &amp; password</strong> yang diberikan oleh admin.</li>
            <li>Kalau password Anda masih <strong>password</strong> (bawaan), segera ganti lewat menu <strong>Profil Saya</strong> demi keamanan.</li>
            <li>Lupa password? Hubungi admin untuk direset.</li>
        </ol>
    </section>

    {{-- 2. Profil --}}
    <section id="profil" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128100;</span>
            Melengkapi Profil
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Profil Saya</strong> di sidebar.</li>
            <li>Lengkapi data: umur, NIM, jurusan, fakultas, universitas, nomor HP, Instagram, dan bio singkat tentang diri Anda.</li>
            <li>Unggah <strong>Foto Profil</strong> (JPG/PNG, maks 2MB) supaya profil terlihat lebih menarik.</li>
            <li>Unggah <strong>CV</strong> bila ada (PDF/DOC/DOCX, maks 5MB). Ini opsional.</li>
            <li>Klik <strong>Simpan Perubahan</strong>.</li>
        </ol>
        <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">
            Profil Anda tampil di halaman <strong>Direktori Anggota</strong> yang bisa dilihat publik. Isi yang rapi ya!
        </div>
    </section>

    {{-- 3. Buat laporan --}}
    <section id="buat-laporan" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128221;</span>
            Membuat Laporan Kegiatan
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Laporan Saya</strong>, lalu klik <strong>+ Buat Laporan</strong>.</li>
            <li>Isi <strong>judul</strong> kegiatan, <strong>tanggal</strong> pelaksanaan, dan <strong>lokasi</strong>.</li>
            <li>Tulis <strong>deskripsi</strong> kegiatan &mdash; ceritakan apa yang dilakukan, sejelas mungkin.</li>
            <li>Unggah <strong>foto cover</strong> (foto utama) dan boleh tambah <strong>beberapa foto dokumentasi</strong> sekaligus.</li>
            <li>Klik <strong>Simpan</strong>. Laporan langsung tampil di Timeline &amp; Galeri website.</li>
        </ol>
        <div class="mt-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm px-4 py-3">
            <strong>Tips:</strong> Foto yang jelas &amp; terang bikin dokumentasi jauh lebih bagus. Ukuran foto jangan terlalu besar biar cepat terunggah.
        </div>
    </section>

    {{-- 4. Kelola laporan --}}
    <section id="kelola-laporan" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#9999;&#65039;</span>
            Mengubah / Menghapus Laporan
        </h3>
        <ul class="space-y-3 text-sm text-stone-600 list-disc list-inside">
            <li>Di menu <strong>Laporan Saya</strong>, klik <strong>Edit</strong> untuk memperbaiki laporan (mengganti teks, menambah/menghapus foto).</li>
            <li>Klik <strong>Hapus</strong> untuk menghapus laporan. Perlu diingat, laporan yang dihapus tidak bisa dikembalikan.</li>
            <li>Anda hanya bisa mengubah laporan milik sendiri.</li>
        </ul>
    </section>

    {{-- 5. FAQ --}}
    <section id="faq" class="bg-white rounded-xl border border-stone-200 p-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#10067;</span>
            Pertanyaan Umum
        </h3>
        <div class="space-y-4 text-sm">
            <div>
                <p class="font-semibold text-stone-700">Foto saya tidak mau terunggah, kenapa?</p>
                <p class="text-stone-600">Cek ukuran filenya. Foto maksimal 2MB dan formatnya JPG atau PNG. Kalau terlalu besar, kecilkan dulu.</p>
            </div>
            <div>
                <p class="font-semibold text-stone-700">Bagaimana cara ganti password?</p>
                <p class="text-stone-600">Buka <strong>Profil Saya</strong>, isi kolom "Password Baru", lalu simpan. Kosongkan kalau tidak ingin mengubah.</p>
            </div>
            <div>
                <p class="font-semibold text-stone-700">Laporan saya sudah tampil di website publik?</p>
                <p class="text-stone-600">Ya, begitu disimpan laporan langsung muncul di Timeline dan Galeri yang bisa dilihat semua orang.</p>
            </div>
        </div>
    </section>
</div>
@endsection
