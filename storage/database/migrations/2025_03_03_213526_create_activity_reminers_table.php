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
        Schema::create('activity_reminers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->boolean('send_email')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->string('time'); // 1 hour, 1 day, 2 days... etc.
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_reminers');
    }
};
