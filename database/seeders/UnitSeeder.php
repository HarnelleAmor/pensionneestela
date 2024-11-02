<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'name' => 'Unit A1',
                'bed_config' => '2 Medium sized bed',
                'view' => 'Balcony View',
                'location' => 'First Floor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Unit A2',
                'bed_config' => '2 Medium sized bed',
                'view' => 'Balcony View',
                'location' => 'First Floor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Unit B1',
                'bed_config' => '2 Medium sized bed',
                'view' => 'Terrace View',
                'location' => 'Second Floor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Unit B2',
                'bed_config' => '2 Medium sized bed',
                'view' => 'Terrace View',
                'location' => 'Second Floor',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        $units = Unit::all();
        foreach ($units as $unit) {
            Photo::create([
                'unit_id' => $unit->id,
                'photos_path' => 'assets/images/banner2.jpg',
                'descr' => 'sdaasdasd'
            ]);
        }
    }
}
