@extends('layouts.master')

@section('title', 'Edit Anggota')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Anggota</h2>
    </div>

    <div class="bignews-wrapper">

        <form action="{{ route('anggota.update', $anggota) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- LOGO SECTION --}}
            <div class="image-section">

                <div class="image-preview">
                    @if($anggota->logo)
                        <img id="previewImage" 
                             src="{{ asset('storage/'.$anggota->logo) }}" 
                             alt="Preview" 
                             width="150">
                    @else
                        <img id="previewImage" 
                             src="https://via.placeholder.com/150x150?text=No+Logo" 
                             alt="No Logo" 
                             width="150">
                    @endif
                </div>

                <div class="image-info">
                    <label class="btn-save" style="cursor: pointer;">
                        {{-- ID labelText ditambahkan untuk diubah via JS --}}
                        <span id="labelText">
                            @if($anggota->logo)
                                Change Logo
                            @else
                                Upload Logo
                            @endif
                        </span>
                        <input type="file" name="logo" id="logoInput" hidden accept="image/*">
                    </label>

                    @error('logo')
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
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kota <span>*</span></label>
                    <input type="text" 
                           name="city" 
                           value="{{ old('city', $anggota->city) }}" 
                           required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('city')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketua <span>*</span></label>
                    <input type="text" 
                           name="lead_name" 
                           value="{{ old('lead_name', $anggota->lead_name) }}" 
                           required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('lead_name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Sekretaris <span>*</span></label>
                    <input type="text" 
                           name="sec_name" 
                           value="{{ old('sec_name', $anggota->sec_name) }}" 
                           required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('sec_name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $anggota->email) }}"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('email')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Link Website</label>
                    <input type="url" 
                           name="link" 
                           value="{{ old('link', $anggota->link) }}"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('link')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="form-footer" style="margin-top: 30px; display: flex; align-items: center;">
                <a href="{{ route('anggota.index') }}" class="btn-upload" style="text-decoration: none;">
                    Kembali
                </a>

                <button type="submit" class="btn-save" style="margin-left:20px; border: none; cursor: pointer;">
                    Update Data
                </button>
            </div>

        </form>

    </div>
</div>

{{-- JS Preview Logo & Update Text --}}
<script>
document.getElementById('logoInput').addEventListener('change', function(e){
    if(this.files && this.files[0]) {
        // Logika Preview Gambar
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);

        // Logika Ubah Teks Tombol Langsung Jadi "Change Logo"
        document.getElementById('labelText').innerText = 'Change Logo';
    }
});
</script>

@endsection