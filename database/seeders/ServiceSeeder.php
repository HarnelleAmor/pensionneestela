<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'name' => 'Meal Service',
            'descr' => 'magpaluto ng pagkain',
            'service_cost' => 100.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('services')->insert([
            'name' => 'Extra Blanket',
            'descr' => 'kumot',
            'service_cost' => 50.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('services')->insert([
            'name' => 'Extra Bed Foam',
            'descr' => 'magpaluto ng pagkain',
            'service_cost' => 150.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('services')->insert([
            'name' => 'Extra Bath Towel',
            'descr' => 'magpaluto ng pagkain',
            'service_cost' => 50.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
