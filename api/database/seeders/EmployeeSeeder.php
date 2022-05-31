<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee')->insert([
            [
                'id_agency' => 1,
                'id_role' => 1,
                'lastname' => 'Bloup',
                'firstname' => 'Blop',
                'mail' => 'bloupblop@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('password'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 1,
                'id_role' => 1,
                'lastname' => 'Ahamed Mze',
                'firstname' => 'Taslima',
                'mail' => 'taslimaahamedmze@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('taslima'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
