@extends('cms.layouts.master')
@section('title', 'Edit Education')
@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div><h2>Edit Education</h2></div>
        </div>

        <div class="sectionBody">
                        @if (session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
<form action="{{ route('education.update', $education) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="field">
                    <label>Category (e.g., Coach, Referee, Multiplier)</label>
                    <input type="text" name="category" value="{{ old('category', $education->category) }}" required>
                </div>

                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title', $education->title) }}" required>
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea name="description">{{ old('description', $education->description) }}</textarea>
                </div>

                <div class="field">
                    <label>Featured Image</label>
                    @if($education->image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/'.$education->image) }}" width="150" alt="Current Image">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*,.svg">
                </div>

                <hr style="margin: 20px 0;">
                <h3>Rincian Tanggung Jawab</h3>
                <div id="responsibilities-container">
                    @php $responsibilities = old('responsibilities', $education->responsibilities ?? []); @endphp
                    @foreach($responsibilities as $index => $resp)
                    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <div class="field">
                            <label>Title</label>
                            <input type="text" name="responsibilities[{{ $index }}][title]" value="{{ $resp['title'] }}" required>
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <textarea name="responsibilities[{{ $index }}][description]" required>{{ $resp['description'] }}</textarea>
                        </div>
                        <button type="button" class="btn danger remove-btn">Remove</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn" id="add-responsibility" style="margin-top: 10px;">+ Add Responsibility</button>

                <div class="actions" style="margin-top: 20px;">
                    <button type="submit" class="btn primary">Update Changes</button>
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
    let index = {{ count($responsibilities ?? []) }};

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

