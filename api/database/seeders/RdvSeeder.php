<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class RdvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rdv')->insert([
            [
                'id_employee' => 1,
                'id_property' => NULL,
                'id_client' => NULL,
                'id_label' => 2,
                'id_agency' => 1,
                'beginning' => '2022-03-08 11:00:00',
                'end' => '2022-03-08 11:30:00',
                'description' => 'rendez-vous à l\'extérieur du bâtiment',
                'lastname' => 'Bakhtaoui',
                'firstname' => 'Inès',
                'mail' => 'inesbkht@gmail.com',
                'phone' => '0632294633',
                'is_visit' => TRUE,
                'address' => '12, domaine du petit beauregard',
                'city' => 'La Celle St Cloud',
                'zipcode' => 78170,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [   
                'id_employee' => 3,
                'id_property' => 1,
                'id_client' => 2,
                'id_label' => 3,
                'id_agency' => 1,
                'beginning' => '2022-06-13 14:00:00',
                'end' => '2022-06-013 14:45:00',
                'description' => 'rendez-vous avec M. Lapiaule devant la résidence.',
                'lastname' => 'Lapiaule',
                'firstname' => 'Thomas',
                'mail' => 'thomas.lapiaule@gmail.com',
                'phone' => '0675643789',
                'is_visit' => TRUE,
                'address' => '12, impasse Bonaparte',
                'city' => 'Paris',
                'zipcode' => 75015,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
            
        ]);
    }
}
