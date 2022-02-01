<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'name' => 'Agence du 18e',
            'address' => '6 rue du Poteau',
            'zipcode' => '75018',
            'mail' => 'agencedu18@gmail.com',
            'phone' => '0145789596',
        ]);
    }
}
