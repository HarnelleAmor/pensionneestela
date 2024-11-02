<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'test@customer.com',
            'usertype' => 'customer'
        ]);
        User::factory()->create([
            'email' => 'test@manager.com',
            'usertype' => 'manager'
        ]);

        $this->call([
            UnitSeeder::class,
            ServiceSeeder::class,
            AmenitySeeder::class
        ]);
    }
}
