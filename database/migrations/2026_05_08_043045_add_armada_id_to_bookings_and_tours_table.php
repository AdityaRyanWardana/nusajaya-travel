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
        Schema::table('tours', function (Blueprint $table) {
            $table->foreignId('armada_id')->nullable()->after('price')->constrained('armadas')->nullOnDelete();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('armada_id')->nullable()->after('service_slug')->constrained('armadas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['armada_id']);
            $table->dropColumn('armada_id');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['armada_id']);
            $table->dropColumn('armada_id');
        });
    }
};
