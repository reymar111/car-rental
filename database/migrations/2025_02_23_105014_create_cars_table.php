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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->integer('model_id');
            $table->integer('color_id');
            $table->integer('type_id')->nullable();
            $table->string('year');
            $table->string('color')->nullable();
            $table->string('plate_number');
            $table->decimal('rental_price', 8, 2)->nullable();
            $table->integer('max_capacity');
            $table->integer('status_id')->nullable();
            $table->text('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
