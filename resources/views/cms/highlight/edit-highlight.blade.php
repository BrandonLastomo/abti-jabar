@extends('cms.layouts.master')

@section('title', 'Add Extended Highlight')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Extended Highlight</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('extended-highlights.update', $extended_highlight) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="field">
                <label>Title *</label>
                <input type="text" name="title" value="{{ $extended_highlight->title }}">
            </div>

            <div class="field">
                <label>Category *</label>
                    <select name="category">
                        <option value="">Select Category</option>
                        <option value="indoor"
                            {{ old('category', $event->category) == 'indoor' ? 'selected' : '' }}>
                            Indoor
                        </option>
                        <option value="beach"
                            {{ old('category', $event->category) == 'beach' ? 'selected' : '' }}>
                            Beach
                        </option>
                        <option value="wheelchair"
                            {{ old('category', $event->category) == 'wheelchair' ? 'selected' : '' }}>
                            Wheelchair
                        </option>
                    </select>
            </div>

            <div class="field">
                <label>YouTube Link *</label>
                <input type="url" name="link" required>
            </div>

            <div style="margin-top:20px;">
                <button class="btn btn-add">Save</button>
                <a href="{{ route('extended-highlights.index') }}" class="btn btn-view">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection