@extends('cms.layouts.master')

@section('title', 'Clubs')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Clubs</h2>
        <div class="pill">{{ $clubs->total() }} items</div>
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
                        <th>Name</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Director</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clubs as $club)
                    <tr>
                        <td>{{ $club->name }}</td>
                        <td>{{ $club->city }}</td>
                        <td>{{ ucfirst($club->status) }}</td>
                        <td>{{ $club->director_club }}</td>

                        <td class="actions">
                            <a href="{{ route('club.show', $club) }}" class="btn btn-view">View</a>
                            <a href="{{ route('club.edit', $club) }}" class="btn btn-edit">Edit</a>

                            <form action="{{ route('club.destroy', $club) }}"
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

            {{ $clubs->links() }}
        </div>
    </div>
</div>

<div class="actions">
    <a href="{{ route('club.create') }}" class="btn primary">
        Add Club
    </a>
</div>
@endsection