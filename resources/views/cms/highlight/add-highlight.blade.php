@extends('cms.layouts.master')

@section('title', 'Add Extended Highlight')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Extended Highlight</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('extended-highlights.store') }}" method="POST">
            @csrf

            <div class="field">
                <label>Title *</label>
                <input type="text" name="title" required>
            </div>

            <div class="field">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="indoor">Indoor</option>
                    <option value="beach">Beach</option>
                    <option value="wheelchair">Wheelchair</option>
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