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
        Schema::table('activities', function (Blueprint $table) {
            $table->boolean('has_paid')->default(false)->after('user_id'); // Add has_paid column
            $table->unsignedBigInteger('wallet_id')->nullable()->after('has_paid'); // Add wallet_id column

            // Add foreign key constraint for wallet_id
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']); // Drop foreign key for wallet_id
            $table->dropColumn('wallet_id'); // Remove wallet_id column
            $table->dropColumn('has_paid'); // Remove has_paid column
        });
    }
};
