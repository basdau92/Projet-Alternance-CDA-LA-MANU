<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class energyAuditSeeder extends Seeder
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
            ],
            [
                'title' => 'Energy Audit 2',
                'path' => 'img/audit/img2.jpg',
                'alt' => 'Image2',
            ],
            [
                'title' => 'Energy Audit 3',
                'path' => 'img/audit/img3.jpg',
                'alt' => 'Image3',
            ],
            [
                'title' => 'Energy Audit 4',
                'path' => 'img/audit/img4.jpg',
                'alt' => 'Image4',
            ]

        ]);
    }
}
