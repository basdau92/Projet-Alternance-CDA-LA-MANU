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
                'lastname' => 'Bloup',
                'firstname' => 'Blop',
                'mail' => 'bloupblop@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 1,
                'lastname' => 'Lapiaule',
                'firstname' => 'Thomas',
                'mail' => 'thomas.lapiaule@gmail.com',
                'phone' => '0675643789',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 1,
                'lastname' => 'Delathune',
                'firstname' => 'Richard',
                'mail' => 'delathunerich@yahoo.fr',
                'phone' => '0605263478',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 2,
                'lastname' => 'Jecrecheou',
                'firstname' => 'Victoria',
                'mail' => 'vickiejecrecheou@yahoo.fr',
                'phone' => '0703648291',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
