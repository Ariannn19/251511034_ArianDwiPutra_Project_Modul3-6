@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 20px auto; font-family: sans-serif;">
    <p><a href="{{ route('activities.index') }}" style="text-decoration: none;">&larr; Kembali ke Daftar</a></p>
    <h2>Edit Kegiatan</h2>

    <form action="{{ route('activities.update', $activity) }}" method="POST">
        @csrf
        @method('PUT')

        @include('activities._form')
    </form>
</div>
@endsection
