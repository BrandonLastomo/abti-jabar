@extends('cms.layouts.master')

@section('title', 'Edit Event')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Event</h2>
    </div>

    <div class="sectionBody">

        @if ($errors->any())
            <div style="color:red; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- BASIC INFO --}}
            <div class="field">
                <label>Event ID</label>
                <input type="text" name="event_id"
                       value="{{ old('event_id', $event->event_id) }}">
            </div>

            <div class="field">
                <label>Event Name *</label>
                <input type="text" name="name"
                       value="{{ old('name', $event->name) }}"
                       required>
            </div>

            <div class="grid2">
                <div class="field">
                    <label>Category</label>
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
                    <label>Location</label>
                    <input type="text" name="loc"
                           value="{{ old('loc', $event->loc) }}">
                </div>
            </div>

            {{-- PARTICIPATION DATA --}}
            <div class="grid2">
                <div class="field">
                    <label>Athletes</label>
                    <input type="number" name="athletes"
                           value="{{ old('athletes', $event->athletes) }}"
                           min="0">
                </div>

                <div class="field">
                    <label>Coaches</label>
                    <input type="number" name="coaches"
                           value="{{ old('coaches', $event->coaches) }}"
                           min="0">
                </div>

                <div class="field">
                    <label>Teams</label>
                    <input type="number" name="teams"
                           value="{{ old('teams', $event->teams) }}"
                           min="0">
                </div>

                <div class="field">
                    <label>Management</label>
                    <input type="number" name="management"
                           value="{{ old('management', $event->management) }}"
                           min="0">
                </div>

                <div class="field">
                    <label>Offline Audience</label>
                    <input type="number" name="audience_offline"
                           value="{{ old('audience_offline', $event->audience_offline) }}"
                           min="0">
                </div>
            </div>

            {{-- WEBSITE --}}
            <div class="field">
                <label>Website</label>
                <input type="url" name="website"
                       value="{{ old('website', $event->website) }}">
            </div>

            {{-- ADMIN --}}
            <div class="field">
                <label>Administrator</label>
                <input type="text" name="administrator"
                       value="{{ old('administrator', $event->administrator) }}">
            </div>

            {{-- LOGO --}}
            <div class="field">
                <label>Logo</label>
                <div class="image-section">
                    <div class="image-preview">
                        <img id="preview-logo"
                             src="{{ $event->logo ? asset('storage/'.$event->logo) : 'https://via.placeholder.com/150x150' }}"
                             width="150">
                    </div>
                    <div>
                        <label class="btn-upload">
                            Replace Logo
                            <input type="file"
                                   name="logo"
                                   id="logo-input"
                                   accept="image/*"
                                   hidden>
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
                             src="{{ $event->cover ? asset('storage/'.$event->cover) : 'https://via.placeholder.com/300x150' }}"
                             width="300">
                    </div>
                    <div>
                        <label class="btn-upload">
                            Replace Cover
                            <input type="file"
                                   name="cover"
                                   id="cover-input"
                                   accept="image/*"
                                   hidden>
                        </label>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Event
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('logo-input').addEventListener('change', function(){
    if(this.files[0]){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview-logo').src = e.target.result;
        reader.readAsDataURL(this.files[0]);
    }
});

document.getElementById('cover-input').addEventListener('change', function(){
    if(this.files[0]){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview-cover').src = e.target.result;
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

@endsection