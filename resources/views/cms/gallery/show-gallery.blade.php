@extends('cms.layouts.master')

@section('title', 'Gallery Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Gallery Detail</h2>
    </div>

    <div class="sectionBody">

        <div class="field">
            <label>Title</label>
            <input type="text"
                   value="{{ $gallery->title }}"
                   disabled>
        </div>

        <div class="field">
            <label>Season</label>
            <input type="text"
                   value="{{ $gallery->season }}"
                   disabled>
        </div>

        <div class="field">
            <label>Photos</label><br>
            @foreach($gallery->photos as $photo)
                <img src="{{ asset('storage/'.$photo->photo) }}"
                     width="150"
                     style="margin:8px;">
            @endforeach
        </div>

    </div>
</div>
@endsection