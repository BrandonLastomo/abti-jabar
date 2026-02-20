@extends('layouts.master')

@section('title', 'Add Big News')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Add Big News</h2>
            </div>
        </div>

        <div class="bignews-wrapper">

            <form action="{{ route('big_news.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf

                {{-- IMAGE --}}
                <div class="image-section">
                    <div class="image-preview">
                        <img id="preview-image"
                             src="https://via.placeholder.com/150x150"
                             width="150"
                             style="border-radius: 8px; object-fit: cover;">
                    </div>

                    <div class="image-info">
                        <label class="btn-save" style="padding-top: 10px">
                            {{-- Span ID label-text untuk diubah via JS --}}
                            {{-- Tambahkan ID pada span untuk dimanipulasi JS --}}
                            <span id="label-text">Upload Image</span>
                            <input type="file"
                                   name="image"
                                   id="image-input"
                                   accept="image/*"
                                   hidden>
                        </label>

                        <p class="hint " style="padding-top:10px;">
                            Max 2MB (JPG, PNG, WEBP)
                        </p>

                        @error('image')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- TITLE --}}
                <div class="form-group">
                    <label>Title <span>*</span></label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

                    @error('title')
                        <small style="color:red">{{ $message }}</small>
                    @enderror
                </div>

                {{-- LINK --}}
                <div class="form-group" style="margin-top: 15px;">
                    <label>Link Berita</label>
                    <input type="url" 
                           name="link" 
                           value="{{ old('link') }}" 
                           placeholder="https://example.com" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('link')
                        <small style="color:red">{{ $message }}</small>
                    @enderror
                </div>

                {{-- CONTENT --}}
                <div class="form-group" style="margin-top: 15px;">
                    <label>Content</label>
                    <textarea name="content" rows="6" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ old('content') }}</textarea>
                </div>

                <div class="form-footer" style="margin-top: 20px;">
                    <a href="{{ route('big_news.index') }}" class="btn-upload" style="text-decoration: none; margin-right: 10px;">Kembali</a>
                    <button type="submit" class="btn-save" style="border: none; cursor: pointer;">
                        Save Big News
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- PREVIEW & TEXT SWITCHER SCRIPT --}}
<script>
document.getElementById('image-input').addEventListener('change', function(e) {
    const file = this.files[0];
    const labelText = document.getElementById('label-text');
    const previewImage = document.getElementById('preview-image');

    if (file) {
        // 1. Ganti Teks Label
        labelText.innerText = "Change Image";

        // 2. Jalankan Preview Gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        // Jika batal pilih (kembali ke awal)
        labelText.innerText = "Upload Image";
        previewImage.src = "https://via.placeholder.com/150x150";
    }
});
</script>

@endsection