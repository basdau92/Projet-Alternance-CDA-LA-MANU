<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class roomSeeder extends Seeder
{
    /**
     * Run the database seeds for the "room" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('room')->insert([
            ['id_property' => 1, 
                'id_room_type' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id_property' => 2, 
                'id_room_type' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id_property' => 3, 
                'id_room_type' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);    
    }
}
