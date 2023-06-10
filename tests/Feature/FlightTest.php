<?php

namespace Tests\Feature;

use Database\Seeders\FlightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FlightSeeder::class);
    }

    public function testIndexReturns200OnSuccess(): void
    {
        $response = $this->getJson(route('flight_index'));
        $response->assertStatus(200);
    }

    public function testIndexReturnsFlights(): void
    {
        $response = $this->getJson(route('flight_index'));
        $this->assertGreaterThan(0, $response->json());
    }

    public function testIndexIncludesFlightId(): void
    {
        $response = $this->getJson(route('flight_index'));
        $this->assertNotNull($response->json('0.id'));
        $this->assertIsString($response->json('0.id'));
    }

    public function testIndexIncludesDepartureDateTime(): void
    {
        $response = $this->getJson(route('flight_index'));
        $this->assertNotNull($response->json('0.departure_at'));
        $this->assertIsString($response->json('0.departure_at'));
    }

    public function testIndexIncludesSource(): void
    {
        $response = $this->getJson(route('flight_index'));
        $this->assertNotNull($response->json('0.source'));
        $this->assertIsString($response->json('0.source'));
    }

    public function testIndexIncludesDestination(): void
    {
        $response = $this->getJson(route('flight_index'));
        $this->assertNotNull($response->json('0.destination'));
        $this->assertIsString($response->json('0.destination'));
    }
}
