<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds for the "property" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('property')->insert([
            [
                'id_property_type' => 1,
                'id_property_category' => 1,
                'id_kitchen' => 1,
                'id_heater' => 1,
                'id_energy_audit' => 1,
                'name' => 'Résidence Launey ',
                'price' => 630500,
                'address' => '12 Impasse Bonaparte',
                'addition_address' => '',
                'zipcode' => 75015,
                'city' => 'Paris',
                'surface' => 1350,
                'description' => 'Résidence 4 étages en fond de ruelle. Voisinage paisible, commerces de proximité, axes de circulation distants.',
                'is_furnished' => true,
                'is_available' => true,
                'is_prospect' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_property_type' => 2,
                'id_property_category' => 2,
                'id_kitchen' => 2,
                'id_heater' => 2,
                'id_energy_audit' => 2,
                'name' => 'Maison rue Berlioz ',
                'price' => 7500000,
                'address' => '3 rue Berlioz',
                'addition_address' => '',
                'zipcode' => 75016,
                'city' => 'Paris',
                'surface' => 635,
                'description' => 'Maison pavillonaire fraîchement rénovée avec jardin et terrasse, près du parc de Passy. Parfait pour une famille dans le plus verdoyant arrondissement de Paris.',
                'is_furnished' => true,
                'is_available' => true,
                'is_prospect' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_property_type' => 3,
                'id_property_category' => 4,
                'id_kitchen' => 3,
                'id_heater' => 3,
                'id_energy_audit' => 3,
                'name' => '24 Studio Priredux F1',
                'price' => 203875,
                'address' => '24 boulevard St-Michel',
                'addition_address' => 'bis',
                'zipcode' => 75013,
                'city' => 'Paris',
                'surface' => 23,
                'description' => 'Modeste studio F1 non meublé à acquérir, idéal si vous envisagez une SCPI.',
                'is_furnished' => false,
                'is_available' => true,
                'is_prospect' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
