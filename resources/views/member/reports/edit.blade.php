@extends('layouts.dashboard')

@section('title', 'Edit Laporan')

@section('content')
<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6 max-w-3xl">
    <h2 class="font-semibold text-stone-800 mb-5">Edit Laporan - {{ $report->title }}</h2>
    <form method="POST" action="{{ route('member.reports.update', $report) }}" enctype="multipart/form-data">
        @include('member.reports._form')
    </form>
</div>
@endsection
