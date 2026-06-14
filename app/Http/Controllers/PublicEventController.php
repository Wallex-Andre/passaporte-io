<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $eventsQuery = Event::with(['category', 'user']);

        if ($request->filled('category')) {
            $eventsQuery->where('category_id', $request->category);
        }

        $events = $eventsQuery
            ->where('date_time', '>=', now())
            ->orderBy('date_time')
            ->paginate(9)
            ->withQueryString();

        return view('home', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        $event->load(['category', 'user']);

        $occupied = $event->participants()->count();

        $available = $event->capacity - $occupied;

        $isFull = $occupied >= $event->capacity;

        $alreadyEnrolled = auth()->check()
            && auth()->user()->role === 'participante'
            && $event->participants()->where('user_id', auth()->id())->exists();

        return view('events.show', compact(
            'event',
            'occupied',
            'available',
            'isFull',
            'alreadyEnrolled'
        ));
    }
}
