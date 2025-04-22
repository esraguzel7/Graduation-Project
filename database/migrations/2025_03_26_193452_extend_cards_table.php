<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->enum('card_type', [
                'general_type',

                'only_access',
                'only_payment',
                'only_event',

                'access_and_payment',
                'access_and_event',

                'payment_and_event'
            ]);
            $table->enum('card_status', [
                'active',
                'deactive',
                'ordered',
                'in cargo',
                'loss',
                'canceled'
            ])->default('ordered');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('card_type');
            $table->dropColumn('card_status');
        });
    }
};
