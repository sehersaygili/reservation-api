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
$table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
$table->foreignId('pickup_location_id')->constrained('locations');
$table->foreignId('dropoff_location_id')->constrained('locations');
$table->string('customer_name');
$table->string('customer_email');
$table->dateTime('starts_at');
$table->dateTime('ends_at');
$table->decimal('total_price', 10, 2);
$table->string('status')->default('pending');
$table->index(['vehicle_id', 'starts_at', 'ends_at']);
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
