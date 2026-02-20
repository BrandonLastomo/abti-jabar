@extends('layouts.master')

@section('title', 'View Kegiatan')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>View Kegiatan</h2>
            </div>
        </div>

        <div class="bignews-wrapper">

            <div class="image-section">

                {{-- IMAGE --}}
                <div class="image-preview">
                    @if($kegiatan->image)
                        <img src="{{ asset('storage/' . $kegiatan->image) }}" alt="Preview" style="max-width: 100%; border-radius: 8px;">
                    @else
                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="No Image">
                    @endif
                </div>

                {{-- DETAIL --}}
                <div class="image-form">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" disabled value="{{ $kegiatan->name }}">
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" disabled value="{{ $kegiatan->slug }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" disabled
                               value="{{ \Carbon\Carbon::parse($kegiatan->date)->format('d/m/Y') }}">
                    </div>

                    {{-- LINK FIELD --}}
                    <div class="form-group">
                        <label>Link </label>
                        <div style="display: flex; gap: 5px;">
                            <input type="text" disabled value="{{ $kegiatan->link ?? 'Tidak ada link' }}" style="flex: 1;">
                           
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Deskripsi</label>
                        <textarea rows="6" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">{{ $kegiatan->desc }}</textarea>
                    </div>
                </div>

            </div>

            {{-- FOOTER DENGAN DUA TOMBOL --}}
            <div class="form-footer" style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="{{ route('kegiatan.index') }}" class="btn-upload" style="text-decoration: none;">
                    Kembali
                </a>
                
                <a href="{{ route('kegiatan.edit', $kegiatan->slug) }}" class="btn-save" style="text-decoration: none;">
                    Edit Kegiatan
                </a>
            </div>

        </div>

    </div>
</div>
@endsection