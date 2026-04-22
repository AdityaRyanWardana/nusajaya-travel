<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Armada;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Armada::where('name', 'Coaster 24 Seat')->update([
            'description' => 'Reliable Toyota Coaster for medium group comfort. Designed with a spacious cabin, evenly distributed air conditioning in every row, and advanced safety features.'
        ]);

        Armada::where('name', 'VIP 50 Seat')->update([
            'description' => 'Flagship Golden Dragon High Deck (HDD) fleet with air suspension for maximum quietness and comfort. Equipped with VIP seats featuring legrests and a premium sound system.'
        ]);

        Armada::where('name', 'VIP 40 Seat')->update([
            'description' => 'Executive Edition Golden Dragon with a spacious 40-seat configuration. Perfect for corporate travel with the most complete entertainment facilities in its class.'
        ]);

        Armada::where('name', '14 Seat VIP')->update([
            'description' => 'Passenger van for small-to-medium group capacity, comfortable, safe, and ready to serve your journey.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Restore Indonesian descriptions if needed
    }
};
