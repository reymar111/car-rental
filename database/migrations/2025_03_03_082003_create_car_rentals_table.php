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
            $table->integer('route_id');
            $table->integer('route_city_id');
            $table->integer('car_id');
            $table->integer('number_passenger');
            $table->integer('number_days');
            $table->integer('car_type_id');
            $table->boolean('with_driver')->default(false);
            $table->integer('car_color_id')->nullable();
            $table->decimal('total_amount', 8, 2);
            $table->integer('payment_id');
            $table->date('pickup_date');
            $table->integer('status_id')->default(1);
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->integer('cancelled_by')->nullable();
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
