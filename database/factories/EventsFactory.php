<?php

namespace Database\Factories;

use App\Models\Events;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Events>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(3),
            'category_id' => $this->faker->numberBetween(1, 5),
            'venue_id' => $this->faker->numberBetween(1, 5),
            'speaker_id' => $this->faker->numberBetween(1, 5),
            'start' => $this->faker->dateTimeBetween('now', '+1 days'),
            'end' => $this->faker->dateTimeBetween('now', '+1 days'),
            'duration' => $this->faker->numberBetween(1, 5),
            'thumbnail' => rand(1,14).".jpg",
            'gallery' => json_encode([
                rand(1,14).".jpg",
                rand(1,14).".jpg",
                rand(1,14).".jpg",
                rand(1,14).".jpg",
            ]),
            'tickets_available' => $this->faker->numberBetween(1, 255),
            'youtube' => $this->faker->url(),
            'website' => $this->faker->url(),
            'contact_phone' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->email(),
            'twitter' => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'facebook' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
        ];
    }
}
