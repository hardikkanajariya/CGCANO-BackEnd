<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsors>
 */
class SponsorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => null,
            'name' => $this->faker->company,
            'logo' => $this->faker->imageUrl(640, 480),
            'website' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'is_active' => true,
        ];
    }
}
