@extends('layouts.master')

@section('title', 'Edit Big News')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Big News</h2>
    </div>

    <div class="bignews-wrapper">

        <form action="{{ route('big_news.update', $bignews) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- IMAGE SECTION --}}
            <div class="image-section">

                <div class="image-preview">
                    @if($bignews->image)
                        <img id="previewImage"
                             src="{{ asset('storage/'.$bignews->image) }}"
                             alt="Preview"
                             width="150">
                    @else
                        <img id="previewImage"
                             src="https://via.placeholder.com/150x150?text=No+Image"
                             alt="No Image"
                             width="150">
                    @endif
                </div>

                <div class="image-info">
                    <label class="btn-save" style="cursor: pointer;">
                        {{-- Span ID labelText untuk dimanipulasi JS --}}
                        <span id="labelText">
                            {{ $bignews->image ? 'Change Image' : 'Upload Image' }}
                        </span>
                        <input type="file" name="image" id="imageInput" hidden accept="image/*">
                    </label>

                    @error('image')
                        <p style="color:red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p>
                    @enderror

                    <p class="hint" style="padding-top:10px;">
                        Max 2MB (JPG, JPEG, PNG, WEBP)
                    </p>
                </div>

            </div>

            {{-- FORM FIELD --}}
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Title <span>*</span></label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $bignews->title) }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

                    @error('title')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Slug</label>
                    <input type="text"
                           value="{{ $bignews->slug }}"
                           readonly
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9; color: #666;">
                </div>

<div class="form-group" style="grid-column: span 2;">
    <label>Link Berita (External)</label>
    <input type="url" name="link" value="{{ old('link', $bignews->link ?? '') }}" placeholder="https://example.com" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
</div>


                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Content</label>
                    <textarea name="content" 
                              rows="5" 
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ old('content', $bignews->content) }}</textarea>

                    @error('content')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="form-footer" style="margin-top: 30px; display: flex; align-items: center;">
                <a href="{{ route('big_news.index') }}" class="btn-upload" style="text-decoration: none;">
                    Kembali
                </a>

                <button type="submit" class="btn-save" style="margin-left:20px; border: none; cursor: pointer;">
                    Update Big News
                </button>
            </div>

        </form>

    </div>
</div>

{{-- JS Preview Image & Update Text --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('previewImage');
    const labelText = document.getElementById('labelText');

    if (input) {
        input.addEventListener('change', function(e){
            const file = e.target.files[0];
            if (file) {
                // 1. Logika Preview
                const reader = new FileReader();
                reader.onload = function(e){
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // 2. Logika Ubah Teks Tombol
                labelText.innerText = 'Change Image';
            }
        });
    }
});
</script>

@endsection