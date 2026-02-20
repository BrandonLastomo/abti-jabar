@extends('layouts.master')

@section('title', 'Kegiatan')

@section('content')


<div>
  <div class="section">

    <div class="sectionHead">
      <div>
        <h2>Kegiatan</h2>
      </div>

      <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
      <a href="{{ route('kegiatan.create') }}" class="btn primary">
    Add Kegiatan
</a>

      </div>
    </div>

    <div class="table-wrapper">
  <table class="custom-table">
        <thead>
          <tr>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Slug</th>
              <th>Link</th>
              <th>Tanggal</th>
              <th>Image</th>
              <th>Action</th>
          </tr>
        </thead>

        <tbody>

        @if($kegiatan->count() == 0)
        <tr>
            <td colspan="6" style="text-align:center;">
                Belum ada data kegiatan
            </td>
        </tr>
        @endif

        @foreach($kegiatan as $item)
        <tr>

            {{-- NAMA --}}
            <td title="{{ $item->name }}">
                {{ Str::limit($item->name, 20, '...') }}
            </td>

            {{-- DESKRIPSI --}}
            <td title="{{ strip_tags($item->desc) }}">
                {{ Str::limit(strip_tags($item->desc), 20, '...') }}
            </td>

            {{-- LINK --}}
            <td>
                @if($item->slug)
                    <a href="{{ $item->slug }}" target="_blank"
                       title="{{ $item->slug }}">
                       {{ Str::limit($item->slug, 25, '...') }}
                    </a>
                @else
                    -
                @endif
            </td>
           <td>
                @if($item->link)
                    <a href="{{ $item->link }}" target="_blank" title="{{ $item->link }}" style="color: var(--red);">
                        {{ Str::limit($item->link, 25, '...') }}
                    </a>
                @else
                    <span></span>
                @endif
            </td>

            {{-- TANGGAL --}}
            <td>
                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
            </td>

            {{-- IMAGE --}}
            <td>
                @if($item->image)
                    <span class="status uploaded">Uploaded</span>
                @else
                    <span class="status not-uploaded">Not Uploaded</span>
                @endif
            </td>

            {{-- ACTION --}}
            <td class="actions" style="white-space: nowrap;">
    <a href="{{ route('kegiatan.show', $item) }}"
       class="btn btn-view">
       View
    </a>

    <a href="{{ route('kegiatan.edit', $item) }}"
       class="btn btn-edit">
       Edit
    </a>

    <form id="deleteForm{{ $item->slug }}"
          action="{{ route('kegiatan.destroy', $item) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button type="button"
            class="btn btn-delete"
            onclick="showAlert(
                'Hapus Data',
                'Data ini akan dihapus permanen.',
                function() {
                    document.getElementById('deleteForm{{ $item->slug }}').submit();
                }
            )">
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

        @if ($kegiatan->onFirstPage())
          <span class="disabled">&lt;</span>
        @else
          <a href="{{ $kegiatan->previousPageUrl() }}">&lt;</a>
        @endif

        @for ($i = 1; $i <= $kegiatan->lastPage(); $i++)
          @if ($i == $kegiatan->currentPage())
            <span class="active">{{ $i }}</span>
          @else
            <a href="{{ $kegiatan->url($i) }}">{{ $i }}</a>
          @endif
        @endfor

        @if ($kegiatan->hasMorePages())
          <a href="{{ $kegiatan->nextPageUrl() }}">&gt;</a>
        @else
          <span class="disabled">&gt;</span>
        @endif

      </div>
    </div>

  
  
  
  
  
  
  </div>
</div>

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
let confirmCallback = null;

const alertBox   = document.getElementById('customAlert');
const alertTitle = document.getElementById('alertTitle');
const alertMsg   = document.getElementById('alertMessage');
const cancelBtn  = document.getElementById('cancelBtn');
const confirmBtn = document.getElementById('confirmBtn');

function showAlert(title, message, callback = null) {

    alertTitle.innerText = title;
    alertMsg.innerText   = message;

    confirmCallback = callback;

    confirmBtn.innerText = 'Hapus';
    confirmBtn.classList.remove('loading');

    alertBox.style.display = 'flex';
}

cancelBtn.onclick = function () {
    alertBox.style.display = 'none';
};

confirmBtn.onclick = function () {

    confirmBtn.classList.add('loading');
    confirmBtn.innerText = 'Menghapus...';

    setTimeout(() => {

        if (typeof confirmCallback === "function") {
            confirmCallback();
        }

    }, 600);
};
</script>


               
    
@endsection
