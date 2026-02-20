@extends('layouts.master')

@section('title', 'Anggota')

@section('content')

<div>
  <div class="section">

    <div class="sectionHead">
      <div>
        <h2>Anggota ABTI Kota/Kab</h2>
      </div>

      <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
        <a href="{{ route('anggota.create') }}" class="btn primary">
            Add Anggota
        </a>

      </div>
    </div>

    <div class="table-wrapper">
      <table class="custom-table">
        <thead>
          <tr>
            <th>Kota/Kab</th>
            <th>Ketua</th>
            <th>Sekretaris</th>
            <th>Email</th>
            <th>Link</th>
            <th>Logo</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

        @if($anggota->count() == 0)
          <tr>
            <td colspan="7" style="text-align:center;">
              Belum ada data anggota
            </td>
          </tr>
        @endif

        @foreach($anggota as $item)
          <tr>

           <td>{{ \Illuminate\Support\Str::limit($item->city, 25) }}</td>
<td>{{ \Illuminate\Support\Str::limit($item->lead_name, 20) }}</td>
<td>{{ \Illuminate\Support\Str::limit($item->sec_name, 20) }}</td>
            <td>{{ $item->email ?? '-' }}</td>

            <td>
              @if($item->link)
                <a href="{{ $item->link }}" target="_blank">
                  {{ \Illuminate\Support\Str::limit($item->link, 25) }}
                </a>
              @else
                -
              @endif
            </td>

            <td>
              @if($item->logo)
                <span class="status uploaded">Uploaded</span>
              @else
                <span class="status not-uploaded">Not Uploaded</span>
              @endif
            </td>

           <td class="actions" style="white-space: nowrap;">

    <a href="{{ route('anggota.show', $item->slug) }}" class="btn btn-view">
        View
    </a>

    <a href="{{ route('anggota.edit', $item->slug) }}" class="btn btn-edit">
        Edit
    </a>

    <form id="deleteForm{{ $loop->index }}"
         action="{{ route('anggota.destroy', $item->slug) }}"
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
                    document.getElementById('deleteForm{{ $loop->index }}').submit();
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
      {{ $anggota->links() }}
    </div>

  </div>
</div>


{{-- ALERT MODAL --}}
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
    alertBox.style.display = 'flex';
}

cancelBtn.onclick = function () {
    alertBox.style.display = 'none';
};

confirmBtn.onclick = function () {
    confirmBtn.innerText = 'Menghapus...';
    setTimeout(() => {
        if (typeof confirmCallback === "function") {
            confirmCallback();
        }
    }, 500);
};
</script>

@endsection
