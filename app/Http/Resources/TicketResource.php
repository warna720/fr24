<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $flight = $this->flight;
        return [
            'ticket_id' => $this->uuid,
            'status' => $this->status,
            'seat' => $this->seat,
            'passport_id' => $this->passport_id,
            'flight_id' => $flight->uuid,
            'flight_departure_at' => $flight->departure_at,
            'flight_source' => $flight->source,
            'flight_destination' => $flight->destination,
        ];
    }
}
