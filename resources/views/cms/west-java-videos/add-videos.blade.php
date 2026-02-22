@extends('cms.layouts.master')

@section('title', 'Add West Java Video')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add West Java Video</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('west-java-videos.store') }}" method="POST">
            @csrf

            <div class="field">
                <label>Video Type *</label>
                <select name="type" required>
                    <option value="">Select Type</option>
                    <option value="shorts">Shorts</option>
                    <option value="podcast">Podcast</option>
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