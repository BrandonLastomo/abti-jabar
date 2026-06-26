@extends('cms.layouts.master')

@section('title', 'Edit News Content')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Edit News Content</h2>
            </div>
        </div>

        <div class="sectionBody">

            <form action="{{ route('news-content.update', $news) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label>Category</label>
                    <input type="text"
                           name="category"
                           value="{{ old('category', $news->category) }}"
                           maxlength="100">
                    @error('category')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label>Title</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $news->title) }}"
                           maxlength="255">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label>Content</label>
                    <textarea name="content"
                              maxlength="1000">{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label>CTA Text</label>
                    <input type="text"
                           name="cta_text"
                           value="{{ old('cta_text', $news->cta_text) }}"
                           maxlength="255">
                    @error('cta_text')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label>YouTube URL</label>
                    <input type="url"
                           name="youtube_url"
                           value="{{ old('youtube_url', $news->youtube_url) }}"
                           maxlength="255">
                    @error('youtube_url')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label>Images (Carousel) - Max 4 images</label>
                    <input type="file" name="images[]" id="images-input" multiple accept="image/*">
                    <div id="images-preview" style="display:flex; gap:10px; margin-top:10px;">
                        @php $images = json_decode($news->images, true) ?? []; @endphp
                        @foreach($images as $img)
                            <img src="{{ asset('storage/'.$img) }}" style="width:100px; height:100px; object-fit:cover;">
                        @endforeach
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn primary">
                        Update News
                    </button>

                    <a href="{{ route('news-content.index') }}" class="btn">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('images-input').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('images-preview');
        previewContainer.innerHTML = '';
        if (this.files.length > 4) {
            alert('Maksimal 4 gambar yang diperbolehkan.');
            this.value = '';
            return;
        }
        for (let i = 0; i < this.files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(this.files[i]);
        }
    });
</script>
@endsection
