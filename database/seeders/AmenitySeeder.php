<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Categories: bedroom, bathroom, kitchen, comfort, more
         */
        DB::table('amenities')->insert([
            ['name' => 'Free Wifi', 'icon' => 'wifi-icon', 'category' => 'comforts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Smart TV', 'icon' => 'tv-icon', 'category' => 'comforts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fan', 'icon' => 'fan-icon', 'category' => 'comforts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Couch', 'icon' => 'couch-icon', 'category' => 'comforts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sockets near beds', 'icon' => 'outlet-icon', 'category' => 'comforts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Closet', 'icon' => 'closet-icon', 'category' => 'bedroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hanger', 'icon' => 'hanger-icon', 'catgeory' => 'bedroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bidet', 'icon' => 'bidet-icon', 'category' => 'bathroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shower', 'icon' => 'shower-icon', 'category' => 'bathroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Free Toilet Paper', 'icon' => 'toiletpaper-icon', 'category' => 'bathroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Water Heater', 'icon' => 'waterheater-icon', 'category' => 'bathroom', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Refrigerator', 'icon' => 'fridge-icon', 'category' => 'kitchen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Microwave', 'icon' => 'microwave-icon', 'category' => 'kitchen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electrice Kettle', 'icon' => 'kettle-icon', 'category' => 'kitchen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stove', 'icon' => 'stove-icon', 'category' => 'kitchen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rice Cooker', 'icon' => 'ricecooker-icon', 'category' => 'kitchen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Free Parking Space', 'icon' => 'parkingspace-icon', 'category' => 'more', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $units = Unit::all();
        $amenities = Amenity::all();
        foreach ($units as $unit) {
            foreach ($amenities as $amenity) {
                DB::table('amenity_unit')->insert([
                    'unit_id' => $unit->id,
                    'amenity_id' => $amenity->id,
                    'quantity' => 1,
                    'highlight' => in_array($amenity->name, ['Free Wifi', 'Smart TV', 'Shower', 'Water Heater', 'Sockets near beds']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
    }
}
