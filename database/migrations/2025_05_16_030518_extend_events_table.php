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
            $table->string('location')->nullable()->default(null)->change();
            $table->integer('event_cost')->default(0)->change(); // Varsayılan değer 0 olarak güncellendi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('location')->nullable(false)->default('')->change();
            $table->integer('event_cost')->default(null)->change(); // Varsayılan değer geri alındı
        });
    }
};
