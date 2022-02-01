<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class propertySeeder extends Seeder
{
    /**
     * Run the database seeds for the "property" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('property')->insert([
            ['name' => 'Résidence Launey ', 
                'price' => 630500, 
                'number' => 12, 
                'address' => 'Impasse Bonaparte', 
                'addition_address' => '', 
                'zipcode' => 75015, 
                'description' => 'Résidence 4 étages en fond de ruelle. Voisinage paisible, commerces de proximité, axes de circulation distants.', 
                'surface' => 1350, 
                'floor' => 4, 
                'is_furnished' => true, 
                'is_available' => true,
                'is_prospect' => false, 
                'id_property_type' => 1, 
                'id_kitchen' => 1, 
                'id_heater' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')], 
            ['name' => 'Maison rue Berlioz ', 
                'price' => 7500000, 
                'number' => 3, 
                'address' => 'rue Berlioz',
                'addition_address' => '',
                'zipcode' => 75016,
                'description' => 'Maison pavillonaire fraîchement rénovée avec jardin et terrasse, près du parc de Passy. Parfait pour une famille dans le plus verdoyant arrondissement de Paris.', 
                'surface' => 635,
                'floor' => 0, 
                'is_furnished' => true, 
                'is_available' => true,
                'is_prospect' => false, 
                'id_property_type' => 2, 
                'id_kitchen' => 2, 
                'id_heater' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Studio Priredux F1 ',
                'price' => 203875, 
                'number' => 24, 
                'address' => 'boulevard St-Michel',
                'addition_address' => 'bis',
                'zipcode' => 75013, 
                'description' => 'Modeste studio F1 non meublé à acquérir, idéal si vous envisagez une SCPI.', 
                'surface' => 23, 
                'floor' => 2, 
                'is_furnished' => false, 
                'is_available' => true,
                'is_prospect' => false, 
                'id_property_type' => 3, 
                'id_kitchen' => 3, 
                'id_heater' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
