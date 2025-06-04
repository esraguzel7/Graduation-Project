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
        Schema::create('possitive_point_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history');
            $table->enum('level', ['low', 'medium', 'high']);
            $table->text('message');
            $table->boolean('need_help')->default(false);
            $table->timestamps();

            $table->foreign('history')->references('id')->on('possitive_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('possitive_point_notes');
    }
};
