@extends('cms.layouts.master')

@section('title', 'News Content')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>West Java Corner</h2>
                <p></p>
            </div>
        </div>

        <div class="sectionBody">


            <form class="" action="{{ route('news-content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <div class="field">
                        <label>Category</label>
                        <select name="category" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="News" {{ old('category') == 'News' ? 'selected' : '' }}>News</option>
                            <option value="Inspirational" {{ old('category') == 'Inspirational' ? 'selected' : '' }}>Inspirational</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Title</label>
                        <input type="text" name="title"
                            value="{{old('title')}}"
                            placeholder="Judul berita...">
                    </div>

                    <div class="field">
                        <label>Content</label>
                        <textarea name="content" placeholder="Deskripsi singkat...">{{old('content')}}</textarea>
                    </div>


                    <div class="field">
                        <label>Images (Carousel) - Max 4 images</label>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            @for($i = 0; $i < 4; $i++)
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="min-width:120px;">Image {{ $i + 1 }} {{ $i == 0 ? '(Main)' : '' }}</span>
                                <input type="file" name="image_{{ $i }}" accept="image/*">
                            </div>
                            @endfor
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


            <div class="note">
                Catatan: url wajib disertakan lengkap <i>dengan https://...</i>.
            </div>

        </div>
    </div>
</div>



@endsection