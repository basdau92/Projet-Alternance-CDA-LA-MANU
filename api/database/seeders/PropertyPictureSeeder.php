<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PropertyPictureSeeder extends Seeder
{
    /**
     * Run the database seeds for the "property_picture" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_picture')->insert([
            [
                'title' => 'residence_paris15', 
                'path' => 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'résidence dans le 15e arr. de grand standing',
                'order' => 1,
                'id_property' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Cuisine de la résidence Launey', 
                'path' => 'https://images.pexels.com/photos/7511695/pexels-photo-7511695.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'Cuisine',
                'order' => 2,
                'id_property' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'maison_paris16', 
                'path' => 'https://images.pexels.com/photos/4947281/pexels-photo-4947281.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'maison pavillonaire et rénovée dans le 16e arr. avec toutes commodités.', 
                'order' => 1,
                'id_property' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Salon Berlioz', 
                'path' => 'https://images.pexels.com/photos/1571463/pexels-photo-1571463.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'Salon', 
                'order' => 2,
                'id_property' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Chambre Berlioz', 
                'path' => 'https://images.pexels.com/photos/6782338/pexels-photo-6782338.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'Chambre', 
                'order' => 3,
                'id_property' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'studio_f1_paris13', 
                'path' => 'https://images.pexels.com/photos/4054542/pexels-photo-4054542.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'petit studio F1 excellent pour petits budgets jeune actif ou étudiant dans le 13e arr.', 
                'order' => 1,
                'id_property' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Studio Priredux, chambre et salon', 
                'path' => 'https://images.pexels.com/photos/5824522/pexels-photo-5824522.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'Chambre et salon studio Priredux', 
                'order' => 2,
                'id_property' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Cuisine appartement résidence Hyrule', 
                'path' => 'https://images.pexels.com/photos/3288102/pexels-photo-3288102.png', 
                'alt' => 'Cuisine salle à manger', 
                'order' => 1,
                'id_property' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Salle de bain appartement résidence Hyrule', 
                'path' => 'https://images.pexels.com/photos/3288104/pexels-photo-3288104.png?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 
                'alt' => 'salle de bain', 
                'order' => 2,
                'id_property' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            
        ]);
    }
}
