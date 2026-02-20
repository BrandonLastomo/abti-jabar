@extends('layouts.master')

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
            <form action="{{ route('program-kerja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <div class="field">
                        <label>Title</label>
                        <input disabled type="text" name="title"
                            value="{{ $programKerja->title ?? old('title') }}"
                            placeholder="Judul program kerja">
                    </div>

                    <div class="grid2">
                        <div class="field">
                            <label>Hero Meta</label>
                            <input disabled type="text" name="hero_meta"
                                value="{{ $programKerja->hero_meta ?? old('hero_meta') }}"
                                placeholder="PROGRAM KERJA • 2026">
                        </div>

                        <div class="field">
                            <label>Category</label>
                            <input disabled type="text" name="category"
                                value="{{ $programKerja->category ?? old('category') }}"
                                placeholder="Pembinaan / Kompetisi / SDM">
                        </div>

                        <div class="field">
                            <label>Year</label>
                            <input disabled type="text" name="year"
                                value="{{ $programKerja->year ?? old('year') }}"
                                placeholder="2026">
                        </div>

                        <div class="field">
                            <label>Doc URL</label>
                            <input disabled type="text" name="doc"
                                value="{{ $programKerja->doc ?? old('doc') }}"
                                placeholder="https://...pdf">
                        </div>
                    </div>

                    <div class="field">
                        <label>Hero Desc</label>
                        <textarea name="desc" rows="4"
                            placeholder="Deskripsi detail untuk hero">{{ $programKerja->desc ?? old('desc') }}</textarea>
                    </div>

                    <div class="field">
                        <label>Thumbnail Text</label>
                        <input disabled type="text" name="thumbnail_text"
                            value="{{ $programKerja->thumbnail_text ?? old('thumbnail_text') }}"
                            placeholder="Teks overlay thumbnail (opsional)">
                    </div>

                    <div class="divider"></div>

                    <div class="field">
                        <div class="labelRow">
                            <label>Thumbnail Image</label>
                            <span class="hint">jpg/png/webp (Maks 300kb)</span>
                        </div>

                        <!-- <input disabled type="hidden" name="image" value="0"> -->

                        <div class="image-section">
                            <div class="image-preview">
                                <img id="preview-image"
                                    src="{{ asset('storage/'.$programKerja->image) }}"
                                    width="150">
                            </div>

                            <div class="image-info">
                                <label class="btn-upload">
                                    Upload Image
                                    <input disabled type="file"
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