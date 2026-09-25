@extends('layouts.app')

@section('content')
<h1>Daftar Kegiatan</h1>
@forelse ($activities as $activity)
<article class="card">
    <h2>
        <a href="{{ route('activities.show', $activity) }}">
            {{ $activity->title }}
        </a>
    </h2>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>
</article>
@empty
<p>Belum ada kegiatan.</p>
@endforelse
@endsection