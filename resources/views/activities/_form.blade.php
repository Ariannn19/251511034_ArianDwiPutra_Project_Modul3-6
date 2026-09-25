<div class="form-group">
    <label for="title">Judul Kegiatan</label>
    <input type="text" id="title" name="title" value="{{ old('title', $activity->title) }}">
    @error('title')
    <div class="text-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="activity_date">Tanggal</label>
    <input type="date" id="activity_date" name="activity_date"
        value="{{ old('activity_date', $activity->activity_date?->format('Y-m-d')) }}">
    @error('activity_date')
    <div class="text-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="category">Kategori</label>
    <input type="text" id="category" name="category" value="{{ old('category', $activity->category) }}">
    @error('category')
    <div class="text-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status">
        @foreach (['Planned', 'Ongoing', 'Done'] as $statusOption)
        <option value="{{ $statusOption }}"
            {{ old('status', $activity->status ?? 'Planned') === $statusOption ? 'selected' : '' }}>
            {{ $statusOption }}
        </option>
        @endforeach
    </select>
    @error('status')
    <div class="text-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $activity->description) }}</textarea>
    @error('description')
    <div class="text-error">{{ $message }}</div>
    @enderror
</div>

<button type="submit">{{ $submitButtonText }}</button>