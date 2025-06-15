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
        Schema::table('readers', function (Blueprint $table) {
            // ip sütununu wifi_ip olarak değiştir
            $table->renameColumn('ip', 'wifi_ip');
            // id sütunundan hemen sonra yeni sütunlar ekle
            $table->string('device_id')->unique()->after('id');
            $table->string('wifi_mac')->nullable()->after('wifi_ip');
            $table->string('ethernet_ip')->nullable()->after('wifi_mac');
            $table->string('ethernet_mac')->nullable()->after('ethernet_ip');
            $table->string('public_ip')->nullable()->after('ethernet_mac');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('readers', function (Blueprint $table) {
            // yeni eklenen sütunları kaldır
            $table->dropColumn(['device_id', 'wifi_mac', 'ethernet_ip', 'ethernet_mac', 'public_ip']);
            // wifi_ip sütununu tekrar ip olarak değiştir
            $table->renameColumn('wifi_ip', 'ip');
        });
    }
};
