<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('occupancy_limit')->default(6);
            $table->string('bed_config');
            $table->string('view');
            $table->string('location');
            $table->decimal('price_per_night', total: 8, places: 2)->default(2500.00);
            $table->boolean('is_archived')->default(false); // archive unit as the alternative for deleting it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
