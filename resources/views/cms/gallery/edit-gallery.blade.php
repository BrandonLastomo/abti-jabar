@extends('cms.layouts.master')

@section('title', 'Edit Gallery')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Gallery</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('gallery.update', $gallery) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ $gallery->title }}">
            </div>

            <div class="field">
                <label>Season</label>
                <input type="text" name="season"
                       value="{{ $gallery->season }}">
            </div>

            <div class="field">
                <label>Upload Photos (Max 10)</label>
                <div>
                    <label class="btn-upload">
                        Choose Photos
                        <input type="file"
                               name="photos[]"
                               id="photo-input"
                               multiple
                               hidden>
                    </label>
                    <p id="photo-preview"></p>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Gallery
                </button>
            </div>
        </form>
    </div>
</div>
<div class="field" style="margin-top:30px;">
    <label>Current Photos</label>

    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        @foreach($gallery->photos as $photo)
            <div style="position:relative; width:140px;">

                <img src="{{ asset('storage/'.$photo->photo) }}"
                     style="width:100%; border-radius:8px;">

                <form id="deletePhotoForm{{ $photo->id }}"
                      action="{{ route('gallery.photo.delete', $photo) }}"
                      method="POST"
                      style="position:absolute; top:5px; right:5px;">
                    @csrf
                    @method('DELETE')

                    <button type="button"
                        class="btn btn-delete"
                        style="padding:4px 8px; font-size:12px;"
                        onclick="showAlert(
                            'Hapus Foto',
                            'Foto ini akan dihapus permanen.',
                            function() {
                                document.getElementById('deletePhotoForm{{ $photo->id }}').submit();
                            }
                        )">
                        ✕
                    </button>
                </form>

            </div>
        @endforeach
    </div>
</div>

<div id="customAlert" class="alert-overlay" style="display:none;">
  <div class="alert-box">
    <h3 id="alertTitle">Konfirmasi</h3>
    <p id="alertMessage">Yakin mau hapus?</p>

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

const input = document.getElementById("photo-input");
const preview = document.getElementById("photo-preview");

input.addEventListener("change", function(){
    preview.innerHTML = "";

    if(this.files.length > 10){
        alert("Maximum 10 photos allowed.");
        this.value = "";
        return;
    }

    Array.from(this.files).forEach(file => {
        const p = document.createElement("p");
        p.textContent = file.name;
        preview.appendChild(p);
    });
});
</script>
@endsection