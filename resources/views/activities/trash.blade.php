@extends('layouts.app')

@section('content')
<h1>Daftar Kegiatan Terhapus (Trash)</h1>
<p><a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar Utama</a></p>

@if (session('success'))
<div style="background-color: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 1rem;">
    {{ session('success') }}
</div>
@endif

@forelse ($trashedActivities as $activity)
<article class="card" style="margin-bottom: 1rem; border: 1px dashed #ef4444; padding: 1rem; border-radius: 6px;">
    <h2>{{ $activity->title }}</h2>
    <p>Kategori: {{ $activity->category?->name ?? $activity->category }}</p>
    <p>Dihapus pada: {{ $activity->deleted_at->format('d M Y H:i') }}</p>

    <form action="{{ route('activities.restore', $activity->id) }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" style="background-color: #2563eb; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
            Pulihkan (Restore)
        </button>
    </form>
</article>
@empty
<p>Tidak ada kegiatan di kotak sampah.</p>
@endforelse

<div style="margin-top: 1.5rem;">
    {{ $trashedActivities->links() }}
</div>
@endsection