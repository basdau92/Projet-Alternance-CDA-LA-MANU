<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                'idNumber'=>1234,
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
                'idNumber'=>1233,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
