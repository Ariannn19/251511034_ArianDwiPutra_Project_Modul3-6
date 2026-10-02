@extends('layouts.app')

@section('content')
<h1>Daftar Kegiatan</h1>
<p><a href="{{ route('activities.create') }}">+ Tambah Kegiatan Baru</a></p>

<!-- Form Search, Filter Kategori, Filter Status, dan Sort -->
<form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
    <div>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari kode atau judul..."
            style="padding: 6px 10px;">
    </div>

    <div>
        <label for="category_id">Kategori:</label>
        <select name="category_id" id="category_id" style="padding: 6px 10px;">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="status">Filter Status:</label>
        <select name="status" id="status" style="padding: 6px 10px;">
            <option value="">Semua</option>
            @foreach (['draft', 'published', 'completed', 'cancelled'] as $statusOption)
            <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>
                {{ ucfirst($statusOption) }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="sort">Urutkan:</label>
        <select name="sort" id="sort" style="padding: 6px 10px;">
            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>
    </div>

    <button type="submit" style="padding: 6px 12px; cursor: pointer;">Terapkan</button>
    <a href="{{ route('activities.index') }}" style="padding: 6px 10px; text-decoration: none; color: gray;">Reset</a>
</form>

@forelse ($activities as $activity)
<article class="card">
    <h2>
        <a href="{{ route('activities.show', $activity) }}">
            {{ $activity->title }}
        </a>
    </h2>
    <p>Tanggal: {{ $activity->activity_date ? $activity->activity_date->format('d M Y') : '-' }}</p>
    <p>Kategori: {{ $activity->category?->name ?? $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>
</article>
@empty
<p>Belum ada kegiatan.</p>
@endforelse

<!-- Navigasi Pagination -->
<div style="margin-top: 1.5rem;">
    {{ $activities->links() }}
</div>
@endsection
