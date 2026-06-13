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
        Schema::create('armada_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained()->onDelete('cascade');
            $table->string('vehicle_name');
            $table->date('expected_finish_date');
            $table->string('status')->default('active'); // active, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armada_maintenances');
    }
};
