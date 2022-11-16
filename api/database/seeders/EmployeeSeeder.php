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
                'lastname' => 'Bakhtaoui',
                'firstname' => 'Ines',
                'mail' => 'inesbthk@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('password'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 2,
                'id_role' => 3,
                'lastname' => 'Ahamed Mze',
                'firstname' => 'Taslima',
                'mail' => 'taslimaahamedmze@gmail.com',
                'phone' => '0645784545',
                'password' => Hash::make('password'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 3,
                'id_role' => 4,
                'lastname' => 'Daugenne',
                'firstname' => 'Bastien',
                'mail' => 'daubas@gmail.com',
                'phone' => '0678956437',
                'password' => Hash::make('password'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_agency' => 4,
                'id_role' => 2,
                'lastname' => 'Noel',
                'firstname' => 'Mickael',
                'mail' => 'm.noel@gmail.com',
                'phone' => '0612356984',
                'password' => Hash::make('password'),
                'matricule' => rand(10000, 99999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')   
            ]

        ]);
    }
}
