@extends('cms.layouts.master')

@section('title', 'Clubs / Profile Tim')

@section('content')

<div>
  <div class="section">

    <div class="sectionHead">
      <div>
        <h2>Clubs / Profile Tim</h2>
      </div>

      <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
        <a href="{{ route('club.create') }}" class="btn primary">
            Add Club
        </a>
      </div>
    </div>

    @if (session('success'))
        <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
      <table class="custom-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Website</th>
            <th>Email</th>
            <th>Logo</th>
            <th>Picture</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

        @if($clubs->count() == 0)
          <tr>
            <td colspan="7" style="text-align:center;">
              Belum ada data club
            </td>
          </tr>
        @endif

        @foreach($clubs as $item)
          <tr>
            <td>{{ \Illuminate\Support\Str::limit($item->name, 25) }}</td>
            <td>{{ $item->club_status ? ucfirst($item->club_status) : '-' }}</td>
            <td>
              @if($item->website)
                <a href="{{ $item->website }}" target="_blank">
                  {{ \Illuminate\Support\Str::limit($item->website, 25) }}
                </a>
              @else
                -
              @endif
            </td>
            <td>{{ $item->email ?? '-' }}</td>

            <td>
              @if($item->logo)
                <span class="status uploaded">Uploaded</span>
              @else
                <span class="status not-uploaded">Not Uploaded</span>
              @endif
            </td>
            
            <td>
              @if($item->picture)
                <span class="status uploaded">Uploaded</span>
              @else
                <span class="status not-uploaded">Not Uploaded</span>
              @endif
            </td>

            <td class="actions" style="white-space: nowrap;">
                <a href="{{ route('club.edit', $item->id) }}" class="btn btn-edit">
                    Edit
                </a>

                <form id="deleteForm{{ $loop->index }}"
                      action="{{ route('club.destroy', $item->id) }}"
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
