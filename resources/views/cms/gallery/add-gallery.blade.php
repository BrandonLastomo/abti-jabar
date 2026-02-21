@extends('cms.layouts.master')

@section('title', 'Add Gallery')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Gallery</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('gallery.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ old('title') }}" required>
            </div>

            <div class="field">
                <label>Season</label>
                <input type="text" name="season"
                       value="{{ old('season') }}"
                       placeholder="Example: 2024/2025"
                       required>
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
                               hidden
                               required>
                    </label>
                    <p id="photo-preview"></p>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Save Gallery
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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