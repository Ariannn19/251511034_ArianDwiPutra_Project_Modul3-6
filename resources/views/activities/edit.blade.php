@extends('layouts.app')

@section('content')
<p><a href="{{ route('activities.index') }}">&larr; Kembali</a></p>
<h1>Tambah Kegiatan Baru</h1>

<form action="{{ route('activities.store') }}" method="POST">
    @include('activities._form', ['submitButtonText' => 'Simpan Kegiatan'])
</form>
@endsection