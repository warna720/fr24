<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Ticket;
use Database\Seeders\FlightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FlightSeeder::class);
    }

    public function testStoreReturns201OnSuccess(): void
    {
        $response = $this->postJson(
            route('ticket_store'),
            [
                'flight_id' => Flight::inRandomOrder()->first()->uuid,
                'passport_id' => (string)Str::uuid(),
            ],
        );
        $response->assertStatus(201);
    }

    public function testStoreReturnsTicketOnSuccess(): void
    {
        $flight = Flight::inRandomOrder()->first();
        $passportId = Ticket::factory()->make()->passport_id;
        $response = $this->postJson(
            route('ticket_store'),
            [
                'flight_id' => $flight->uuid,
                'passport_id' => $passportId,
            ],
        );
        $response->assertJson([
            'status' => Ticket::STATUS_ACTIVE,
            'passport_id' => $passportId,
            'flight_id' => $flight->uuid
        ]);
    }

    public function testStoreSavesTicketInDb(): void
    {
        $this->assertEquals(0, Ticket::count());
        $flight = Flight::inRandomOrder()->first();
        $passportId = Ticket::factory()->make()->passport_id;
        $response = $this->postJson(
            route('ticket_store'),
            [
                'flight_id' => $flight->uuid,
                'passport_id' => $passportId,
            ],
        );

        $this->assertEquals(1, Ticket::count());
        $this->assertEquals($response->json('ticket_id'), Ticket::first()->uuid);
    }

    public function testUpdateStatusToCancelled(): void
    {
        $ticket = Ticket::factory()->create();
        $this->assertEquals(Ticket::STATUS_ACTIVE, $ticket->status);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => Ticket::STATUS_CANCELLED,
            ],
        );
        $response->assertStatus(200);

        $this->assertEquals($response->json('status'), Ticket::STATUS_CANCELLED);
        $this->assertEquals($ticket->refresh()->status, Ticket::STATUS_CANCELLED);
    }

    public function testUpdateStatusToForbiddenValueReturns422(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => Ticket::STATUS_CHECKED_IN,
            ],
        );
        $response->assertStatus(422);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => '1337',
            ],
        );
        $response->assertStatus(422);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => null,
            ],
        );
        $response->assertStatus(422);
    }

    public function testUpdateSeat(): void
    {
        $ticket = Ticket::factory()->create();
        $ticket->seat = 1;
        $ticket->save();
        $newSeat = Ticket::MAX_SEATING;

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'seat' => $newSeat,
            ],
        );
        $response->assertStatus(200);

        $this->assertEquals($response->json('seat'), $newSeat);
        $this->assertEquals($ticket->refresh()->seat, $newSeat);
    }

    public function testUpdateSeatToForbiddenValueReturns422(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => 33,
            ],
        );
        $response->assertStatus(422);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => 0,
            ],
        );
        $response->assertStatus(422);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => '21',
            ],
        );
        $response->assertStatus(422);

        $response = $this->putJson(
            route('ticket_update', ['ticket' => $ticket->uuid]),
            [
                'status' => null,
            ],
        );
        $response->assertStatus(422);
    }
}
