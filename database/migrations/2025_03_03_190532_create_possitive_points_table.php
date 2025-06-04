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
        Schema::create('possitive_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('joined_event_count')->default(0);
            $table->decimal('total_earned')->default(0.0);
            $table->string('history_period')->default('monthly');
            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('possitive_points');
    }
};
