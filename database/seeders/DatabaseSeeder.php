<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Region;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $regions = [
            'NE',
            'NW',
            'MW',
            'SE',
            'Texas',
            'San Diego',
            'LA',
            'Bay Area',
        ];

        $departments = [
            'D-18 Freezer',
            'D-19 Deli',
            'D-17 Cooler',
            'D-13 Shelf Stable',
        ];

        foreach ($regions as $region) {
            Region::factory()->create([
                'name' => $region,
            ]);
        }

        foreach ($departments as $department) {
            Department::factory()->create([
                'name' => $department,
            ]);
        }
    }
}
