@extends('cms.layouts.master')
@section('title', 'Education')
@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Education Content</h2>
            </div>
            <div class="actions">
                <a href="{{ route('education.create') }}" class="btn primary">Add New Education</a>
            </div>
        </div>

        <div class="sectionBody">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($educations as $education)
                    <tr>
                        <td>{{ $education->category }}</td>
                        <td>{{ $education->title }}</td>
                        <td class="actions">
                            <a href="{{ route('education.edit', $education) }}" class="btn">Edit</a>
                            <form action="{{ route('education.destroy', $education) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $educations->links() }}
        </div>
    </div>
</div>
@endsection
