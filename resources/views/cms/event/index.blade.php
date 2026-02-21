@extends('cms.layouts.master')

@section('title', 'Event')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Event</h2>
            </div>
            <div class="pill">{{ $events->count() }} items</div>
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
                                <th>Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Website</th>
                                <th>Logo</th>
                                <th>Cover</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->category }}</td>
                                <td>{{ $event->loc }}</td>
                                <td>
                                    @if($event->website)
                                        <a href="{{ $event->website }}" target="_blank">
                                            Visit
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($event->logo)
                                        <span class="status uploaded">Uploaded</span>
                                    @else
                                        <span class="status not-uploaded">Not Uploaded</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->cover)
                                        <span class="status uploaded">Uploaded</span>
                                    @else
                                        <span class="status not-uploaded">Not Uploaded</span>
                                    @endif
                                </td>

                                <td class="actions">
                                    <a href="{{ route('events.show', $event) }}"
                                       class="btn btn-view">View</a>

                                    <a href="{{ route('events.edit', $event) }}"
                                       class="btn btn-edit">Edit</a>

                                    <form id="deleteForm{{ $event->id }}"
                                          action="{{ route('events.destroy', $event) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="btn btn-delete"
                                            onclick="showAlert(
                                                'Hapus Event',
                                                'Event ini akan dihapus permanen.',
                                                function() {
                                                    document.getElementById('deleteForm{{ $event->id }}').submit();
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

                    @if ($events->onFirstPage())
                        <span class="disabled">&lt;</span>
                    @else
                        <a href="{{ $events->previousPageUrl() }}">&lt;</a>
                    @endif

                    @for ($i = 1; $i <= $events->lastPage(); $i++)
                        @if ($i == $events->currentPage())
                            <span class="active">{{ $i }}</span>
                        @else
                            <a href="{{ $events->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}">&gt;</a>
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
    <a href="{{ route('events.create') }}"
       class="btn primary">
        Add Event
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
