@extends('cms.layouts.master')

@section('title', 'Extended Highlights')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>Extended Highlights</h2>
            </div>
            <div class="pill">{{ $highlights->count() }} items</div>
        </div>

        @if(session('success'))
            <div style="color:green; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="sectionBody">
            <div style="margin-bottom:15px;">
                <a href="{{ route('highlight.create') }}" class="btn btn-add">
                    + Add Highlight
                </a>
            </div>

            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($highlights as $highlight)
                        <tr>
                            <td>{{ $highlight->title }}</td>
                            <td>{{ ucfirst($highlight->category) }}</td>
                            <td>
                                <a href="{{ $highlight->link }}" target="_blank">
                                    Visit
                                </a>
                            </td>
                            <td class="actions">
                                <a href="{{ route('highlight.show', $highlight) }}"
                                   class="btn btn-view">View</a>

                                <a href="{{ route('highlight.edit', $highlight) }}"
                                   class="btn btn-edit">Edit</a>

                                <form action="{{ route('highlight.destroy', $highlight) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-delete"
                                            onclick="return confirm('Hapus data?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $highlights->links() }}
        </div>
    </div>
</div>
@endsection