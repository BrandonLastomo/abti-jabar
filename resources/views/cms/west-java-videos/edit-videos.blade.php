@extends('cms.layouts.master')

@section('title', 'Edit West Java Video')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit West Java Video</h2>
    </div>

    <div class="sectionBody">

        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('west-java-videos.update', $westJavaVideo) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Video Type *</label>
                <select name="type" required>
                    <option value="shorts"
                        {{ $westJavaVideo->type == 'shorts' ? 'selected' : '' }}>
                        Shorts
                    </option>
                    <option value="podcast"
                        {{ $westJavaVideo->type == 'podcast' ? 'selected' : '' }}>
                        Podcast
                    </option>
                </select>
            </div>

            <div class="field">
                <label>YouTube Link *</label>
                <input type="url"
                       name="link"
                       value="{{ $westJavaVideo->link }}"
                       required>
            </div>

            <div style="margin-top:20px;">
                <button class="btn btn-edit">Update</button>
                <a href="{{ route('west-java-videos.index') }}"
                   class="btn btn-view">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection