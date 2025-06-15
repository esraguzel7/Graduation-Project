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
        Schema::table('card_requests', function (Blueprint $table) {
            $table->string('card_id')->nullable()->after('status'); // New column for card ID
            $table->text('delivery_info')->nullable()->after('card_id'); // New column for delivery information
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
                'card_assigned', // New status for card ID assigned
                'ready_for_pickup', // New status for ready for pickup
                'completed', // New status for order completed
            ])->default('pending')->change(); // Update enum values for status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_requests', function (Blueprint $table) {
            $table->dropColumn('card_id'); // Drop card ID column
            $table->dropColumn('delivery_info'); // Drop delivery information column
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending')->change(); // Revert enum values for status
        });
    }
};
