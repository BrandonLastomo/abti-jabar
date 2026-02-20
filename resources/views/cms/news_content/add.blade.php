@extends('layouts.master')

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
                        <input type="text" name="category"
                            value="{{old('category')}}"
                            placeholder="Informasi Organisasi">
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
                        <label>CTA Text</label>
                        <input type="text" name="cta_text"
                            value="{{old('cta_text')}}"
                            placeholder="Lihat di youtube">
                    </div>

                    <div class="field">
                        <label>YouTube URL (shorts / video)</label>
                        <input type="text" name="youtube_url"
                            value="{{old('youtube_url')}}"
                            placeholder="https://www.youtube.com/shorts/...">
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
                Catatan: link youtube wajib disertakan lengkap <i>dengan https://...</i>.
            </div>

        </div>
    </div>
</div>

@endsection