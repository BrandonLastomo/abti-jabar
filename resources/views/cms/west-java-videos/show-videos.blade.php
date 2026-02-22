@extends('cms.layouts.master')

@section('title', 'West Java Video Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>West Java Video Detail</h2>
    </div>

    <div class="sectionBody">

        <div class="field">
            <label>Video Type</label>
            <input type="text"
                   value="{{ ucfirst($westJavaVideo->type) }}"
                   disabled>
        </div>

        <div class="field">
            <label>YouTube Link</label>
            <input type="text"
                   value="{{ $westJavaVideo->link }}"
                   disabled>
        </div>

        <div class="field">
            <label>Preview</label><br>

            <iframe width="420"
                    height="250"
                    src="{{ str_replace('watch?v=', 'embed/', $westJavaVideo->link) }}"
                    frameborder="0"
                    allowfullscreen>
            </iframe>
        </div>

    </div>
</div>
@endsection