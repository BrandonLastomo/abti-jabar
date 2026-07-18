@extends('cms.layouts.master')
@section('title', 'Education')
@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Education Content</h2>
            </div>
            <div class="pill">{{ $educations->count() }} items</div>
        </div>

        <div class="sectionBody">
            @if(session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="cardGrid">
                <div class="table-wrapper">
                    <table class="custom-table">
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
                                    <a href="{{ route('education.edit', $education) }}" class="btn btn-edit">Edit</a>
                                    <form action="{{ route('education.destroy', $education) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="table-bottom">
                <div class="pagination-custom">
                    {{ $educations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="actions">
    <a href="{{ route('education.create') }}" id="saveBtn" class="btn primary" type="submit">Add New Education</a>
</div>
@endsection
