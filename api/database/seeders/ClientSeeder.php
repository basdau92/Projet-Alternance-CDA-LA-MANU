<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client')->insert([
            [
                'id_agency' => 1,
                'lastname' => 'Conway',
                'firstname' => 'Carol',
                'mail' => 'carolc@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 1,
                'lastname' => 'Artois',
                'firstname' => 'Noémie',
                'mail' => 'noemieartois@gmail.com',
                'phone' => '0675643789',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 1,
                'lastname' => 'Carignan',
                'firstname' => 'Jules',
                'mail' => 'jules_c@yahoo.fr',
                'phone' => '0605263478',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 2,
                'lastname' => 'Louineaux',
                'firstname' => 'Henri',
                'mail' => 'hlouineaux@yahoo.fr',
                'phone' => '0703648291',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
