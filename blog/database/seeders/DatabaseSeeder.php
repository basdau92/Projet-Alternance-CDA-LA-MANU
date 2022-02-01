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
        $this->call(AgencySeeder::class);
        $this->call(ClientSeeder::class);
        $this->call([
            energyAuditSeeder::class,
            PropertyCategorySeeder::class,
            PropertyTypeSeeder::class,
            hygieneSeeder::class,
            outdoorSeeder::class,
            annexeSeeder::class,
            energyAuditSeeder::class,
            parkingNumberSeeder::class,
            heaterSeeder::class,
            kitchenSeeder::class,
            propertySeeder::class,
            propertyPictureSeeder::class,
            roomTypeSeeder::class,
            roomSeeder::class,
        ]);
        $this->call(featuresListSeeder::class);
    }
}
