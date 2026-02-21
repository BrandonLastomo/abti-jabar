@extends('cms.layouts.master')

@section('title', 'Add Archive')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Archive</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('archive.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ old('title') }}" required>
            </div>

            <div class="field">
                <label>Category</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    @foreach([
                        'Mutation Regulation',
                        'Club Regulation',
                        'Event Regulation',
                        'Sanction Regulation',
                        'Statues & Regulation'
                    ] as $cat)
                        <option value="{{ $cat }}"
                            {{ old('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
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
                    Save Archive
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