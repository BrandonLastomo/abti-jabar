@extends('layouts.master')

@section('title', 'View Sponsor')

@section('content')
<style>
    /* Menyesuaikan layout agar seragam dengan referensi kegiatan */
    .bignews-wrapper {
        padding: 20px;
        background: var(--surface);
        border-radius: var(--radius);
        width: 100%;
    }

    .image-section {
        display: flex;
        gap: 30px;
        margin-bottom: 2rem;
        align-items: flex-start;
    }

    .image-preview {
        width: 250px;
        height: 250px;
        background: #fdfdfd;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
        flex-shrink: 0;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #fff;
    }

    .image-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        flex: 1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text);
    }

    .form-group input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f5f5f5; /* Warna abu-abu menandakan readonly */
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .image-section {
            flex-direction: column;
            align-items: center;
        }
        .image-form {
            grid-template-columns: 1fr;
            width: 100%;
        }
        .image-preview {
            width: 100%;
            max-width: 250px;
        }
    }
</style>

<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Detail Sponsor</h2>
            </div>
        </div>

        <div class="bignews-wrapper">
            <div class="image-section">

                {{-- LOGO SPONSOR --}}
                <div class="image-preview">
                    @if($sponsor->image)
                        <img src="{{ asset('storage/' . $sponsor->image) }}" alt="Logo {{ $sponsor->name }}">
                    @else
                        <img src="https://via.placeholder.com/250?text=No+Logo" alt="No Logo">
                    @endif
                </div>

                {{-- DETAIL DATA --}}
                <div class="image-form">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Nama Sponsor / Mitra</label>
                        <input type="text" disabled value="{{ $sponsor->name }}">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Link Website</label>
                        <input type="text" disabled value="{{ $sponsor->link ?? 'Tidak ada link' }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Input</label>
                        <input type="text" disabled value="{{ $sponsor->created_at->format('d/m/Y H:i') }}">
                    </div>

                    <div class="form-group">
                        <label>Terakhir Diperbarui</label>
                        <input type="text" disabled value="{{ $sponsor->updated_at->format('d/m/Y H:i') }}">
                    </div>

                </div>

            </div>

            <div class="form-footer" style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="{{ route('sponsor.index') }}" class="btn-upload">
                    Kembali
                </a>
                <a href="{{ route('sponsor.edit', $sponsor->id) }}" class="btn-save" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                    Edit Data Ini
                </a>
            </div>

        </div>
    </div>
</div>
@endsection