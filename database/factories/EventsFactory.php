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
        /* Fields
        * 'title' => 'required',
            'slug' => 'required|unique:events,slug,' . $id,
            'description' => 'required',
            'category' => 'required|exists:event_categories,id',
            'venue' => 'required|exists:venues,id',
            'speaker' => 'required|exists:speakers,id',
            'start' => 'required|date|after:today',
            'end' => 'required|after:start',
            'duration' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tickets_available' => 'required|numeric',
            'youtube' => 'nullable|url',
            'website' => 'nullable|url',
            'contact_phone' => 'nullable',
            'contact_email' => 'nullable|email',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
        */
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
            'thumbnail' => $this->faker->imageUrl(640, 480, 'events', true),
            'gallery' => json_encode([
                $this->faker->imageUrl(640, 480, 'events', true),
                $this->faker->imageUrl(640, 480, 'events', true),
                $this->faker->imageUrl(640, 480, 'events', true),
                $this->faker->imageUrl(640, 480, 'events', true),
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
