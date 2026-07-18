@extends('cms.layouts.master')

@section('title', 'Program Kerja')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Program Kerja</h2>
                <p></p>
            </div>
        </div>

        <div class="sectionBody">
                        @if (session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
<form action="{{ route('program-kerja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <div class="field">
                        <label>Title</label>
                        <input type="text" name="title"
                            value="{{ old('title') }}"
                            placeholder="Judul program kerja">
                    </div>

                    <div class="grid2">
                        <div class="field">
                            <label>Hero Meta</label>
                            <input type="text" name="hero_meta"
                                value="{{ old('hero_meta') }}"
                                placeholder="PROGRAM KERJA • 2026">
                        </div>

                        <div class="field">
                            <label>Category</label>
                            <select name="category">
                                <option value="">Select Category</option>
                                <option value="indoor" {{ old('category')=='indoor'?'selected':'' }}>Indoor</option>
                                <option value="beach" {{ old('category')=='beach'?'selected':'' }}>Beach</option>
                                <option value="wheelchair" {{ old('category')=='wheelchair'?'selected':'' }}>Wheelchair</option>
                            </select>
                        </div>

                        <div class="field">
                            <label>Year</label>
                            <input type="text" name="year"
                                value="{{ old('year') }}"
                                placeholder="2026">
                        </div>


                    </div>

                    <div class="field">
                        <label>Hero Desc</label>
                        <textarea name="desc" rows="4"
                            placeholder="Deskripsi detail untuk hero">{{ old('desc') }}</textarea>
                    </div>

                    <div class="field">
                        <label>Thumbnail Text</label>
                        <input type="text" name="thumbnail_text"
                            value="{{ old('thumbnail_text') }}"
                            placeholder="Teks overlay thumbnail (opsional)">
                    </div>

                    <div class="divider"></div>

                    <div class="field">
                        <div class="labelRow">
                            <label>Thumbnail Image</label>
                            <span class="hint">jpg/png/webp (Maks 2MB)</span>
                        </div>

                        <!-- <input type="hidden" name="image" value="0"> -->

                        <div class="image-section">
                            <div class="image-preview">
                                <img id="preview-image"
                                    src="https://placehold.co/150x150"
                                    width="150">
                            </div>

                            <div class="image-info">
                                <label class="btn-upload">
                                    Upload Image
                                    <input type="file"
                                        name="image"
                                        id="image-input"
                                        hidden>
                                </label>

                                <p class="hint">
                                    Max 2MB (JPG, PNG, WEBP)
                                </p>

                                @error('image')
                                <small style="color:red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="actions">
                    <button id="saveBtn" class="btn primary" type="submit">Save Changes</button>
                </div>
            </form>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
{{-- PREVIEW SCRIPT --}}
<script>
    document.getElementById('image-input').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection