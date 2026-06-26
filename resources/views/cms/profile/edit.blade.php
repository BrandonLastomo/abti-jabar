@extends('cms.layouts.master')

@section('title', 'Edit Team Profile')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Team Profile</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('club.update', $profile) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="field">
                <label>Category</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="indoor" {{ old('category', $profile->category) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                    <option value="beach" {{ old('category', $profile->category) == 'beach' ? 'selected' : '' }}>Beach</option>
                    <option value="wheelchair" {{ old('category', $profile->category) == 'wheelchair' ? 'selected' : '' }}>Wheelchair</option>
                </select>
            </div>

            <div class="field">
                <label>Subcategory</label>
                <input type="text" name="subcategory" value="{{ old('subcategory', $profile->subcategory) }}" required>
            </div>

            <div class="field">
                <div class="labelRow">
                    <label>Team Photo</label>
                    <span class="hint">jpg/png/webp (Maks 2MB)</span>
                </div>

                <div class="image-section">
                    <div class="image-preview">
                        <img id="preview-image" src="{{ $profile->picture ? asset('storage/'.$profile->picture) : 'https://via.placeholder.com/150x150' }}" width="150" alt="Preview">
                    </div>

                    <div class="image-info">
                        <label class="btn-upload">
                            Change Photo
                            <input type="file" name="picture" id="image-input" hidden>
                        </label>
                        @error('picture')
                            <small style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="actions" style="margin-top: 20px;">
                <button type="submit" class="btn primary">Update Team Profile</button>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger" style="margin-top:20px; color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('image-input').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection