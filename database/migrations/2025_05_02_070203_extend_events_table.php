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
        Schema::table('events', function (Blueprint $table) {
            $table->string('event_category')->nullable()->after('description');
            $table->boolean('is_important')->default(false)->after('event_category');
            $table->renameColumn('participation_fee', 'event_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('event_category');
            $table->dropColumn('is_important');
            $table->renameColumn('event_cost', 'participation_fee');
        });
    }
};
