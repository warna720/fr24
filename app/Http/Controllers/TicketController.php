<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_id' => 'required|uuid|exists:flights,uuid',
            'passport_id' => 'required|uuid',
        ]);
        $validated['flight_id'] = Flight::where('uuid', $validated['flight_id'])->firstOrFail()->id;
        return new TicketResource(Ticket::create($validated));
    }

    public function update(Ticket $ticket, Request $request)
    {
        $validated = $request->validate([
            'status' => [
                'sometimes',
                'required',
                Rule::in([Ticket::STATUS_CANCELLED])
            ],
            'seat' => [
                'sometimes',
                'required',
                'integer',
                'between:1,' . Ticket::MAX_SEATING,
            ]
        ]);
        $ticket->fill($validated);
        $ticket->save();
        return new TicketResource($ticket);
    }
}
