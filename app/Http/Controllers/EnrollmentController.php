<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    public function store(Event $event)
    {
        if ($event->participants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Você já está inscrito neste evento.');
        }

        if ($event->participants()->count() >= $event->capacity) {
            return back()->with('error', 'Vagas esgotadas para este evento.');
        }

        $ticketCode = Str::upper(Str::random(10));

        $event->participants()->attach(Auth::id(), [
            'ticket_code' => $ticketCode,
            'status' => 'Confirmada',
        ]);

        return back()->with('success', 'Inscrição realizada com sucesso! Código do ingresso: '.$ticketCode);
    }

    public function index()
    {
        $events = Auth::user()
            ->inscriptions()
            ->with(['category', 'user'])
            ->orderByPivot('created_at', 'desc')
            ->paginate(10);

        return view('enrollments.index', compact('events'));
    }

    public function destroy(Event $event)
    {
        if (! $event->participants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Você não está inscrito neste evento.');
        }

        $event->participants()->detach(Auth::id());

        return back()->with('success', 'Inscrição cancelada com sucesso!');
    }
}
