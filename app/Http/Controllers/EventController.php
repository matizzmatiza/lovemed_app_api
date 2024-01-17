<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_start_date', 'asc')->get();
        return response()->json($events);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return response()->json(['message' => 'Event deleted successfully']);
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string',
            'event_place' => 'required|string',
            'event_start_date' => 'required|date',
            'event_start_time' => 'required|date',
            'event_desc' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $event = Event::create($validatedData);

        return response()->json($event, 201);
    }

    public function show($eventId)
    {
        $event = Event::find($eventId);
        return response()->json($event);
    }

    public function getJurorEvent($jurorId)
    {
        $juror = User::find($jurorId);
        $event = Event::find($juror->event_id);
        return response()->json($event);
    }
}