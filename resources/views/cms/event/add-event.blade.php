@extends('cms.layouts.master')

@section('title', 'Add Event')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Event</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label>Event ID</label>
                <input type="text" name="event_id" value="{{ old('event_id') }}">
            </div>

            <div class="field">
                <label>Event Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="grid2">
                <div class="field">
                    <label>Category</label>
                    <select name="category">
                        <option value="">Select Category</option>
                        <option value="indoor" {{ old('category')=='indoor'?'selected':'' }}>Indoor</option>
                        <option value="beach" {{ old('category')=='beach'?'selected':'' }}>Beach</option>
                        <option value="wheelchair" {{ old('category')=='wheelchair'?'selected':'' }}>Wheelchair</option>
                    </select>
                </div>

                <div class="field">
                    <label>Location</label>
                    <input type="text" name="loc" value="{{ old('loc') }}">
                </div>
            </div>

            <div class="grid2">
                <div class="field">
                    <label>Athletes</label>
                    <input type="number" name="athletes" value="{{ old('athletes') }}">
                </div>

                <div class="field">
                    <label>Coaches</label>
                    <input type="number" name="coaches" value="{{ old('coaches') }}">
                </div>

                <div class="field">
                    <label>Teams</label>
                    <input type="number" name="teams" value="{{ old('teams') }}">
                </div>

                <div class="field">
                    <label>Management</label>
                    <input type="number" name="management" value="{{ old('management') }}">
                </div>

                <div class="field">
                    <label>Offline Audience</label>
                    <input type="number" name="audience_offline" value="{{ old('audience_offline') }}">
                </div>
            </div>

            <div class="field">
                <label>Website</label>
                <input type="text" name="website" value="{{ old('website') }}">
            </div>

            <div class="field">
                <label>Administrator</label>
                <input type="text" name="administrator" value="{{ old('administrator') }}">
            </div>

            
            {{-- LOGO --}}
            <div class="field">
                <label>Logo</label>
                <div class="image-section">
                    <div class="image-preview">
                        <img id="preview-logo"
                            src="https://via.placeholder.com/150x150"
                            width="150">
                    </div>
                    <div>
                        <label class="btn-upload">
                            Upload Logo
                            <input type="file" name="logo" id="logo-input" hidden>
                        </label>
                    </div>
                </div>
            </div>

            {{-- COVER --}}
            <div class="field">
                <label>Cover</label>
                <div class="image-section">
                    <div class="image-preview">
                        <img id="preview-cover"
                            src="https://via.placeholder.com/150x150"
                            width="150">
                    </div>
                    <div>
                        <label class="btn-upload">
                            Upload Cover
                            <input type="file" name="cover" id="cover-input" hidden>
                        </label>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">Save Event</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('logo-input').addEventListener('change', function(e){
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview-logo').src = e.target.result;
    reader.readAsDataURL(this.files[0]);
});

document.getElementById('cover-input').addEventListener('change', function(e){
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview-cover').src = e.target.result;
    reader.readAsDataURL(this.files[0]);
});
</script>
@endsection