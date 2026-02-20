@extends('layouts.master')

@section('title', 'View Big News')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>View Big News</h2>
            </div>
        </div>

        <div class="bignews-wrapper">
            <div class="image-section">

                {{-- IMAGE --}}
                <div class="image-preview">
                    @if($bignews->image)
                        <img src="{{ asset('storage/'.$bignews->image) }}" alt="Preview" style="max-width: 100%; height: auto; object-fit: contain; border-radius: 8px;">
                    @else
                        <img src="https://via.placeholder.com/200x200?text=No+Image" alt="No Image">
                    @endif
                </div>

                {{-- CONTENT INFO --}}
                <div class="image-form">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" value="{{ $bignews->title }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" value="{{ $bignews->slug }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">
                    </div>

                    {{-- LINK FIELD BARU --}}
                    <div class="form-group">
                        <label>Link Berita (External)</label>
                        <div style="display: flex; gap: 5px;">
                            <input type="text" value="{{ $bignews->link ?? 'Tidak ada link' }}" disabled style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">
                            @if($bignews->link)
                                <a href="{{ $bignews->link }}" target="_blank" class="btn-view" style="text-decoration: none; padding: 0 15px; font-size: 12px; display: flex; align-items: center; justify-content: center; height: 38px;">
                                    Buka
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- CONTENT TEXT --}}
            <div class="form-group" style="margin-top:20px;">
                <label>Content</label>
                <textarea rows="6" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; resize: vertical;">{{ $bignews->content }}</textarea>
            </div>

            <div class="form-footer" style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="{{ route('big_news.index') }}" class="btn-upload" style="text-decoration: none;">
                    Kembali
                </a>
                
                {{-- Link ke halaman edit menggunakan SLUG --}}
                <a href="{{ route('big_news.edit', $bignews->slug) }}" class="btn-save" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                    Edit Big News
                </a>
            </div>

        </div>
    </div>
</div>
@endsection