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
        Schema::create('readers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('ip');
            $table->enum('type', [
                'turnstile',                // turnike
                'authorization',            // yetkilendirme
                'business_payment',         // işletme_ödeme
                'device_payment',           // cihaz_ödeme
                'new_registration',         // yeni_kayıt
                'event_participation',      // etkinlik_katılım
                'overtime_entry',           // mesai_giriş
                'overtime_exit',            // mesai_çıkış
                'overtime_toggle',          // mesai_toggle
            ]);
            $table->timestamp('last_connection')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readers');
    }
};
