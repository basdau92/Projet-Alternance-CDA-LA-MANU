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
            HeaterSeeder::class,
            KitchenSeeder::class,
            PropertyTypeSeeder::class,
            EnergyAuditSeeder::class,
            PropertySeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            PropertyPictureSeeder::class,
            AnnexeSeeder::class,
            HygieneSeeder::class,
            OutdoorSeeder::class,
            FeaturesListSeeder::class,
            ParkingNumberSeeder::class,
            LabelSeeder::class,
            RdvSeeder::class,
        ]);
        
    }
}
