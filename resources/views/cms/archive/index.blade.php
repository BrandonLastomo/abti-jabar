@extends('cms.layouts.master')

@section('title', 'Archive')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Archive</h2>
            </div>
            <div class="pill">{{ $archives->count() }} items</div>
        </div>

        @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="sectionBody">
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archives as $archive)
                        <tr>
                            <td>{{ $archive->title }}</td>
                            <td>{{ $archive->category }}</td>
                            <td>
                                @if($archive->file)
                                    <span class="status uploaded">Uploaded</span>
                                @else
                                    <span class="status not-uploaded">Not Uploaded</span>
                                @endif
                            </td>
                            <td class="actions">
                                <a href="{{ route('archive.show', $archive) }}"
                                   class="btn btn-view">View</a>

                                <a href="{{ route('archive.edit', $archive) }}"
                                   class="btn btn-edit">Edit</a>

                                <form action="{{ route('archive.destroy', $archive) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-bottom">
                {{ $archives->links() }}
            </div>
        </div>
    </div>
</div>

<div class="actions">
    <a href="{{ route('archive.create') }}" class="btn primary">
        Add Archive
    </a>
</div>

@endsection