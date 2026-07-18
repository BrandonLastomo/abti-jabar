@extends('cms.layouts.master')
@section('title', 'Add Education')
@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div><h2>Add New Education</h2></div>
        </div>

        <div class="sectionBody">
                        @if (session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
<form action="{{ route('education.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label>Category (e.g., Coach, Referee, Multiplier)</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Multiplier" {{ old('category') == 'Multiplier' ? 'selected' : '' }}>Multiplier</option>
                        <option value="Coach" {{ old('category') == 'Coach' ? 'selected' : '' }}>Coach</option>
                        <option value="Goalkeeper Coach" {{ old('category') == 'Goalkeeper Coach' ? 'selected' : '' }}>Goalkeeper Coach</option>
                        <option value="Referee" {{ old('category') == 'Referee' ? 'selected' : '' }}>Referee</option>
                        <option value="Delegates" {{ old('category') == 'Delegates' ? 'selected' : '' }}>Delegates</option>
                        <option value="Training Management" {{ old('category') == 'Training Management' ? 'selected' : '' }}>Training Management</option>
                        <option value="Club Management" {{ old('category') == 'Club Management' ? 'selected' : '' }}>Club Management</option>
                    </select>
                </div>

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea name="description">{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label>Featured Image</label>
                    <input type="file" name="image" accept="image/*,.svg">
                </div>

                <hr style="margin: 20px 0;">
                <h3>Rincian Tanggung Jawab</h3>
                <div id="responsibilities-container">
                    <!-- Dynamic fields will be added here -->
                </div>
                <button type="button" class="btn" id="add-responsibility" style="margin-top: 10px;">+ Add Responsibility</button>

                <div class="actions" style="margin-top: 20px;">
                    <button type="submit" class="btn primary">Save Changes</button>
                    <a href="{{ route('education.index') }}" class="btn">Cancel</a>
                </div>
            </form>
            
            @if ($errors->any())
            <div class="alert alert-danger" style="margin-top: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('responsibilities-container');
    const addButton = document.getElementById('add-responsibility');
    let index = 0;

    addButton.addEventListener('click', function() {
        const div = document.createElement('div');
        div.style.border = '1px solid #ccc';
        div.style.padding = '10px';
        div.style.marginBottom = '10px';
        div.innerHTML = `
            <div class="field">
                <label>Title</label>
                <input type="text" name="responsibilities[${index}][title]" required>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea name="responsibilities[${index}][description]" required></textarea>
            </div>
            <button type="button" class="btn danger remove-btn">Remove</button>
        `;
        container.appendChild(div);
        index++;
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-btn')) {
            e.target.parentElement.remove();
        }
    });
});
</script>
@endsection

