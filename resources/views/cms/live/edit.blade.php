@extends('cms.layouts.app')
@section('content')

<div class="cms-page">
    <div class="cms-page__header">
        <h1 class="cms-page__title">Edit Livestream</h1>
        <a href="{{ route('cms.live.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cms.live.update', $live) }}" method="POST" class="cms-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Livestream <span class="required">*</span></label>
            <input type="text" id="title" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $live->title) }}"
                   placeholder="Contoh: Final Kejurda Bola Tangan Jabar 2025">
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="link">Link YouTube <span class="required">*</span></label>
            <input type="text" id="link" name="link"
                   class="form-control @error('link') is-invalid @enderror"
                   value="{{ old('link', $live->link) }}"
                   placeholder="https://www.youtube.com/watch?v=xxxxx">
            @error('link')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date">Tanggal <span class="required">*</span></label>
                <input type="date" id="date" name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date', \Carbon\Carbon::parse($live->date)->format('Y-m-d')) }}">
                @error('date')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="time">Waktu <span class="required">*</span></label>
                <input type="time" id="time" name="time"
                       class="form-control @error('time') is-invalid @enderror"
                       value="{{ old('time', $live->time) }}">
                @error('time')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_live" value="1"
                       {{ old('is_live', $live->is_live) ? 'checked' : '' }}>
                <span>Aktifkan sebagai LIVE sekarang</span>
            </label>
            <small class="form-text">Jika dicentang, livestream lain yang sedang aktif akan otomatis dimatikan.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('cms.live.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection