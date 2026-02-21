@extends('cms.layouts.master')

@section('title', 'Archive Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Archive Detail</h2>
    </div>

    <div class="sectionBody">

        <div class="field">
            <label>Title</label>
            <input type="text" value="{{ $archive->title }}" disabled>
        </div>

        <div class="field">
            <label>Category</label>
            <input type="text" value="{{ $archive->category }}" disabled>
        </div>

        <div class="field">
            <label>File</label>
            @if($archive->file)
                <div style="display:flex; align-items:center; gap:10px;">
                    <a href="{{ asset('storage/'.$archive->file) }}"
                       target="_blank" class="btn-upload">
                       View File
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection