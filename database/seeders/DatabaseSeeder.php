<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Region;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Shane',
            'email' => 'srosenthal82@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Howard',
            'email' => 'howard@rosenthaldevelopmentgroup.com',
        ]);


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

//        foreach ($regions as $region) {
//            Region::factory()->create([
//                'name' => $region,
//            ]);
//        }
//
//        foreach ($departments as $department) {
//            Department::factory()->create([
//                'name' => $department,
//            ]);
//        }
    }
}
