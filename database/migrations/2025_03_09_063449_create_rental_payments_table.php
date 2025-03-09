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
        Schema::create('car_rental_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('car_rental_id');
            $table->string('reference_number');
            $table->text('notes')->nullable();
            $table->text('proof_payment');
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_declined')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rental_payments');
    }
};
