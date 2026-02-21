@extends('cms.layouts.master')

@section('title', 'Gallery')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Gallery</h2>
            </div>
            <div class="pill">{{ $galleries->count() }} items</div>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="sectionBody">
            <div class="cardGrid">
                <div class="table-wrapper">
                    <table class="custom-table">
                        <thead>
    <tr>
        <th>Title</th>
        <th>Season</th>
        <th>Total Photos</th>
        <th>Preview</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@foreach($galleries as $gallery)
<tr>
    <td>{{ $gallery->title }}</td>
    <td>{{ $gallery->season }}</td>

    <td>
        {{ $gallery->photos->count() }} Photos
    </td>

    <td>
        @if($gallery->photos->first())
            <img src="{{ asset('storage/'.$gallery->photos->first()->photo) }}"
                 width="80">
        @else
            <span class="status not-uploaded">No Photo</span>
        @endif
    </td>

    <td class="actions">
        <a href="{{ route('gallery.show', $gallery) }}"
           class="btn btn-view">View</a>

        <a href="{{ route('gallery.edit', $gallery) }}"
           class="btn btn-edit">Edit</a>

        <form id="deleteForm{{ $gallery->id }}"
              action="{{ route('gallery.destroy', $gallery) }}"
              method="POST"
              style="display:inline;">
            @csrf
            @method('DELETE')

            <button type="button"
                class="btn btn-delete"
                onclick="showAlert(
                    'Hapus Gallery',
                    'Gallery ini akan dihapus permanen.',
                    function() {
                        document.getElementById('deleteForm{{ $gallery->id }}').submit();
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
            </div>

            {{-- Pagination --}}
            <div class="table-bottom">
                <div class="pagination-custom">

                    @if ($galleries->onFirstPage())
                        <span class="disabled">&lt;</span>
                    @else
                        <a href="{{ $galleries->previousPageUrl() }}">&lt;</a>
                    @endif

                    @for ($i = 1; $i <= $galleries->lastPage(); $i++)
                        @if ($i == $galleries->currentPage())
                            <span class="active">{{ $i }}</span>
                        @else
                            <a href="{{ $galleries->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($galleries->hasMorePages())
                        <a href="{{ $galleries->nextPageUrl() }}">&gt;</a>
                    @else
                        <span class="disabled">&gt;</span>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Button --}}
<div class="actions">
    <a href="{{ route('gallery.create') }}"
       class="btn primary">
        Add gallery
    </a>
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
  let currentRow = null;

  const alertBox   = document.getElementById('customAlert');
  const alertTitle = document.getElementById('alertTitle');
  const alertMsg   = document.getElementById('alertMessage');
  const cancelBtn  = document.getElementById('cancelBtn');
  const confirmBtn = document.getElementById('confirmBtn');

  function showAlert(title, message, callback = null, rowElement = null) {

    alertTitle.innerText = title;
    alertMsg.innerText   = message;

    confirmCallback = callback;
    currentRow      = rowElement;

    confirmBtn.style.display = 'inline-block';
    cancelBtn.style.display  = 'inline-block';
    confirmBtn.innerText     = 'Hapus';
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

            // animasi sukses
            alertTitle.innerText = 'Berhasil';
            alertMsg.innerText = 'Data berhasil dihapus';

            // fade row kalau cuma frontend
            if (currentRow) {
                currentRow.classList.add('fade-out');
            }

            // JALANKAN CALLBACK (submit form Laravel)
            if (typeof confirmCallback === "function") {
                setTimeout(() => {
                    confirmCallback();
                }, 500);
            }

            // reset tampilan (kalau tidak redirect)
            setTimeout(() => {
                alertBox.style.display = 'none';
                confirmBtn.classList.remove('loading');
                confirmBtn.innerText = 'Hapus';
                confirmBtn.style.display = 'inline-block';
                cancelBtn.style.display = 'inline-block';
            }, 1500);

        }, 800);
    };
</script>

@endsection
