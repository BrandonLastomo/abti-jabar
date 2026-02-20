@extends('layouts.master')

@section('title', 'Sponsor & Mitra')

@section('content')
<style>
   
    /* Style untuk Modal Zoom Gambar */
    .image-modal-overlay {
        display: none;
        position: fixed;
        z-index: 100000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }
    .image-modal-overlay img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 10px;
        cursor: default;
    }
</style>

<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Sponsor & Mitra</h2>
                <p>Daftar logo perusahaan yang bekerja sama.</p>
            </div>
            <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
                <a href="{{ route('sponsor.create') }}" class="btn primary">
                    Add Sponsor
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama Sponsor</th>
                        <th>Link</th>
                        <th>Tanggal Input</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
    @if($sponsors->count() == 0)
    <tr>
        <td colspan="5" style="text-align:center;">
            Belum ada data sponsor.
        </td>
    </tr>
    @endif

    @foreach($sponsors as $item)
    <tr>
        {{-- STATUS LOGO --}}
        <td>
            @if($item->image)
                <span class="status uploaded">Uploaded</span>
            @else
                <span class="status not-uploaded">Not Uploaded</span>
            @endif
        </td>

        {{-- NAMA --}}
        <td style="font-weight: 600;">
            {{ $item->name }}
        </td>

        {{-- LINK WEBSITE --}}
        <td>
            @if($item->link)
                <a href="{{ $item->link }}" target="_blank" title="{{ $item->link }}">
                    {{ Str::limit($item->link, 30) }}
                </a>
            @else
                <span style="color: var(--muted); font-style: italic;">No Link</span>
            @endif
        </td>

        {{-- TANGGAL --}}
        <td>
            {{ $item->created_at->format('d/m/Y') }}
        </td>

        {{-- ACTION --}}
        <td class="actions" style="white-space: nowrap;">
            {{-- VIEW: Menggunakan tag <a> dan class btn btn-edit --}}
            <a href="{{ route('sponsor.show', $item->id) }}" class="btn btn-edit">
                View
            </a>

            <a href="{{ route('sponsor.edit', $item->id) }}" class="btn btn-edit">
                Edit
            </a>

            <form id="deleteForm{{ $item->id }}" action="{{ route('sponsor.destroy', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete" 
                    onclick="showAlert('Hapus Sponsor', 'Apakah Anda yakin ingin menghapus logo {{ $item->name }}?', function() { document.getElementById('deleteForm{{ $item->id }}').submit(); })">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-bottom">
            <div class="pagination-custom">
                @if ($sponsors->onFirstPage())
                    <span class="disabled">&lt;</span>
                @else
                    <a href="{{ $sponsors->previousPageUrl() }}">&lt;</a>
                @endif

                @for ($i = 1; $i <= $sponsors->lastPage(); $i++)
                    @if ($i == $sponsors->currentPage())
                        <span class="active">{{ $i }}</span>
                    @else
                        <a href="{{ $sponsors->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if ($sponsors->hasMorePages())
                    <a href="{{ $sponsors->nextPageUrl() }}">&gt;</a>
                @else
                    <span class="disabled">&gt;</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL ZOOM GAMBAR --}}
<div id="imageModalZoom" class="image-modal-overlay" onclick="closeZoom()">
    <img id="modalImgContent" onclick="event.stopPropagation()">
</div>

{{-- MODAL ALERT --}}
<div id="customAlert" class="alert-overlay">
    <div class="alert-box">
        <h3 id="alertTitle">Konfirmasi</h3>
        <p id="alertMessage">Yakin mau hapus data ini?</p>
        <div class="alert-actions">
            <button id="cancelBtn" class="btn btn-edit">Batal</button>
            <button id="confirmBtn" class="btn btn-delete">Hapus</button>
        </div>
    </div>
</div>

<script>
    // Logika Modal Zoom Gambar
    const zoomModal = document.getElementById('imageModalZoom');
    const zoomImg = document.getElementById('modalImgContent');

    function openZoom(src) {
        zoomImg.src = src;
        zoomModal.style.display = 'flex';
    }

    function closeZoom() {
        zoomModal.style.display = 'none';
    }

    // Logika Custom Alert
    let confirmCallback = null;
    const alertBox = document.getElementById('customAlert');
    const alertTitle = document.getElementById('alertTitle');
    const alertMsg = document.getElementById('alertMessage');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');

    function showAlert(title, message, callback = null) {
        alertTitle.innerText = title;
        alertMsg.innerText = message;
        confirmCallback = callback;
        alertBox.style.display = 'flex';
    }

    cancelBtn.onclick = () => alertBox.style.display = 'none';
    confirmBtn.onclick = function() {
        this.classList.add('loading');
        this.innerText = 'Menghapus...';
        if (typeof confirmCallback === "function") confirmCallback();
    };
</script>
@endsection