@extends('cms.layouts.master')

@section('title', 'Team Profiles')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Team Profiles</h2>
        <div class="pill">{{ $profiles->total() }} items</div>
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
                        <th>Picture</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                        <td>
                            @if($profile->picture)
                                <img src="{{ asset('storage/'.$profile->picture) }}" width="60" alt="Team Photo">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ ucfirst($profile->category) }}</td>
                        <td>{{ $profile->subcategory }}</td>

                        <td class="actions">
                            <a href="{{ route('club.edit', $profile) }}" class="btn btn-edit">Edit</a>

                            <form action="{{ route('club.destroy', $profile) }}"
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

            {{ $profiles->links() }}
        </div>
    </div>
</div>

<div class="actions">
    <a href="{{ route('club.create') }}" class="btn primary">
        Add Team Profile
    </a>
</div>
@endsection