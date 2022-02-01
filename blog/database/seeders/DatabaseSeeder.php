<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            heaterSeeder::class,
            kitchenSeeder::class,
            propertyPictureSeeder::class,
            propertySeeder::class,
            roomSeeder::class,
            roomTypeSeeder::class,
        ]);
    }
}
