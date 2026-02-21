@extends('cms.layouts.master')

@section('title', 'Add Club')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Club</h2>
    </div>

    <div class="sectionBody">
        @include('cms.club.form')
    </div>
</div>
@endsection