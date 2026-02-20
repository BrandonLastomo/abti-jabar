@extends('cms.layouts.master')

@section('title', 'Hero Settings')

@section('content')
<form action="{{ route('hero.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="section">
        <div class="sectionHead" style="margin-left: -20px;margin-bottom: 20px;">
            <div>
                <h2>Hero Section</h2>
                <p>Konfigurasi visual utama halaman depan Anda.</p>
            </div>
            <div class="pill">Main Hero</div>
        </div>

        {{-- GRID UNTUK IMAGE SECTION --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            
            {{-- DESKTOP IMAGE --}}
            <div class="field">
                <div class="labelRow" style="margin-bottom: 10px;">
                    <label style="font-weight: 700;">Hero Image Desktop</label>
                </div>
                
                <div class="image-section" style="background: #fdfdfd; border: 2px dashed #e0e0e0; padding: 20px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; gap: 15px;">
                    {{-- WADAH FIXED 16:9 --}}
                    <div class="image-preview" onclick="openModal('prev-desktop')" 
                         style="cursor: zoom-in; width: 100%; max-width: 400px; aspect-ratio: 16/9; overflow: hidden; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: #eee;">
                        <img id="prev-desktop" 
                             src="{{ $hero && $hero->image_desktop ? asset('storage/'.$hero->image_desktop) : 'https://via.placeholder.com/640x360?text=No+Desktop+Image' }}" 
                             alt="Preview Desktop" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="image-info" style="text-align: center;">
                        <label class="btn-save" style="cursor: pointer; display: inline-flex; align-items: center; padding: 8px 25px; font-size: 13px; background-color: #d92128; border:none; color: white; border-radius: 8px;">
                            <span id="txt-desktop">{{ $hero && $hero->image_desktop ? 'Change Image' : 'Upload Image' }}</span>
                            <input type="file" name="image_desktop" id="in-desktop" hidden accept="image/*">
                        </label>
                        <p class="hint" style="margin-top: 10px; font-size: 11px; color: #999;">
                            Rasio 16:9 • Maks 300kb (JPG, PNG, WEBP)
                        </p>
                    </div>
                </div>
            </div>

            {{-- MOBILE IMAGE --}}
            <div class="field">
                <div class="labelRow" style="margin-bottom: 10px;">
                    <label style="font-weight: 700;">Hero Image Mobile</label>
                </div>

                <div class="image-section" style="background: #fdfdfd; border: 2px dashed #e0e0e0; padding: 20px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; gap: 15px;">
                    {{-- WADAH FIXED 1:1 --}}
                    <div class="image-preview" onclick="openModal('prev-mobile')" 
                         style="cursor: zoom-in; width: 100%; max-width: 180px; aspect-ratio: 1/1; overflow: hidden; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: #eee;">
                        <img id="prev-mobile" 
                             src="{{ $hero && $hero->image_mobile ? asset('storage/'.$hero->image_mobile) : 'https://via.placeholder.com/300x300?text=No+Mobile+Image' }}" 
                             alt="Preview Mobile" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="image-info" style="text-align: center;">
                        <label class="btn-save" style="cursor: pointer; display: inline-flex; align-items: center; padding: 8px 25px; font-size: 13px; background-color: #d92128; border:none; color: white; border-radius: 8px;">
                            <span id="txt-mobile">{{ $hero && $hero->image_mobile ? 'Change Image' : 'Upload Image' }}</span>
                            <input type="file" name="image_mobile" id="in-mobile" hidden accept="image/*">
                        </label>
                        <p class="hint" style="margin-top: 10px; font-size: 11px; color: #999;">
                            Rasio 1:1 • Maks 300kb (JPG, PNG, WEBP)
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- TEXT CONTENT --}}
        <div class="grid2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="field">
                <div class="labelRow">
                    <label>Hero Kicker</label>
                </div>
                <input type="text" name="kicker" value="{{ old('kicker', $hero->kicker ?? '') }}" placeholder="Contoh: Asosiasi Bola Tangan Indonesia" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="field">
                <div class="labelRow">
                    <label>Hero Big Title</label>
                </div>
                <input type="text" name="big" value="{{ old('big', $hero->big ?? '') }}" placeholder="Contoh: Provinsi Jawa Barat" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="field" style="grid-column: 1 / -1;">
                <div class="labelRow">
                    <label>Hero Description</label>
                </div>
                <textarea name="desc" rows="4" placeholder="Masukkan deskripsi singkat di sini..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: vertical;">{{ old('desc', $hero->desc ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="form-footer" style="margin-top: 30px; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn-save" style="padding: 12px 40px; border-radius: 8px; font-weight: 600; background-color: #d92128; color: white; border: none; cursor: pointer;">Save Changes</button>
    </div>
</form>

{{-- MODAL PREVIEW --}}
<div id="imageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); align-items: center; justify-content: center; backdrop-filter: blur(5px);" onclick="this.style.display='none'">
    <img id="modalImg" style="max-width: 90%; max-height: 80%; border-radius: 12px; border: 3px solid #fff;">
</div>

<script>
    function setupHeroPreview(inputId, imgId, textId) {
        document.getElementById(inputId).addEventListener('change', function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imgId).src = e.target.result;
                    document.getElementById(textId).innerText = "Change Image";
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    setupHeroPreview('in-desktop', 'prev-desktop', 'txt-desktop');
    setupHeroPreview('in-mobile', 'prev-mobile', 'txt-mobile');

    function openModal(imgElementId) {
        const src = document.getElementById(imgElementId).src;
        if(src.includes('placeholder')) return; 
        document.getElementById('modalImg').src = src;
        document.getElementById('imageModal').style.display = 'flex';
    }
</script>
@endsection