<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SpeakerSeeder::class);
        $this->call(AmenitiesSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(VenuesSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(TicketSeeder::class);
    }
}
