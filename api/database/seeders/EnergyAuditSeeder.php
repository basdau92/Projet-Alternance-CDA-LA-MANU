<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EnergyAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('energy_audit')->insert([
            [
                'title' => 'Energy Audit 1',
                'path' => 'img/audit/img1.jpg',
                'alt' => 'Image1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Energy Audit 2',
                'path' => 'img/audit/img2.jpg',
                'alt' => 'Image2',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Energy Audit 3',
                'path' => 'img/audit/img3.jpg',
                'alt' => 'Image3',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Energy Audit 4',
                'path' => 'img/audit/img4.jpg',
                'alt' => 'Image4',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]

        ]);
    }
}
