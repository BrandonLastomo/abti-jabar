@extends('cms.layouts.master')

@section('title', 'Event Detail')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Event Detail</h2>
    </div>

    <div class="sectionBody">

        <div class="field">
            <label>Event ID</label>
            <input type="text" value="{{ $event->event_id }}" disabled>
        </div>

        <div class="field">
            <label>Event Name</label>
            <input type="text" value="{{ $event->name }}" disabled>
        </div>

        <div class="field">
            <label>Category</label>
            <input type="text" value="{{ $event->category }}" disabled>
        </div>

        <div class="field">
            <label>Location</label>
            <input type="text" value="{{ $event->loc }}" disabled>
        </div>

        <div class="field">
            <label>Athletes</label>
            <input type="text" value="{{ $event->athletes }}" disabled>
        </div>

        <div class="field">
            <label>Coaches</label>
            <input type="text" value="{{ $event->coaches }}" disabled>
        </div>

        <div class="field">
            <label>Teams</label>
            <input type="text" value="{{ $event->teams }}" disabled>
        </div>

        <div class="field">
            <label>Management</label>
            <input type="text" value="{{ $event->management }}" disabled>
        </div>

        <div class="field">
            <label>Offline Audience</label>
            <input type="text" value="{{ $event->audience_offline }}" disabled>
        </div>

        <div class="field">
            <label>Website</label>
            <input type="text" value="{{ $event->website }}" disabled>
        </div>

        <div class="field">
            <label>Administrator</label>
            <input type="text" value="{{ $event->administrator }}" disabled>
        </div>

        <div class="field">
            <label>Logo</label><br>
            @if($event->logo)
                <img src="{{ asset('storage/'.$event->logo) }}" width="120">
            @endif
        </div>

        <div class="field">
            <label>Cover</label><br>
            @if($event->cover)
                <img src="{{ asset('storage/'.$event->cover) }}" width="120">
            @endif
        </div>

    </div>
</div>
@endsection