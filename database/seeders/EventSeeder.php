<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::factory()->create([
            'start_date' => Carbon::today()->format('Y-m-d'),
            'end_date' => Carbon::tomorrow()->format('Y-m-d'),
        ]);
        Event::factory()->create([
            'start_date' => Carbon::yesterday()->subDays(3)->format('Y-m-d'),
            'end_date' => Carbon::today()->subDays(3)->format('Y-m-d'),
        ]);
        Event::factory()->create([
            'start_date' => Carbon::yesterday()->subDays(10)->format('Y-m-d'),
            'end_date' => Carbon::today()->subDays(10)->format('Y-m-d'),
        ]);
        Event::factory()->create([
            'start_date' => Carbon::today()->addDays(10)->format('Y-m-d'),
            'end_date' => Carbon::tomorrow()->addDays(10)->format('Y-m-d'),
        ]);
        Event::factory()->create([
            'start_date' => Carbon::today()->subDays(3)->format('Y-m-d'),
            'end_date' => Carbon::tomorrow()->subDays(3)->format('Y-m-d'),
        ]);
    }
}
