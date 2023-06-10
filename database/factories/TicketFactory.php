<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Ticket::STATUS_ACTIVE,
            'passport_id' => (string)Str::uuid(),
            'flight_id' => Flight::factory(),
        ];
    }
}
