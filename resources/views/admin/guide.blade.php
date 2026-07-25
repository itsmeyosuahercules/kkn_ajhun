@extends('layouts.dashboard')

@section('title', 'Panduan Admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-stone-800">Panduan Penggunaan (Admin)</h2>
        <p class="text-stone-500 mt-1">Panduan langkah demi langkah untuk mengelola website KKN. Dibuat sesederhana mungkin &mdash; ikuti saja urutannya.</p>
    </div>

    {{-- Daftar isi --}}
    <div class="bg-white rounded-xl border border-stone-200 p-5 mb-8">
        <p class="text-sm font-semibold text-stone-700 mb-3">Isi Panduan</p>
        <div class="grid sm:grid-cols-2 gap-2 text-sm">
            <a href="#anggota" class="text-emerald-700 hover:underline">1. Menambah &amp; Mengelola Anggota</a>
            <a href="#import" class="text-emerald-700 hover:underline">2. Import Anggota dari Excel</a>
            <a href="#laporan" class="text-emerald-700 hover:underline">3. Mengelola Laporan Kegiatan</a>
            <a href="#pengaturan" class="text-emerald-700 hover:underline">4. Pengaturan Website</a>
            <a href="#akun" class="text-emerald-700 hover:underline">5. Akun &amp; Login Anggota</a>
            <a href="#faq" class="text-emerald-700 hover:underline">6. Pertanyaan Umum</a>
        </div>
    </div>

    {{-- 1. Anggota --}}
    <section id="anggota" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128101;</span>
            Menambah &amp; Mengelola Anggota
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Kelola Anggota</strong> di sidebar kiri.</li>
            <li>Klik tombol hijau <strong>+ Tambah Anggota</strong> di kanan atas.</li>
            <li>Isi data: nama, email, dan password (ini dipakai anggota untuk login). Data lain seperti umur, jurusan, foto, dan CV boleh dikosongkan &mdash; bisa dilengkapi nanti.</li>
            <li>Klik <strong>Simpan</strong>. Anggota otomatis punya akun untuk login sendiri.</li>
            <li>Untuk mengubah data, klik <strong>Edit</strong> di baris anggota. Untuk menghapus, klik <strong>Hapus</strong> (hati-hati: ini juga menghapus semua laporan anggota tersebut).</li>
        </ol>
        <div class="mt-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm px-4 py-3">
            <strong>Tips:</strong> Email tidak boleh sama antar anggota. Kalau muncul error "email sudah dipakai", berarti email itu sudah terdaftar.
        </div>
    </section>

    {{-- 2. Import Excel --}}
    <section id="import" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128228;</span>
            Import Anggota dari Excel
        </h3>
        <p class="text-sm text-stone-600 mb-3">Kalau anggota banyak, tidak perlu input satu per satu. Pakai fitur import:</p>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Kelola Anggota</strong>.</li>
            <li>Klik <strong>Unduh Template</strong>. File Excel akan terunduh, sudah ada contoh 1 baris data.</li>
            <li>Buka file itu (pakai Excel / Google Sheets / WPS). Isi data anggota ke bawah, satu baris satu orang. <strong>Jangan ubah baris judul kolom paling atas.</strong></li>
            <li>Kolom yang <strong>wajib diisi</strong>: <code class="bg-stone-100 px-1 rounded">nama</code> dan <code class="bg-stone-100 px-1 rounded">email</code>. Sisanya opsional.</li>
            <li>Kolom <code class="bg-stone-100 px-1 rounded">password</code> boleh dikosongkan &mdash; kalau kosong, password otomatis jadi <strong>password</strong>.</li>
            <li>Simpan file (format tetap .xlsx / .csv).</li>
            <li>Kembali ke website, klik <strong>Import Excel</strong>, pilih file tadi, lalu klik <strong>Upload &amp; Import</strong>.</li>
        </ol>
        <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">
            Kalau ada baris yang salah (misal email dobel), baris itu akan dilewati dan sistem memberi tahu baris mana yang gagal. Baris yang benar tetap masuk. Jadi aman, tidak gagal semua.
        </div>
    </section>

    {{-- 3. Laporan --}}
    <section id="laporan" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128221;</span>
            Mengelola Laporan Kegiatan
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Kelola Laporan</strong>.</li>
            <li>Anda bisa melihat semua laporan dari semua anggota. Gunakan kolom pencarian untuk cari judul tertentu.</li>
            <li>Klik <strong>Edit</strong> untuk memperbaiki laporan, atau <strong>Hapus</strong> untuk menghapus laporan yang tidak sesuai.</li>
            <li>Saat membuat/edit laporan, Anda bisa mengunggah beberapa foto sekaligus sebagai dokumentasi.</li>
        </ol>
        <div class="mt-4 rounded-lg bg-stone-50 border border-stone-200 text-stone-600 text-sm px-4 py-3">
            Anggota membuat laporannya masing-masing. Tugas admin biasanya hanya mengawasi &amp; merapikan (moderasi).
        </div>
    </section>

    {{-- 4. Pengaturan --}}
    <section id="pengaturan" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#9881;&#65039;</span>
            Pengaturan Website
        </h3>
        <ol class="space-y-3 text-sm text-stone-600 list-decimal list-inside">
            <li>Buka menu <strong>Pengaturan Website</strong>.</li>
            <li>Di sini Anda bisa mengubah nama website, tagline, deskripsi "Tentang Kami", lokasi, serta kontak (email, telepon, Instagram).</li>
            <li>Perubahan ini langsung tampil di halaman depan website yang dilihat publik.</li>
            <li>Klik <strong>Simpan</strong> setelah selesai.</li>
        </ol>
    </section>

    {{-- 5. Akun --}}
    <section id="akun" class="bg-white rounded-xl border border-stone-200 p-6 mb-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#128273;</span>
            Akun &amp; Login Anggota
        </h3>
        <ul class="space-y-3 text-sm text-stone-600 list-disc list-inside">
            <li>Setiap anggota login pakai <strong>email &amp; password</strong> yang Anda buat saat menambah anggota.</li>
            <li>Beri tahu anggota email &amp; password mereka. Mereka bisa mengganti password sendiri lewat menu <strong>Profil Saya</strong>.</li>
            <li>Untuk anggota hasil import Excel tanpa password, password awalnya adalah <strong>password</strong> &mdash; minta mereka segera menggantinya.</li>
        </ul>
    </section>

    {{-- 6. FAQ --}}
    <section id="faq" class="bg-white rounded-xl border border-stone-200 p-6">
        <h3 class="flex items-center gap-2 font-bold text-stone-800 text-lg mb-4">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">&#10067;</span>
            Pertanyaan Umum
        </h3>
        <div class="space-y-4 text-sm">
            <div>
                <p class="font-semibold text-stone-700">Kenapa foto/CV yang diunggah tidak muncul?</p>
                <p class="text-stone-600">Pastikan file tidak terlalu besar (foto maks 2MB, CV maks 5MB) dan formatnya benar (foto: JPG/PNG, CV: PDF/DOC).</p>
            </div>
            <div>
                <p class="font-semibold text-stone-700">Import Excel gagal semua?</p>
                <p class="text-stone-600">Cek jangan mengubah baris judul kolom di template, dan pastikan kolom nama &amp; email terisi. Gunakan template resmi dari tombol "Unduh Template".</p>
            </div>
            <div>
                <p class="font-semibold text-stone-700">Salah hapus anggota, bisa dikembalikan?</p>
                <p class="text-stone-600">Tidak bisa. Data yang dihapus permanen. Pastikan yakin sebelum klik Hapus.</p>
            </div>
        </div>
    </section>
</div>
@endsection
