@extends('cms.layouts.master')

@section('title', 'Footer Content')

@section('content')
<style>
    .footer-cms-wrapper {
        padding: 20px;
        background: var(--surface);
        border-radius: var(--radius);
        width: 100%;
    }

    .footer-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .footer-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .footer-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-section-title::before {
        content: '';
        width: 4px;
        height: 18px;
        background: var(--primary, #2563eb);
        border-radius: 2px;
        display: inline-block;
    }

    .image-section {
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 1.5rem;
        width: 100%;
    }

    .preview-box {
        width: 120px;
        height: 120px;
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

    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #fff;
    }

    .image-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    /* Navigation Links Builder */
    .nav-links-group {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
    }

    .nav-link-row {
        display: grid;
        grid-template-columns: 1fr 1fr 40px;
        gap: 10px;
        margin-bottom: 10px;
        align-items: center;
    }

    .nav-link-row:last-child {
        margin-bottom: 0;
    }

    .nav-link-row input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 0.9rem;
    }

    .btn-remove-link {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: background 0.2s;
    }

    .btn-remove-link:hover {
        background: #dc2626;
    }

    .btn-add-link {
        background: transparent;
        color: var(--primary, #2563eb);
        border: 1px dashed var(--primary, #2563eb);
        border-radius: 5px;
        padding: 8px 16px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 10px;
        transition: background 0.2s;
    }

    .btn-add-link:hover {
        background: rgba(37, 99, 235, 0.05);
    }

    /* Toast */
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 99999; }
    .toast {
        background: #fff; color: #16a34a; padding: 15px 25px;
        border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left: 5px solid #16a34a; font-weight: 700;
        animation: slideIn 0.4s forwards;
    }
    .toast.error {
        color: #d9534f;
        border-left-color: #d9534f;
    }
    @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }

    @media (max-width: 768px) {
        .image-section {
            flex-direction: column;
            text-align: center;
        }
        .preview-box {
            margin: 0 auto;
        }
        .nav-link-row {
            grid-template-columns: 1fr;
        }
        .nav-link-row input {
            width: 100%;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group {
            grid-column: span 1 !important;
        }
    }
</style>

<div class="section">
    <div class="sectionHead">
        <div>
            <h2>Footer Content</h2>
            <p>Kelola konten yang ditampilkan di bagian footer website.</p>
        </div>
    </div>

    <div class="footer-cms-wrapper">
        <form action="{{ route('footer.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ====== SECTION: BRAND ====== --}}
            <div class="footer-section">
                <div class="footer-section-title">Brand / Identitas</div>

                <div class="image-section">
                    <div class="preview-box" id="previewContainer" onclick="handlePreviewClick()">
                        @php
                            $logoItem = $footerItems->firstWhere('key', 'logo');
                            $logoSrc = $logoItem && $logoItem->value
                                ? (str_starts_with($logoItem->value, 'footer/')
                                    ? asset('storage/' . $logoItem->value)
                                    : asset($logoItem->value))
                                : 'https://via.placeholder.com/120?text=No+Logo';
                        @endphp
                        <img id="previewImage" src="{{ $logoSrc }}" alt="Logo Footer">
                    </div>

                    <div class="image-info">
                        <div class="upload-btns">
                            <label class="btn-save" style="cursor: pointer; margin: 0; display: inline-block; width: fit-content;">
                                <span id="btnText">{{ $logoItem && $logoItem->value ? 'Ganti Logo' : 'Upload Logo' }}</span>
                                <input type="file" name="logo" id="imageInput" accept="image/*" hidden>
                            </label>
                        </div>
                        <p class="hint">Maks 500kb (JPG, PNG, WEBP, AVIF)</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Nama Organisasi <span>*</span></label>
                        <input type="text" name="org_name"
                               value="{{ old('org_name', optional($footerItems->firstWhere('key', 'org_name'))->value) }}"
                               placeholder="ABTI Jawa Barat" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Deskripsi Organisasi</label>
                        <textarea name="org_description" rows="2"
                                  placeholder="Asosiasi Bola Tangan Indonesia...">{{ old('org_description', optional($footerItems->firstWhere('key', 'org_description'))->value) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ====== SECTION: NAVIGATION COLUMN 1 ====== --}}
            <div class="footer-section">
                <div class="footer-section-title">Navigasi Kolom 1</div>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul Kolom</label>
                        <input type="text" name="nav_col_1_title"
                               value="{{ old('nav_col_1_title', optional($footerItems->firstWhere('key', 'nav_col_1_title'))->value) }}"
                               placeholder="Organisasi">
                    </div>
                </div>

                <div class="nav-links-group" id="navCol1Group">
                    <div style="display:grid; grid-template-columns:1fr 1fr 40px; gap:10px; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#6b7280;">
                        <span>Teks Link</span>
                        <span>URL</span>
                        <span></span>
                    </div>
                    @php
                        $col1Links = json_decode(optional($footerItems->firstWhere('key', 'nav_col_1_links'))->value ?? '[]', true);
                    @endphp
                    @forelse($col1Links as $i => $link)
                    <div class="nav-link-row">
                        <input type="text" name="nav_col_1_links[{{ $i }}][text]" value="{{ $link['text'] }}" placeholder="Teks link">
                        <input type="text" name="nav_col_1_links[{{ $i }}][url]" value="{{ $link['url'] }}" placeholder="/halaman">
                        <button type="button" class="btn-remove-link" onclick="removeNavLink(this)">×</button>
                    </div>
                    @empty
                    <div class="nav-link-row">
                        <input type="text" name="nav_col_1_links[0][text]" placeholder="Teks link">
                        <input type="text" name="nav_col_1_links[0][url]" placeholder="/halaman">
                        <button type="button" class="btn-remove-link" onclick="removeNavLink(this)">×</button>
                    </div>
                    @endforelse
                    <button type="button" class="btn-add-link" onclick="addNavLink('navCol1Group', 'nav_col_1_links')">+ Tambah Link</button>
                </div>
            </div>

            {{-- ====== SECTION: NAVIGATION COLUMN 2 ====== --}}
            <div class="footer-section">
                <div class="footer-section-title">Navigasi Kolom 2</div>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul Kolom</label>
                        <input type="text" name="nav_col_2_title"
                               value="{{ old('nav_col_2_title', optional($footerItems->firstWhere('key', 'nav_col_2_title'))->value) }}"
                               placeholder="Informasi">
                    </div>
                </div>

                <div class="nav-links-group" id="navCol2Group">
                    <div style="display:grid; grid-template-columns:1fr 1fr 40px; gap:10px; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#6b7280;">
                        <span>Teks Link</span>
                        <span>URL</span>
                        <span></span>
                    </div>
                    @php
                        $col2Links = json_decode(optional($footerItems->firstWhere('key', 'nav_col_2_links'))->value ?? '[]', true);
                    @endphp
                    @forelse($col2Links as $i => $link)
                    <div class="nav-link-row">
                        <input type="text" name="nav_col_2_links[{{ $i }}][text]" value="{{ $link['text'] }}" placeholder="Teks link">
                        <input type="text" name="nav_col_2_links[{{ $i }}][url]" value="{{ $link['url'] }}" placeholder="/halaman">
                        <button type="button" class="btn-remove-link" onclick="removeNavLink(this)">×</button>
                    </div>
                    @empty
                    <div class="nav-link-row">
                        <input type="text" name="nav_col_2_links[0][text]" placeholder="Teks link">
                        <input type="text" name="nav_col_2_links[0][url]" placeholder="/halaman">
                        <button type="button" class="btn-remove-link" onclick="removeNavLink(this)">×</button>
                    </div>
                    @endforelse
                    <button type="button" class="btn-add-link" onclick="addNavLink('navCol2Group', 'nav_col_2_links')">+ Tambah Link</button>
                </div>
            </div>

            {{-- ====== SECTION: KONTAK ====== --}}
            <div class="footer-section">
                <div class="footer-section-title">Kontak</div>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul Kolom Kontak</label>
                        <input type="text" name="contact_title"
                               value="{{ old('contact_title', optional($footerItems->firstWhere('key', 'contact_title'))->value) }}"
                               placeholder="Kontak">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="contact_email"
                               value="{{ old('contact_email', optional($footerItems->firstWhere('key', 'contact_email'))->value) }}"
                               placeholder="sekretariat@abtijabar.or.id">
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="contact_phone"
                               value="{{ old('contact_phone', optional($footerItems->firstWhere('key', 'contact_phone'))->value) }}"
                               placeholder="+62 22 0000 0000">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Alamat</label>
                        <input type="text" name="contact_address"
                               value="{{ old('contact_address', optional($footerItems->firstWhere('key', 'contact_address'))->value) }}"
                               placeholder="Bandung, Jawa Barat">
                    </div>
                </div>
            </div>

            {{-- ====== SECTION: COPYRIGHT ====== --}}
            <div class="footer-section">
                <div class="footer-section-title">Copyright</div>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Teks Copyright</label>
                        <input type="text" name="copyright"
                               value="{{ old('copyright', optional($footerItems->firstWhere('key', 'copyright'))->value) }}"
                               placeholder="© 2026 Asosiasi Bola Tangan Indonesia">
                    </div>
                </div>
            </div>

            {{-- ====== SUBMIT ====== --}}
            <div class="form-footer" style="display:flex; gap:10px; margin-top:20px;">
                <a href="{{ route('footer.index') }}" class="btn-upload">Reset</a>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- IMAGE MODAL --}}
<div id="imageModal" style="display:none; position:fixed; z-index:100000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.85); align-items:center; justify-content:center;" onclick="this.style.display='none'">
    <img id="modalImg" style="max-width:90%; max-height:90%; border-radius:10px;">
</div>

{{-- TOAST --}}
<div id="toastContainer" class="toast-container"></div>

<script>
    // Image preview
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const btnText = document.getElementById('btnText');
    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');

    function handlePreviewClick() {
        if (previewImage.src.includes('placeholder')) {
            showToast('⚠️ Belum ada gambar untuk ditampilkan!', 'error');
        } else {
            imageModal.style.display = "flex";
            modalImg.src = previewImage.src;
        }
    }

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 500 * 1024) {
            showToast('❌ File terlalu besar! Maksimal 500KB.', 'error');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            previewImage.src = event.target.result;
            if (btnText) btnText.innerText = 'Ganti Logo';
            showToast('✅ Logo baru dipilih!');
        };
        reader.readAsDataURL(file);
    });

    // Navigation links builder
    function addNavLink(groupId, fieldName) {
        const group = document.getElementById(groupId);
        const rows = group.querySelectorAll('.nav-link-row');
        const index = rows.length;

        const row = document.createElement('div');
        row.className = 'nav-link-row';
        row.innerHTML = `
            <input type="text" name="${fieldName}[${index}][text]" placeholder="Teks link">
            <input type="text" name="${fieldName}[${index}][url]" placeholder="/halaman">
            <button type="button" class="btn-remove-link" onclick="removeNavLink(this)">×</button>
        `;

        const addBtn = group.querySelector('.btn-add-link');
        group.insertBefore(row, addBtn);
    }

    function removeNavLink(btn) {
        const row = btn.closest('.nav-link-row');
        const group = row.closest('.nav-links-group');
        const rows = group.querySelectorAll('.nav-link-row');

        if (rows.length <= 1) {
            // Clear inputs instead of removing last row
            row.querySelectorAll('input').forEach(input => input.value = '');
            showToast('⚠️ Minimal harus ada 1 baris link.', 'error');
            return;
        }

        row.remove();
    }

    // Toast
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = 'toast' + (type === 'error' ? ' error' : '');
        toast.innerText = message;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = '0.5s';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // Show success toast on page load if redirected with success
    @if(session('success'))
        showToast('✅ {{ session('success') }}');
    @endif
</script>
@endsection
