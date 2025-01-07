<?php

namespace Database\Seeders;

use App\Models\Meeting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DateConverter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meetings = Meeting::all();

        foreach ($meetings as $meeting) {
            $meeting->meeting_date = $meeting->start_time;
            $meeting->save();
        }
    }
}
