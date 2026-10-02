<div style="margin-bottom: 15px;">
    <label for="code"><strong>Kode Kegiatan</strong></label><br>
    <input type="text" name="code" id="code" value="{{ old('code', $activity->code ?? '') }}" placeholder="Contoh: ACT-001" style="width: 100%; padding: 8px; margin-top: 5px;">
    @error('code')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 15px;">
    <label for="title"><strong>Judul Kegiatan</strong></label><br>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" placeholder="Minimal 5 karakter" style="width: 100%; padding: 8px; margin-top: 5px;">
    @error('title')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 15px;">
    <label for="activity_date"><strong>Tanggal</strong></label><br>
    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', isset($activity->activity_date) ? \Carbon\Carbon::parse($activity->activity_date)->format('Y-m-d') : '') }}" style="width: 100%; padding: 8px; margin-top: 5px;">
    @error('activity_date')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 15px;">
    <label for="category_id"><strong>Kategori</strong></label><br>
    <select name="category_id" id="category_id" style="width: 100%; padding: 8px; margin-top: 5px;">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $cat)
        <option value="{{ $cat->id }}" {{ old('category_id', $activity->category_id ?? '') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
        @endforeach
    </select>
    @error('category_id')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 15px;">
    <label for="status"><strong>Status</strong></label><br>
    <select name="status" id="status" style="width: 100%; padding: 8px; margin-top: 5px;">
        <option value="draft" {{ old('status', $activity->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $activity->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
        <option value="completed" {{ old('status', $activity->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ old('status', $activity->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    @error('status')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 15px;">
    <label for="description"><strong>Deskripsi (Opsional)</strong></label><br>
    <textarea name="description" id="description" rows="4" style="width: 100%; padding: 8px; margin-top: 5px;">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
    <span style="color: red; font-size: 14px;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-top: 20px;">
    <button type="submit" style="padding: 8px 16px; cursor: pointer; font-weight: bold; background: #059669; color: white; border: none; border-radius: 4px;">Simpan Kegiatan</button>
</div>
