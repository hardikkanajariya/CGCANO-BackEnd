<?php

namespace Database\Seeders;

use App\Models\EventList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventList::factory()->count(50)->create();
    }
}
