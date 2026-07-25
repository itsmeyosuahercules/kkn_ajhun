@extends('layouts.dashboard')

@section('title', 'Buat Laporan')

@section('content')
<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6 max-w-3xl">
    <h2 class="font-semibold text-stone-800 mb-5">Buat Laporan Kegiatan</h2>
    <form method="POST" action="{{ route('member.reports.store') }}" enctype="multipart/form-data">
        @include('member.reports._form')
    </form>
</div>
@endsection
