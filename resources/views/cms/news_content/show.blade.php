@extends('cms.layouts.master')

@section('title', 'Detail News Content')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Detail News Content</h2>
            </div>
        </div>

        <div class="sectionBody">

            <div class="field">
                <label>Category</label>
                <div class="value">{{ $news->category }}</div>
            </div>

            <div class="field">
                <label>Title</label>
                <div class="value">{{ $news->title }}</div>
            </div>

            <div class="field">
                <label>Content</label>
                <div class="value">
                    {{ $news->content }}
                </div>
            </div>

            <div class="field">
                <label>CTA Text</label>
                <div class="value">{{ $news->cta_text }}</div>
            </div>

            <div class="field">
                <label>YouTube URL</label>
                <div class="value">
                    <a href="{{ $news->youtube_url }}" target="_blank">
                        {{ $news->youtube_url }}
                    </a>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('news-content.edit', $news) }}" class="btn warning">
                    Edit
                </a>

                <form action="{{ route('news-content.destroy', $news) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn danger"
                            onclick="return confirm('Yakin ingin menghapus?')">
                        Delete
                    </button>
                </form>

                <a href="{{ route('news-content.index') }}" class="btn">
                    Back
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
