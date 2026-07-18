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
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="field">
                    <label>Category</label>
                    <select name="category" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="News" {{ old('category', $news->category) == 'News' ? 'selected' : '' }}>News</option>
                        <option value="Inspirational" {{ old('category', $news->category) == 'Inspirational' ? 'selected' : '' }}>Inspirational</option>
                    </select>
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
                        <label>Images (Carousel) - Max 4 images</label>
                        <div style="display:flex; flex-direction:column; gap:15px;">
                            @php $images = json_decode($news->images, true) ?? []; @endphp
                            @for($i = 0; $i < 4; $i++)
                            <div style="border:1px solid #eee; padding:10px; border-radius:5px;">
                                <div style="font-weight:bold; margin-bottom:10px;">Image {{ $i + 1 }} {{ $i == 0 ? '(Main)' : '' }}</div>
                                @if(isset($images[$i]))
                                    <div style="margin-bottom:10px; display:flex; align-items:center; gap:15px;">
                                        <img src="{{ asset('storage/'.$images[$i]) }}" style="width:100px; height:100px; object-fit:cover; border-radius:5px; border:1px solid #ccc;">
                                        <label style="color:red; font-weight:bold;">
                                            <input type="checkbox" name="delete_image_{{ $i }}" value="1"> Hapus gambar ini
                                        </label>
                                    </div>
                                    <div style="margin-bottom:5px; font-size:0.9em; color:#666;">Ganti gambar:</div>
                                @endif
                                <input type="file" name="image_{{ $i }}" accept="image/*">
                            </div>
                            @endfor
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


@endsection
