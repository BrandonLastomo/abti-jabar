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

        @if (session('success'))
            <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('west-java-videos.update', $westJavaVideo) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Court Type (Optional)</label>
                <input type="text"
                       name="court_type"
                       value="{{ old('court_type', $westJavaVideo->court_type) }}">
            </div>

            <div class="field">
                <label>Video Type *</label>
                <select name="type" required>
                    <option value="shorts"
                        {{ old('type', $westJavaVideo->type) == 'shorts' ? 'selected' : '' }}>
                        Shorts
                    </option>
                    <option value="podcast"
                        {{ old('type', $westJavaVideo->type) == 'podcast' ? 'selected' : '' }}>
                        Podcast
                    </option>
                    <option value="highlights"
                        {{ old('type', $westJavaVideo->type) == 'highlights' ? 'selected' : '' }}>
                        Highlights
                    </option>
                </select>
            </div>

            <div class="field">
                <label>YouTube Link *</label>
                <input type="url"
                       name="link"
                       value="{{ old('link', $westJavaVideo->link) }}"
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