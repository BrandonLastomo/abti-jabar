@extends('layouts.master')

@section('title', 'Edit Sponsor')

@section('content')
<style>
    /* Menggunakan style yang sama dengan add-sponsor */
    .bignews-wrapper { padding: 20px; background: var(--surface); border-radius: var(--radius); width: 100%; }
    .image-section { display: flex; align-items: center; gap: 30px; margin-bottom: 2rem; width: 100%; }
    .preview-box { 
        width: 150px; height: 150px; background: #fdfdfd; border-radius: 8px; 
        overflow: hidden; display: flex; align-items: center; justify-content: center; 
        border: 2px solid #ddd; flex-shrink: 0; cursor: pointer;
    }
    .preview-box img { width: 100%; height: 100%; object-fit: contain; background: #fff; }
    .image-info { display: flex; flex-direction: column; gap: 12px; flex: 1; }
    
    @media (max-width: 768px) {
        .image-section { flex-direction: column; text-align: center; }
        .preview-box { margin: 0 auto; }
        .form-grid { grid-template-columns: 1fr; }
    }

    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 99999; }
    .toast { 
        background: #fff; color: #d9534f; padding: 15px 25px; border-radius: 8px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-left: 5px solid #d9534f; 
        font-weight: 700; animation: slideIn 0.4s forwards; 
    }
    @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
</style>

<div class="section">
    <div class="sectionHead">
        <h2>Edit Sponsor</h2>
    </div>

    <div class="bignews-wrapper">
        <form action="{{ route('sponsor.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="image-section">
                <div class="preview-box" id="previewContainer" onclick="handlePreviewClick()">
                    {{-- Menampilkan gambar lama jika ada, jika tidak pakai placeholder --}}
                    <img id="previewImage" 
                         src="{{ $sponsor->image ? asset('storage/' . $sponsor->image) : 'https://via.placeholder.com/150?text=No+Logo' }}" 
                         alt="Preview">
                </div>

                <div class="image-info">
                    <div class="upload-btns">
                        <label class="btn-save" style="cursor: pointer; margin: 0; display: inline-block; width: fit-content;">
                            <span id="btnText">Change Logo</span>
                            <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                        </label>
                    </div>
                    <p class="hint">Maks 300kb (JPG, PNG, WEBP)</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2; margin-bottom: 15px;">
                    <label>Nama Sponsor / Mitra <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name', $sponsor->name) }}" required>
                </div>

                <div class="form-group" style="grid-column: span 2; margin-bottom: 15px;">
                    <label>Link Website (Opsional)</label>
                    <input type="url" name="link" value="{{ old('link', $sponsor->link) }}">
                </div>
            </div>

            <div class="form-footer" style="display:flex; gap:10px; margin-top: 20px;">
                <a href="{{ route('sponsor.index') }}" class="btn-upload">Batal</a>
                <button type="submit" class="btn-save">Update Sponsor</button>
            </div>
        </form>
    </div>
</div>

<div id="imageModal" style="display:none; position:fixed; z-index:100000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.85); align-items:center; justify-content:center;" onclick="this.style.display='none'">
    <img id="modalImg" style="max-width:90%; max-height:90%; border-radius:10px;">
</div>

<div id="toastContainer" class="toast-container"></div>

<script>
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');

    function handlePreviewClick() {
        if (previewImage.src.includes('placeholder')) {
            showToast('⚠️ Belum ada gambar untuk ditampilkan!');
        } else {
            imageModal.style.display = "flex";
            modalImg.src = previewImage.src;
        }
    }

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 300 * 1024) {
            showToast('❌ File terlalu besar! Maksimal 300KB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            previewImage.src = event.target.result;
            showToast('✅ Logo baru dipilih!');
        };
        reader.readAsDataURL(file);
    });

    function showToast(message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerText = message;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = '0.5s';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
</script>
@endsection