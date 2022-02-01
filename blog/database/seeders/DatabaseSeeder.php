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
            AgencySeeder::class,
            ClientSeeder::class,
            PropertyCategorySeeder::class,
            PropertyPictureSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            PropertySeeder::class,
            EnergyAuditSeeder::class,
            PropertyTypeSeeder::class,
            AnnexeSeeder::class,
            HeaterSeeder::class,
            HygieneSeeder::class,
            KitchenSeeder::class,
            OutdoorSeeder::class,
            FeaturesListSeeder::class,
            ParkingNumberSeeder::class,
        ]);
        
    }
}
