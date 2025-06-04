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
        Schema::create('reader_sensors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id');
            $table->string('datas');
            $table->text('message')->nullable()->default(null);
            $table->boolean('is_critical')->default(false);
            $table->timestamps();

            $table->foreign('reader_id')->references('id')->on('readers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reader_sensors');
    }
};
