<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speakers>
 */
class SpeakersFactory extends Factory
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
            'name' => $this->faker->name,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480),
            'website' => $this->faker->url,
            'is_active' => true,
        ];
    }
}
