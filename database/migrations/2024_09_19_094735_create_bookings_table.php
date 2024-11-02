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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 5)->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_no');
            $table->enum('status', ['pending', 'confirmed', 'checked-in', 'checked-out', 'no-show', 'cancelled']);
            $table->string('reason_of_cancel')->nullable();
            $table->integer('no_of_guests');
            $table->date('checkin_date'); // date provided in the booking transaction
            $table->time('checkin_time')->nullable(); // time the guests actually arrived
            $table->date('checkout_date'); // date provided in the booking transaction
            $table->time('checkout_time')->nullable(); // time the guests actually departed
            $table->decimal('outstanding_payment', places: 2)->default(0);
            $table->decimal('total_payment', places: 2);
            $table->string('gcash_ref_no', 13)->unique()->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
