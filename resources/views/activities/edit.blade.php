@extends('layouts.app')

@section('content')
<p><a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a></p>

<h1>Edit Kegiatan: {{ $activity->title }}</h1>

@if($errors->any())
<div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 1.5rem;">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; display: flex; flex-direction: column; gap: 15px;">
    @csrf
    @method('PUT')

    <div>
        <label for="category_id" style="display: block; font-weight: bold; margin-bottom: 4px;">Kategori:</label>
        <select name="category_id" id="category_id" required style="width: 100%; padding: 8px;">
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $activity->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="code" style="display: block; font-weight: bold; margin-bottom: 4px;">Kode Kegiatan:</label>
        <input type="text" name="code" id="code" value="{{ old('code', $activity->code) }}" style="width: 100%; padding: 8px;">
    </div>

    <div>
        <label for="title" style="display: block; font-weight: bold; margin-bottom: 4px;">Judul Kegiatan:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}" required style="width: 100%; padding: 8px;">
    </div>

    <div>
        <label for="description" style="display: block; font-weight: bold; margin-bottom: 4px;">Deskripsi:</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 8px;">{{ old('description', $activity->description) }}</textarea>
    </div>

    <!-- Input Poster -->
    <div>
        <label for="poster" style="display: block; font-weight: bold; margin-bottom: 4px;">Poster Kegiatan (Opsional, Maks 2MB):</label>
        @if($activity->poster_url)
        <div style="margin-bottom: 8px;">
            <p style="margin: 0 0 4px 0; font-size: 13px; color: #6b7280;">Poster Saat Ini:</p>
            <img src="{{ $activity->poster_url }}" alt="Poster" style="max-width: 150px; border-radius: 6px; border: 1px solid #d1d5db;">
        </div>
        @endif
        <input type="file" name="poster" id="poster" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
    </div>

    <div>
        <label for="activity_date" style="display: block; font-weight: bold; margin-bottom: 4px;">Tanggal Pelaksanaan:</label>
        <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', $activity->activity_date ? $activity->activity_date->format('Y-m-d') : '') }}" style="width: 100%; padding: 8px;">
    </div>

    <div>
        <label for="status" style="display: block; font-weight: bold; margin-bottom: 4px;">Status Kegiatan:</label>
        <select name="status" id="status" required style="width: 100%; padding: 8px;">
            <option value="draft" {{ old('status', $activity->status) === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $activity->status) === 'published' ? 'selected' : '' }}>Published</option>
            <option value="completed" {{ old('status', $activity->status) === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ old('status', $activity->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <div>
        <label for="capacity" style="display: block; font-weight: bold; margin-bottom: 4px;">Kapasitas Peserta:</label>
        <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $activity->capacity ?? 10) }}" style="width: 100%; padding: 8px;">
    </div>

    <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
        Simpan Perubahan
    </button>
</form>
@endsection