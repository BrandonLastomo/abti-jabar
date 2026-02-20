@extends('layouts.master')

@section('title', 'Add Kegiatan')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Tambah Kegiatan</h2>
            </div>
        </div>

        <div class="bignews-wrapper">

            <form action="{{ route('kegiatan.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- IMAGE SECTION --}}
                <div class="image-section">

                    <div class="image-preview">
                        <img id="previewImage"
                             src="https://via.placeholder.com/150x150?text=No+Image"
                             alt="Preview"
                             style="max-width:150px;">
                    </div>

                    <div class="image-info">
                        <label class="btn-save" style="cursor: pointer;">
                            <span id="labelText">Upload Image</span>
                            <input type="file"
                                   name="image"
                                   id="imageInput"
                                   accept="image/*"
                                   hidden>
                        </label>

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
                               value="{{ old('name') }}"
                               required
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal <span>*</span></label>
                        <input type="date"
                               name="date"
                               value="{{ old('date') }}"
                               required
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    {{-- FIELD LINK BARU --}}
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Link</label>
                        <input type="url"
                               name="link"
                               placeholder="https://example.com"
                               value="{{ old('link') }}"
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi <span>*</span></label>
                        <textarea name="desc"
                                  rows="5"
                                  required
                                  style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ old('desc') }}</textarea>
                    </div>

                </div>

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div style="color:red; margin-top:15px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FOOTER --}}
                <div class="form-footer" style="margin-top: 30px; display: flex; align-items: center;">
                    <a href="{{ route('kegiatan.index') }}" class="btn-upload" style="text-decoration: none;">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn-save"
                            style="margin-left:20px; border: none; cursor: pointer;">
                        Simpan Kegiatan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- PREVIEW & TEXT SCRIPT --}}
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Validasi ukuran client-side
    if (file.size > 2048 * 1024) {
        alert('File terlalu besar. Maks 2MB.');
        e.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('previewImage').src = event.target.result;
    };
    reader.readAsDataURL(file);

    // Ganti teks tombol saat file dipilih
    document.getElementById('labelText').innerText = 'Change Image';
});
</script>

@endsection