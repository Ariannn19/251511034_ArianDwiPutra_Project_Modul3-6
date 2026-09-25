@extends('layouts.app')

@section('content')
<p><a href="{{ route('activities.show', $activity) }}">&larr; Batal</a></p>
<h1>Edit Kegiatan</h1>

<form action="{{ route('activities.update', $activity) }}" method="POST">
    @csrf
    @method('PUT')
    @include('activities._form', ['submitButtonText' => 'Perbarui Kegiatan'])
</form>
@endsection
