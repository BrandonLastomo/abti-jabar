@extends('cms.layouts.master')

@section('title', 'Add West Java Video')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add West Java Video</h2>
    </div>

    <div class="sectionBody">
        @if (session('success'))
            <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('west-java-videos.store') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div style="color:red; margin-bottom:15px; margin-top:15px; background: #fff2f2; padding: 10px; border: 1px solid red; border-radius: 5px;">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label>Court Type (Optional)</label>
                <input type="text"
                       name="court_type"
                       value="{{ old('court_type') }}">
            </div>

            <div class="field">
                <label>Video Type *</label>
                <select name="type" required>
                    <option value="">Select Type</option>
                    <option value="shorts" {{ old('type') == 'shorts' ? 'selected' : '' }}>Shorts</option>
                    <option value="podcast" {{ old('type') == 'podcast' ? 'selected' : '' }}>Podcast</option>
                    <option value="highlights" {{ old('type') == 'highlights' ? 'selected' : '' }}>Highlights</option>
                </select>
            </div>

            <div class="field">
                <label>YouTube Link *</label>
                <input type="url"
                       name="link"
                       value="{{ old('link') }}"
                       required>
            </div>

            <div style="margin-top:20px;">
                <button class="btn btn-add">Save</button>
                <a href="{{ route('west-java-videos.index') }}"
                   class="btn btn-view">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection