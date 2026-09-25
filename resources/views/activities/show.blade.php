@extends('layouts.app')

@section('content')
<p><a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a></p>
<h1>{{ $activity->title }}</h1>
<p><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</p>
<p><strong>Kategori:</strong> {{ $activity->category }}</p>
<p><strong>Status:</strong> {{ $activity->status }}</p>
<p><strong>Deskripsi:</strong> {{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
@endsection