<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class featuresListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features_list')->insert([
            [
                'id_hygiene' => 1,
                'id_outdoor' => 2,
                'id_property' => 1,
                'id_annexe' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_hygiene' => 2,
                'id_outdoor' => 2,
                'id_property' => 3,
                'id_annexe' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_hygiene' => 3,
                'id_outdoor' => 3,
                'id_property' => 2,
                'id_annexe' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
            

        ]);
    }
}
