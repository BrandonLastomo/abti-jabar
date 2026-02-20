@extends('layouts.master')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Kegiatan</h2>
    </div>

    <div class="bignews-wrapper">

        <form action="{{ route('kegiatan.update', $kegiatan) }}"
              method="POST"
              enctype="multipart/form-data">    
            @csrf
            @method('PUT')

            {{-- IMAGE SECTION --}}
            <div class="image-section">

                <div class="image-preview">
                    @if($kegiatan->image)
                        <img id="previewImage"
                             src="{{ asset('storage/'.$kegiatan->image) }}"
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
                        {{-- Span untuk kontrol teks via JS --}}
                        <span id="labelText">
                            {{ $kegiatan->image ? 'Change Image' : 'Upload Image' }}
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
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Kegiatan <span>*</span></label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $kegiatan->name) }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

                    @error('name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal <span>*</span></label>
                    <input type="date"
                           name="date"
                           value="{{ old('date', \Carbon\Carbon::parse($kegiatan->date)->format('Y-m-d')) }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

                    @error('date')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- FIELD LINK BARU --}}
    <div class="form-group" style="grid-column: span 2;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Link</label>
        <input type="url" name="link" value="{{ old('link', $kegiatan->link) }}" placeholder="https://example.com" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        @error('link') <small style="color:red;">{{ $message }}</small> @enderror
    </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi <span>*</span></label>
                    <textarea name="desc" 
                              rows="5" 
                              required
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ old('desc', $kegiatan->desc) }}</textarea>

                    @error('desc')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="form-footer" style="margin-top: 30px; display: flex; align-items: center;">
                <a href="{{ route('kegiatan.index') }}" class="btn-upload" style="text-decoration: none;">
                    Kembali
                </a>

                <button type="submit" class="btn-save" style="margin-left:20px; border: none; cursor: pointer;">
                    Update Kegiatan
                </button>
            </div>

        </form>

    </div>
</div>

{{-- JS Preview Image & Update Text --}}
<script>
document.getElementById('imageInput').addEventListener('change', function(e){
    if(this.files && this.files[0]) {
        // 1. Preview Image
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);

        // 2. Ubah Teks Label Langsung
        document.getElementById('labelText').innerText = 'Change Image';
    }
});
</script>

@endsection