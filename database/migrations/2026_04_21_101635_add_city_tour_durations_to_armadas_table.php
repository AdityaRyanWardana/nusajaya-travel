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
        Schema::table('armadas', function (Blueprint $table) {
            $table->decimal('price_city_one_way', 15, 2)->nullable();
            $table->decimal('price_city_half_day', 15, 2)->nullable();
            $table->decimal('price_city_one_day', 15, 2)->nullable();
            $table->decimal('price_city_full_day', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('armadas', function (Blueprint $table) {
            $table->dropColumn([
                'price_city_one_way', 
                'price_city_half_day', 
                'price_city_one_day', 
                'price_city_full_day'
            ]);
        });
    }
};
