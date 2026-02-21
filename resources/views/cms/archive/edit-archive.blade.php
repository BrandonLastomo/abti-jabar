@extends('cms.layouts.master')

@section('title', 'Edit Archive')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Archive</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('archive.update', $archive) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ $archive->title }}" required>
            </div>

            <div class="field">
                <label>Category</label>
                <select name="category" required>
                    @foreach([
                        'Mutation Regulation',
                        'Club Regulation',
                        'Event Regulation',
                        'Sanction Regulation',
                        'Statues & Regulation'
                    ] as $cat)
                        <option value="{{ $cat }}"
                            {{ $archive->category == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Current File</label>
                @if($archive->file)
                <div style="display:flex; align-items:center; gap:10px;">
                    <a href="{{ asset('storage/'.$archive->file) }}"
                       target="_blank" class="btn-upload">
                       View File
                    </a>
                </div>
                @endif
            </div>

            <div class="field">
                <label>Upload File (PDF)</label>
                <div style="display:flex; align-items:center; gap:10px;">
                    <label class="btn-upload">
                        Choose File
                        <input type="file" name="file" id="file-input" hidden required>
                    </label>

                    <span id="file-name" style="font-size:14px; color:#555;">
                        No file chosen
                    </span>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Archive
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const fileInput = document.getElementById("file-input");
    const fileNameDisplay = document.getElementById("file-name");

    fileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = "No file chosen";
        }
    });
</script>
@endsection