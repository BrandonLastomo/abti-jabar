@extends('cms.layouts.master')

@section('title', 'West Java Videos')

@section('content')
<div>
    <div class="section">
        <div class="sectionHead">
            <div>
                <h2>West Java Videos</h2>
            </div>
            <div class="pill">{{ $videos->count() }} items</div>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="sectionBody">
            <div class="cardGrid">
                <div class="table-wrapper">
                    <table class="custom-table" style="margin-bottom:15px;">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Link</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                            <tr>
                                <td>{{ ucfirst($video->type) }}</td>

                                <td>
                                    <a href="{{ $video->link }}" target="_blank">
                                        Visit
                                    </a>
                                </td>

                                <td>
                                    <span class="status uploaded">
                                        YouTube
                                    </span>
                                </td>

                                <td class="actions">
                                    <a href="{{ route('west-java-videos.show', $video) }}"
                                       class="btn btn-view">View</a>

                                    <a href="{{ route('west-java-videos.edit', $video) }}"
                                       class="btn btn-edit">Edit</a>

                                    <form id="deleteForm{{ $video->id }}"
                                          action="{{ route('west-java-videos.destroy', $video) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="btn btn-delete"
                                            onclick="showAlert(
                                                'Hapus Video',
                                                'Video ini akan dihapus permanen.',
                                                function() {
                                                    document.getElementById('deleteForm{{ $video->id }}').submit();
                                                }
                                            )">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="margin-bottom:15px;">
                        <a href="{{ route('west-java-videos.create') }}"
                        class="btn btn-add">
                            + Add Video
                        </a>
                    </div>
                </div>

                {{ $videos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection