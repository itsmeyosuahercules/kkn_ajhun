@extends('layouts.dashboard')

@section('title', 'Edit Anggota')

@section('content')
<div class="bg-white rounded-xl border border-stone-200 p-5 sm:p-6 max-w-3xl">
    <h2 class="font-semibold text-stone-800 mb-5">Edit Anggota - {{ $member->user->name }}</h2>
    <form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data">
        @include('admin.members._form')
    </form>
</div>
@endsection
