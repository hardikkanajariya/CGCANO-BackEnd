<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'event_id' => \App\Models\Events::factory(),
            'price' => $this->faker->randomFloat(2, 1, 999999.99),
            'quantity' => 100,
            'tickets_left' => 100,
            'is_sold_out' => false,
            'is_active' => true,
        ];
    }
}
