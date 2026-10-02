@extends('layouts.app')

@section('content')
<div style="max-width: 700px; margin: 20px auto; font-family: sans-serif;">
    <p><a href="{{ route('activities.index') }}" style="text-decoration: none;">&larr; Kembali ke Daftar Kegiatan</a></p>

    <h2>Detail Kegiatan</h2>

    <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 20px;">
        <p><strong>Kode:</strong> {{ $activity->code ?? '-' }}</p>
        <p><strong>Judul Kegiatan:</strong> {{ $activity->title }}</p>
        <p><strong>Tanggal:</strong> {{ $activity->activity_date ? $activity->activity_date->format('d M Y') : '-' }}</p>
        <p><strong>Kategori:</strong> {{ $activity->category->name ?? $activity->category ?? '-' }}</p>
        <p><strong>Status:</strong> <span style="text-transform: capitalize; padding: 3px 8px; background: #e2e8f0; border-radius: 4px;">{{ $activity->status }}</span></p>
        <p><strong>Deskripsi:</strong> {{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
    </div>

    <div style="display: flex; gap: 10px;">
        <a href="{{ route('activities.edit', $activity) }}" style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px;">Edit Kegiatan</a>

        <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer;">Hapus Kegiatan</button>
        </form>
    </div>
</div>
@endsection
