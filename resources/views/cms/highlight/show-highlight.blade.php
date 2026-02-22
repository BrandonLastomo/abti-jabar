@extends('cms.layouts.master')

@section('title', 'Highlight Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Highlight Detail</h2>
    </div>

    <div class="sectionBody">

        <div class="field">
            <label>Title</label>
            <input type="text" value="{{ $extended_highlight->title }}" disabled>
        </div>

        <div class="field">
            <label>Category</label>
            <input type="text" value="{{ ucfirst($extended_highlight->category) }}" disabled>
        </div>

        <div class="field">
            <label>Link</label>
            <input type="text" value="{{ $extended_highlight->link }}" disabled>
        </div>

        <div class="field">
            <label>Preview</label><br>
            <iframe width="420"
                    height="250"
                    src="{{ str_replace('watch?v=', 'embed/', $extended_highlight->link) }}"
                    frameborder="0"
                    allowfullscreen>
            </iframe>
        </div>

    </div>
</div>
@endsection