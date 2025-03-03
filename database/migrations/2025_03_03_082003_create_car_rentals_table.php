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
        Schema::create('car_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number');
            $table->integer('user_id');
            $table->integer('car_id');
            $table->date('pick_up_date');
            $table->date('return_date');
            $table->decimal('total_amount', 8, 2);
            $table->integer('status_id');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rentals');
    }
};
