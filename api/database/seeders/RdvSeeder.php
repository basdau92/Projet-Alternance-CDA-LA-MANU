<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                'id_property' => 3,
                'id_client' => null,
                'id_label' => 2,
                'id_agency' => 1,
                'beginning' => '2022-03-08 11:00:00',
                'end' => '2022-03-08 11:30:00',
                'description' => 'rendez-vous avec M. Realestate à l\'extérieur du bâtiment pour visite location.',
                'lastname' => 'Realestate',
                'firstname' => 'Carlos',
                'mail' => 'carlrealestate@gmail.com',
                'phone' => '0632294633',
                'is_visit' => true,
                'address' => '24bis, boulevard St-Michel',
                'city' => 'Paris',
                'zipcode' => 75013,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 3,
                'id_property' => 1,
                'id_client' => 3,
                'id_label' => 3,
                'id_agency' => 1,
                'beginning' => '2022-06-13 14:00:00',
                'end' => '2022-06-13 14:45:00',
                'description' => 'rendez-vous avec M. Carignan devant la résidence.',
                'lastname' => 'Carignan',
                'firstname' => 'Jules',
                'mail' => 'jules_c@yahoo.fr',
                'phone' => '0605263478',
                'is_visit' => true,
                'address' => '12, impasse Bonaparte',
                'city' => 'Paris',
                'zipcode' => 75015,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 2,
                'id_property' => null,
                'id_client' => null,
                'id_label' => 4,
                'id_agency' => 1,
                'beginning' => '2022-06-23 9:00:00',
                'end' => '2022-06-23 9:45:00',
                'description' => 'rendez-vous avec M. Delathune à l\'agence du 1er pour informations gestion vente.',
                'lastname' => 'Delathune',
                'firstname' => 'Richard',
                'mail' => 'delathunerich@yahoo.fr',
                'phone' => '0605263478',
                'is_visit' => false,
                'address' => '6, rue du Poteau',
                'city' => 'Paris',
                'zipcode' => 75001,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 1,
                'id_property' => null,
                'id_client' => null,
                'id_label' => 4,
                'id_agency' => 1,
                'beginning' => '2022-07-01 11:00:00',
                'end' => '2022-07-01 12:00:00',
                'description' => 'rendez-vous avec Mme Jecrecheou à l\'agence du 1er pour informations location.',
                'lastname' => 'Jecrecheou',
                'firstname' => 'Victoria',
                'mail' => 'vickiejecrecheou@yahoo.fr',
                'phone' => '0703648291',
                'is_visit' => false,
                'address' => '6, rue du Poteau',
                'city' => 'Paris',
                'zipcode' => 75001,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 3,
                'id_property' => 2,
                'id_client' => null,
                'id_label' => 3,
                'id_agency' => 1,
                'beginning' => '2022-06-15 10:30:00',
                'end' => '2022-06-015 11:00:00',
                'description' => 'rendez-vous avec Mme Barrak.',
                'lastname' => 'Barrak',
                'firstname' => 'Christine',
                'mail' => 'barrakchrist@gmail.com',
                'phone' => '0632294633',
                'is_visit' => true,
                'address' => '3, rue Berlioz',
                'city' => 'Paris',
                'zipcode' => 75016,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
