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
            'name' => $this->faker->name,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'image' => "avatar" . rand(1,9).".jpg",
            'website' => $this->faker->url,
            'is_active' => true,
        ];
    }
}
