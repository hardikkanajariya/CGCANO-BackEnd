<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TicketsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->randomFloat(2, 1, 250.99),
            'quantity' => 100,
            'tickets_left' => 100,
            'is_sold_out' => $this->faker->boolean(3),
            'is_active' => true,
        ];
    }
}
