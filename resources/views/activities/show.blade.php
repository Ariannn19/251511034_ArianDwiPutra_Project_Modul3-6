@extends('layouts.app')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <a href="{{ route('activities.index') }}" style="text-decoration: none; color: #4b5563;">&larr; Kembali ke Daftar Kegiatan</a>

    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('activities.edit', $activity) }}" style="background-color: #2563eb; color: white; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500;">
            Edit Kegiatan
        </a>

        <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color: #dc2626; color: white; padding: 6px 14px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">
                Hapus Kegiatan
            </button>
        </form>
    </div>
</div>

<article class="card" style="margin-bottom: 2rem; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; background-color: #ffffff;">
    @if($activity->poster_url)
    <div style="margin-bottom: 1.5rem; text-align: center;">
        <img src="{{ $activity->poster_url }}" alt="Poster {{ $activity->title }}" style="max-height: 350px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    </div>
    @endif

    <h1 style="margin-top: 0;">{{ $activity->title }}</h1>
    <p><strong>Kode:</strong> {{ $activity->code ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $activity->category?->name ?? $activity->category }}</p>
    <p><strong>Status:</strong> <span style="font-weight: bold; text-transform: uppercase; padding: 2px 8px; border-radius: 4px; background-color: #e5e7eb;">{{ $activity->status }}</span></p>
    <p><strong>Tanggal Pelaksanaan:</strong> {{ $activity->activity_date ? $activity->activity_date->format('d M Y') : '-' }}</p>
    <p><strong>Deskripsi:</strong> {{ $activity->description ?? '-' }}</p>
    <p>
        <strong>Kapasitas Peserta:</strong>
        <span style="font-size: 16px; font-weight: bold; color: {{ $activity->registered_count >= $activity->capacity ? '#dc2626' : '#047857' }};">
            {{ $activity->registered_count }} / {{ $activity->capacity }} Terdaftar
        </span>
    </p>
</article>

@if(session('success'))
<div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 1.5rem;">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 1.5rem;">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Form Pendaftaran Peserta -->
<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; background-color: #f9fafb;">
    <h2 style="margin-top: 0;">Form Pendaftaran Peserta</h2>

    @if($activity->status !== 'published')
    <p style="color: #dc2626; font-weight: 500;">Pendaftaran ditutup karena kegiatan belum dipublikasikan (Status saat ini: {{ $activity->status }}).</p>
    @elseif($activity->registered_count >= $activity->capacity)
    <p style="color: #dc2626; font-weight: bold;">Pendaftaran ditutup karena kuota kapasitas sudah penuh!</p>
    @else
    <form action="{{ route('activities.register', $activity) }}" method="POST" style="display: flex; flex-direction: column; gap: 12px; max-width: 400px;">
        @csrf
        <div>
            <label for="name" style="display: block; margin-bottom: 4px;">Nama Lengkap:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
        </div>

        <div>
            <label for="email" style="display: block; margin-bottom: 4px;">Alamat Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
        </div>

        <button type="submit" style="background-color: #047857; color: white; padding: 10px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Daftar Sekarang
        </button>
    </form>
    @endif
</div>
@endsection
