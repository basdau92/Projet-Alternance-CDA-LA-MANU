<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class propertyPictureSeeder extends Seeder
{
    /**
     * Run the database seeds for the "property_picture" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_picture')->insert([
            ['title' => 'residence_paris15', 
                'path' => 'https://images.assetsdelivery.com/compings_v2/elxeneize/elxeneize1908/elxeneize190800045.jpg', 
                'alt' => 'résidence dans le 15e arr. de grand standing',
                'order' => 3,
                'id_property' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'maison_paris16', 
                'path' => 'https://images.assetsdelivery.com/compings_v2/charlottebleijenberg/charlottebleijenberg1904/charlottebleijenberg190400157.jpg', 
                'alt' => 'maison pavillonaire et rénovée dans le 16e arr. avec toutes commodités.', 
                'order' => 2,
                'id_property' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'studio_f1_paris13', 
                'path' => 'https://images.assetsdelivery.com/compings_v2/alekskend/alekskend1908/alekskend190800179.jpg', 
                'alt' => 'petit studio F1 excellent pour petits budgets jeune actif ou étudiant dans le 13e arr.', 
                'order' => 3,
                'id_property' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
