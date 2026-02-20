@extends('layouts.master')

@section('title', 'About CMS')

@section('content')
<style>
    /* ---------- Layout Dasar ---------- */
    .about-grid { 
        display: flex; 
        flex-direction: column; 
        gap: var(--gap-lg); 
        padding: 10px;
        max-width: var(--max);
        margin: 0 auto;
    }

    .itemCard { 
        background: var(--surface); 
        border-radius: var(--radius); 
        box-shadow: var(--shadow); 
        overflow: hidden; 
        border: 1px solid var(--border); 
        margin-bottom: 2rem;
    }

    .itemTop { 
        padding: 1.25rem 1.5rem; 
        background: var(--surface-2); 
        border-bottom: 1px solid var(--border-2); 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }

    .itemTop b { color: var(--text); font-size: 1.1rem; }
    .card-body { padding: 1.5rem; }

    /* ---------- Tab System ---------- */
    .tabs { 
        display: flex; 
        gap: 15px; 
        margin-bottom: 25px; 
        border-bottom: 2px solid var(--border-2); 
    }

    .tab-link { 
        padding: 10px 0; 
        cursor: pointer; 
        border-bottom: 2px solid transparent; 
        margin-bottom: -2px; 
        transition: 0.3s; 
        font-weight: 700; 
        color: var(--muted); 
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .tab-link.active { border-color: var(--red); color: var(--red); }
    .tab-content { display: none; animation: fadeIn 0.3s; }
    .tab-content.active { display: block; }

    /* ---------- Form & Inputs ---------- */
    .field-group { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
        gap: 1.25rem; 
        margin-bottom: 1.5rem; 
    }

    .field { display: flex; flex-direction: column; gap: 8px; margin-bottom: 1.25rem; }
    .field label { font-weight: 700; font-size: 0.85rem; color: var(--text); }

    input, textarea {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 12px;
        font-family: var(--font);
        background: var(--bg-soft);
        color: var(--text);
        transition: 0.2s;
    }

    input:focus, textarea:focus {
        border-color: var(--red);
        background: var(--surface);
        box-shadow: var(--ring);
        outline: none;
    }

    /* ---------- Image Preview ---------- */
   .image-upload-wrapper {
        display: flex;
        flex-wrap: wrap; 
        align-items: flex-start;
        gap: 20px;
        background: var(--surface-2);
        padding: 20px;
        border-radius: var(--radius-sm);
        border: 1px dashed var(--border);
    }

    .preview-box {
        width: 180px; height: 120px;
        background: var(--border-2);
        border-radius: var(--radius-sm);
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }

    .preview-box img {
        width: 100%; height: 100%; object-fit: cover;
        cursor: zoom-in; transition: 0.2s;
    }

    .preview-box img:hover { opacity: 0.8; }

    .dynamic-list-item { 
        background: var(--surface); 
        padding: 12px; 
        border-radius: var(--radius-sm); 
        margin-bottom: 8px; 
        border: 1px solid var(--border-2);
        display: flex; gap: 10px; align-items: center;
    }

    .btn.primary {
        background: var(--red); color: #fff; border: none;
        padding: 14px 28px; border-radius: var(--radius-sm);
        font-weight: 700; cursor: pointer; box-shadow: var(--shadow-sm);
    }

    .btn-edit {
        background: var(--surface); border: 1px solid var(--border);
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-weight: 600; font-size: 0.8rem; cursor: pointer;
    }

    /* Toast */
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 10000; }
    .toast {
        background: white; color: var(--red); padding: 12px 20px;
        border-radius: var(--radius-sm); box-shadow: var(--shadow);
        display: flex; align-items: center; gap: 10px;
        border-left: 4px solid var(--red); font-weight: 600;
        animation: slideIn 0.3s ease-out forwards;
    }

    @media (max-width: 600px) {
        .image-upload-wrapper { flex-direction: column; align-items: stretch; }
        .preview-box { width: 100%; height: 200px; }
        .upload-info { text-align: center; }
        .btn.primary { width: 100%; }
    }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

<div class="section">
    <div class="sectionHead" style="margin-bottom: 2rem;">
        <div>
            <h2 >About Content Manager</h2>
            <p style="color: var(--muted);">Data di bawah akan langsung mengupdate tampilan landing page.</p>
        </div>
    </div>

    @if(session('success'))
        <script>window.onload = () => showToast("{{ session('success') }}");</script>
    @endif

    <div class="about-grid">
        @php
            $sections = [
                ['id' => 'history', 'title' => 'Sejarah'],
                ['id' => 'visi', 'title' => 'Visi & Misi'],
                ['id' => 'organisasi', 'title' => 'Organisasi']
            ];
        @endphp

        @foreach($sections as $sec)
        @php
            $data = $aboutData[$sec['id']] ?? null; 
        @endphp
        <div class="itemCard">
            <div class="itemTop">
                <b>{{ $sec['title'] }}</b>
                <span style="font-size: 0.75rem; color: var(--muted);">
                    Last Updated: {{ $data ? $data->updated_at->diffForHumans() : 'Never' }}
                </span>
            </div>

            <div class="card-body">
                <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="{{ $sec['id'] }}">

                    <div class="tabs">
                        <div class="tab-link active" onclick="openTab(event, '{{ $sec['id'] }}-main')">General Content</div>
                        <div class="tab-link" onclick="openTab(event, '{{ $sec['id'] }}-mobile')">Mobile Layout</div>
                    </div>

                    {{-- TAB MAIN --}}
                    <div id="{{ $sec['id'] }}-main" class="tab-content active">
                        <div class="field-group">
                            <div class="field">
                                <label>Header Kicker</label>
                                <input type="text" name="kicker" value="{{ $data->kicker ?? '' }}" placeholder="e.g. HISTORY">
                            </div>
                            <div class="field">
                                <label>Main Title (Desktop)</label>
                                <input type="text" name="title" value="{{ $data->title ?? '' }}" placeholder="Judul utama tampilan desktop">
                            </div>
                        </div>

                        {{-- Main Description HANYA muncul jika BUKAN Visi Misi --}}
                        @if($sec['id'] !== 'visi')
                        <div class="field">
                            <label>Main Description</label>
                            <textarea name="desc" rows="4" placeholder="Tuliskan isi konten utama di sini...">{{ $data->desc ?? '' }}</textarea>
                        </div>
                        @endif

                        <hr style="border: 0; border-top: 1px solid var(--border-2); margin: 1.5rem 0;">

                        {{-- SEJARAH / HISTORY --}}
                        @if($sec['id'] == 'history')
                            <div class="field">
                                <label>Timeline Journey (Milestones)</label>
                                <div id="timelineWrapper">
                                    @if($data && $data->timeline)
                                        @foreach(json_decode($data->timeline) as $item)
                                        <div class="dynamic-list-item">
                                            <input type="text" name="timeline_title[]" value="{{ $item->title }}" placeholder="Title" style="flex:1;">
                                            <input type="text" name="timeline_subtitle[]" value="{{ $item->subtitle }}" placeholder="Subtitle" style="flex:1;">
                                            <button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer; font-size:1.2rem;">&times;</button>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn-edit" onclick="addTimeline()">+ Add Milestone</button>
                            </div>

                        {{-- VISI MISI --}}
                        @elseif($sec['id'] == 'visi')
                            <div class="field-group">
                                <div class="field">
                                    <label>Visi Points</label>
                                    <div id="visiWrapper">
                                        @if($data && $data->visi)
                                            @foreach(json_decode($data->visi) as $v)
                                            <div class="dynamic-list-item">
                                                <input type="text" name="visi[]" value="{{ $v }}" style="flex:1;">
                                                <button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn-edit" onclick="addVisi()">+ Add Visi</button>
                                </div>
                                <div class="field">
                                    <label>Misi Points</label>
                                    <div id="misiWrapper">
                                        @if($data && $data->misi)
                                            @foreach(json_decode($data->misi) as $m)
                                            <div class="dynamic-list-item">
                                                <input type="text" name="misi[]" value="{{ $m }}" style="flex:1;">
                                                <button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn-edit" onclick="addMisi()">+ Add Misi</button>
                                </div>
                            </div>

                        {{-- ORGANISASI --}}
                        @else
                            <div class="field">
                                <label>Organization Tags / Expertise</label>
                                <div id="tagWrapper" style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                                    @if($data && $data->tag)
                                        @foreach(json_decode($data->tag) as $t)
                                        <div class="dynamic-list-item" style="padding: 5px 10px; border-left: 2px solid var(--red);">
                                            <input type="text" name="tag[]" value="{{ $t }}" style="border:none; background:none; width:80px; font-size:0.8rem;">
                                            <button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn-edit" onclick="addTag()">+ Add Tag</button>
                            </div>
                        @endif

                        <div class="field">
                            <label>Section Image</label>
                            <div class="image-upload-wrapper">
                                <div class="preview-box">
                                    <img id="{{ $sec['id'] }}Preview" src="{{ ($data && $data->image) ? asset('storage/'.$data->image) : 'https://via.placeholder.com/180x120?text=No+Image' }}">
                                </div>
                                <div class="upload-info">
                                    <label class="btn primary" style="padding: 8px 16px; font-size: 0.8rem; display: inline-block;">
                                        Change Image
                                        <input type="file" name="image" id="{{ $sec['id'] }}Input" accept="image/*" hidden onchange="previewFile('{{ $sec['id'] }}')">
                                    </label>
                                    <p style="font-size: 0.75rem; color: var(--muted); margin-top: 10px;">Max 2MB. Re-upload will replace the current image.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB MOBILE --}}
                    <div id="{{ $sec['id'] }}-mobile" class="tab-content">
                        <div class="field">
                            <label>Mobile Title</label>
                            <input type="text" name="mobile_title" value="{{ $data->mobile_title ?? '' }}" placeholder="Judul ringkas">
                        </div>
                        <div class="field">
                            <label>Mobile Description</label>
                            <textarea name="mobile_desc" rows="3" placeholder="Deskripsi pendek">{{ $data->mobile_desc ?? '' }}</textarea>
                        </div>
                    </div>

                    <div style="margin-top: 2.5rem; display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn primary">Update {{ $sec['title'] }} Section</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- MODAL PREVIEW GAMBAR --}}
<div id="imageModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.8); align-items:center; justify-content:center; cursor:zoom-out;" onclick="this.style.display='none'">
    <img id="modalImg" style="max-width:90%; max-height:90%; border-radius:var(--radius); box-shadow: 0 0 20px rgba(0,0,0,0.5);">
</div>

<div id="toastContainer" class="toast-container"></div>

<script>
// Logic Tab
function openTab(evt, tabName) {
    const parent = evt.currentTarget.closest('.itemCard');
    const tabcontent = parent.getElementsByClassName("tab-content");
    for (let i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
    const tablinks = parent.getElementsByClassName("tab-link");
    for (let i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Preview Gambar
function previewFile(sectionId) {
    const preview = document.getElementById(sectionId + 'Preview');
    const file = document.getElementById(sectionId + 'Input').files[0];
    const reader = new FileReader();

    reader.onloadend = function () { preview.src = reader.result; }
    if (file) { reader.readAsDataURL(file); }
}

// Toast
function showToast(message) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => { 
        toast.style.animation = 'fadeOut 0.3s forwards'; 
        setTimeout(() => toast.remove(), 300); 
    }, 3000);
}

// Modal Click
document.querySelectorAll('.preview-box img').forEach(img => {
    img.onclick = function() {
        if (this.src.includes('placeholder')) return;
        document.getElementById("imageModal").style.display = "flex";
        document.getElementById("modalImg").src = this.src;
    }
});

function removeElement(btn) { btn.closest('.dynamic-list-item').remove(); }

// Dynamic Inputs
function addTimeline(){
    document.getElementById('timelineWrapper').insertAdjacentHTML('beforeend', `
        <div class="dynamic-list-item">
            <input type="text" name="timeline_title[]" placeholder="Title" style="flex: 1;">
            <input type="text" name="timeline_subtitle[]" placeholder="Subtitle" style="flex: 1;">
            <button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button>
        </div>
    `);
}

function addVisi(){
    document.getElementById('visiWrapper').insertAdjacentHTML('beforeend', `<div class="dynamic-list-item"><input type="text" name="visi[]" placeholder="Visi..." style="flex:1;"><button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button></div>`);
}

function addMisi(){
    document.getElementById('misiWrapper').insertAdjacentHTML('beforeend', `<div class="dynamic-list-item"><input type="text" name="misi[]" placeholder="Misi..." style="flex:1;"><button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button></div>`);
}

function addTag(){
    document.getElementById('tagWrapper').insertAdjacentHTML('beforeend', `<div class="dynamic-list-item" style="padding: 5px 10px; border-left: 2px solid var(--red);"><input type="text" name="tag[]" placeholder="Tag" style="border:none; background:none; width:80px; font-size:0.8rem;"><button type="button" onclick="removeElement(this)" style="color:var(--red); border:none; background:none; cursor:pointer;">&times;</button></div>`);
}
</script>
@endsection