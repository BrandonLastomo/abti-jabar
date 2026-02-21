@extends('cms.layouts.master')

@section('title', 'Club Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>{{ $club->name }}</h2>
        <p>Kota {{ $club->city }}</p>
    </div>

    <div class="sectionBody">

        @foreach([
            'director_club' => 'Direktur Klub',
            'administrator' => 'Administrator',
            'technical_director' => 'Direktur Teknik',
            'training_venue' => 'Venue Latihan',
            'email' => 'Email',
            'contact_person' => 'Contact Person',
            'website' => 'Website',
        ] as $field => $label)

        <div class="field">
            <label>{{ strtoupper($label) }}</label>
            <input type="text" value="{{ $club->$field }}" disabled>
        </div>

        @endforeach

    </div>
</div>
@endsection