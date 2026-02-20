@extends('layouts.master')

@section('title', 'Add Sponsor')

@section('content')
<style>
    /* ---------- Layout Utama ---------- */
    .bignews-wrapper {
        padding: 20px;
        background: var(--surface);
        border-radius: var(--radius);
        width: 100%;
    }

    /* Container Image Section */
    .image-section {
        display: flex;
        align-items: center; /* Desktop: Sejajar tengah secara vertikal */
        gap: 30px;
        margin-bottom: 2rem;
        width: 100%;
    }

    .preview-box {
        width: 150px; 
        height: 150px;
        background: #fdfdfd;
        border-radius: 8px;
        overflow: hidden;
        display: flex; 
        align-items: center; 
        justify-content: center;
        border: 2px solid #ddd;
        flex-shrink: 0;
        cursor: pointer;
    }
    .preview-box img { width: 100%; height: 100%; object-fit: contain; background: #fff; }

    .image-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .upload-btns {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* ---------- RESPONSIVE MODE (MOBILE) ---------- */
    @media (max-width: 768px) {
        .image-section {
            flex-direction: column; /* Gambar di atas, tombol di bawah */
            justify-content: center;
            text-align: center;
            gap: 20px;
        }

        .preview-box {
            margin: 0 auto; /* Kotak preview ke tengah */
        }

        .image-info {
            width: 100%;
        }

        .upload-btns {
            flex-direction: column; /* Tombol jadi numpuk */
            width: 100%;
        }

        /* Tombol & Label jadi Width 100% */
        .upload-btns .btn-save, 
        .upload-btns .btn-upload {
            width: 100%;
            display: block;
            margin: 0 !important;
            padding: 14px 0; /* Lebih tebal di HP biar enak dipencet */
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr; /* Form input jadi 1 kolom */
        }

        .form-group {
            grid-column: span 1 !important;
        }
    }

    /* ---------- Toast & Modal Tetap Sama ---------- */
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 99999; }
    .toast {
        background: #fff; color: #d9534f; padding: 15px 25px;
        border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left: 5px solid #d9534f; font-weight: 700;
        animation: slideIn 0.4s forwards;
    }
    @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
</style>

<div class="section">
    <div class="sectionHead">
        <h2>Tambah Sponsor</h2>
    </div>

    <div class="bignews-wrapper">
        <form action="{{ route('sponsor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="image-section">
                <div class="preview-box" id="previewContainer" onclick="handlePreviewClick()">
    <img id="previewImage" 
         src="https://via.placeholder.com/150?text=No+Logo" 
         alt="Preview">
</div>

                <div class="image-info">
                    <div class="upload-btns">
                        <label class="btn-save" style="cursor: pointer; margin: 0;">
                            <span id="btnText">Upload Logo</span>
                            <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                        </label>
                        
                    </div>
                    <p class="hint">Maks 300kb (JPG, PNG, WEBP)</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nama Sponsor / Mitra <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Bank Jabar" required>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Link Website (Opsional)</label>
                    <input type="url" name="link" value="{{ old('link') }}" placeholder="https://example.com">
                </div>
            </div>

            <div class="form-footer" style="display:flex;gap:10px;">
                <a href="{{ route('sponsor.index') }}" class="btn-upload">Kembali</a>
                <button type="submit" class="btn-save">Simpan Sponsor</button>
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
    const btnText = document.getElementById('btnText');
    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');

    // --- PERBAIKAN LOGIKA DISINI ---
    function handlePreviewClick() {
        // Cek apakah src masih placeholder (belum ada gambar)
        if (previewImage.src.includes('placeholder')) {
            // HANYA munculkan Toast, jangan panggil imageInput.click()
            showToast('⚠️ Belum ada gambar untuk ditampilkan!');
        } else {
            // Kalau sudah ada gambarnya, baru tampilkan modal zoom
            imageModal.style.display = "flex";
            modalImg.src = previewImage.src;
        }
    }

    // Input Change Logic (Tetap sama, dipicu oleh tombol label Upload)
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
            if(btnText) btnText.innerText = 'Change Logo';
            showToast('✅ Logo berhasil dipilih!');
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