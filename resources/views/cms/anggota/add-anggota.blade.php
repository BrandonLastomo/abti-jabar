@extends('layouts.master')

@section('title', 'Add Anggota')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Tambah Anggota ABTI</h2>
            </div>
        </div>

        <div class="bignews-wrapper">

            <form action="{{ route('anggota.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- IMAGE SECTION --}}
                <div class="image-section">

                    <div class="image-preview">
                        <img id="previewImage"
                             src="https://via.placeholder.com/150x150?text=No+Logo"
                             alt="Preview"
                             style="max-width:150px;">
                    </div>

                    <div class="image-info">
                        <label class="btn-save">
                            Upload Logo
                            <input type="file"
                                   name="logo"
                                   id="imageInput"
                                   accept="image/*"
                                   hidden>
                        </label>

                        <p class="hint" style="padding-top:10px;">
                            Max 2MB (JPG, JPEG, PNG)
                        </p>
                    </div>

                </div>

                {{-- FORM FIELD --}}
                <div class="form-grid">

                    <div class="form-group">
                        <label>Nama Kota/Kab <span>*</span></label>
                        <input type="text"
                               name="city"
                               value="{{ old('city') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Ketua <span>*</span></label>
                        <input type="text"
                               name="lead_name"
                               value="{{ old('lead_name') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Sekretaris <span>*</span></label>
                        <input type="text"
                               name="sec_name"
                               value="{{ old('sec_name') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Link Website</label>
                        <input type="url"
                               name="link"
                               value="{{ old('link') }}">
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
                <div class="form-footer">
                    <a href="{{ route('anggota.index') }}" class="btn-upload">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn-save"
                            style="margin-left:20px;">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- PREVIEW SCRIPT --}}
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {

    const file = e.target.files[0];
    if (!file) return;

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
});
</script>

@endsection
