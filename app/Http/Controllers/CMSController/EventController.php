<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('cms.event.index', [
            'events' => $events,
            'page' => 'event'
        ]);
    }

    public function create()
    {
        return view('cms.event.add-event', [
            'page' => 'event'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'loc' => 'nullable|string|max:255',
            'athletes' => 'nullable|integer',
            'coaches' => 'nullable|integer',
            'teams' => 'nullable|integer',
            'management' => 'nullable|integer',
            'audience_offline' => 'nullable|integer',
            'website' => 'nullable|string|max:255',
            'administrator' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('event/logo', 'public');
        }

        // Upload cover
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('event/cover', 'public');
        }

        Event::create($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('cms.event.show-event', [
            'event' => $event,
            'page' => 'event'
        ]);
    }

    public function edit(Event $event)
    {
        return view('cms.event.edit-event', [
            'event' => $event,
            'page' => 'event'
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'loc' => 'nullable|string|max:255',
            'athletes' => 'nullable|integer',
            'coaches' => 'nullable|integer',
            'teams' => 'nullable|integer',
            'management' => 'nullable|integer',
            'audience_offline' => 'nullable|integer',
            'website' => 'nullable|string|max:255',
            'administrator' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Replace logo if new uploaded
        if ($request->hasFile('logo')) {
            if ($event->logo && Storage::disk('public')->exists($event->logo)) {
                Storage::disk('public')->delete($event->logo);
            }

            $validated['logo'] = $request->file('logo')->store('event/logo', 'public');
        }

        // Replace cover if new uploaded
        if ($request->hasFile('cover')) {
            if ($event->cover && Storage::disk('public')->exists($event->cover)) {
                Storage::disk('public')->delete($event->cover);
            }

            $validated['cover'] = $request->file('cover')->store('event/cover', 'public');
        }

        $event->update($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->logo && Storage::disk('public')->exists($event->logo)) {
            Storage::disk('public')->delete($event->logo);
        }

        if ($event->cover && Storage::disk('public')->exists($event->cover)) {
            Storage::disk('public')->delete($event->cover);
        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
