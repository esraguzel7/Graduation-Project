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
        Schema::create('card_pass_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('reader_id')->nullable();
            $table->string('card_owner');   // kullanıcı silinse dahi işlemin kime ait olduğunu hatırlamak için eklendi
            $table->string('card_reader');   // kart okuyucu silinse dahi işlemin hangi okuyucuya ait olduğunu hatırlamak için eklendi
            $table->boolean('is_successful')->default(false);
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards')->onDelete('set null');
            $table->foreign('reader_id')->references('id')->on('readers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_pass_histories');
    }
};
