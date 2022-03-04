<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agency')->insert([
            
            [
                'name' => 'Agence du 1er arrondissement',
                'address' => '6 rue du Poteau',
                'zipcode' => '75001',
                'mail' => 'agencedu1er@gmail.com',
                'phone' => '0145789596',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Agence du 6ème arrondissement',
                'address' => '12 avenue baron Haussman',
                'zipcode' => '75006',
                'mail' => 'agencedu6eme@gmail.com',
                'phone' => '0145789293',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Agence du 7ème arrondissement',
                'address' => '3 rue du Emile Zola',
                'zipcode' => '75007',
                'mail' => 'agencedu7eme@gmail.com',
                'phone' => '01457898687',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Agence du 8ème arrondissement',
                'address' => '3 boulevard des Capucines',
                'zipcode' => '75008',
                'mail' => 'agencedu8eme@gmail.com',
                'phone' => '01457898564',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'Agence du 13ème arrondissement',
                'address' => '50 avenue Paul Vaillant-Couturier',
                'zipcode' => '75013',
                'mail' => 'agencedu13eme@gmail.com',
                'phone' => '01457751236',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
