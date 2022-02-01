<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds for the "room_type" table (DB: projetimmo).
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_type')->insert([
            ['name' => 'chambre',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'bureau',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'séjour',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'bibliothèque',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);  
    }
}
