@extends('cms.layouts.master')

@section('title', 'Edit Gallery')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Gallery</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('galleries.update', $gallery) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ $gallery->title }}" required>
            </div>

            <div class="field">
                <label>Season</label>
                <input type="text" name="season"
                       value="{{ $gallery->season }}" required>
            </div>

            <div class="field">
                <label>Current Photos</label><br>
                @foreach($gallery->photos as $photo)
                    <img src="{{ asset('storage/'.$photo->photo) }}"
                         width="100"
                         style="margin:5px;">
                @endforeach
            </div>

            <div class="field">
                <label>Add More Photos (Max 10 Total)</label>
                <input type="file"
                       name="photos[]"
                       multiple>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Gallery
                </button>
            </div>
        </form>
    </div>
</div>
@endsection