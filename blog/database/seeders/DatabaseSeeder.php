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
        $this->call(energyAuditSeeder::class);
        $this->call(PropertyCategorySeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(hygieneSeeder::class);
        $this->call(outdoorSeeder::class);
        $this->call(annexeSeeder::class);
        $this->call(featuresListSeeder::class);
        $this->call(energyAuditSeeder::class);
        $this->call(parkingNumberSeeder::class);    
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
