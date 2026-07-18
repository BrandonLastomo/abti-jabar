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



            <div class="actions">
                <a href="{{ route('news-content.edit', $news) }}" class="btn warning">
                    Edit
                </a>

                            @if (session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
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
