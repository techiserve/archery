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
        Schema::create('scorecards', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable();
            $table->integer('archer_id')->nullable();
            $table->integer('round')->nullable();
            $table->integer('arrow')->nullable();
            $table->integer('archergrading_id')->nullable();
            $table->integer('roundtotal')->nullable();
            $table->integer('cumtotal')->nullable();
            $table->integer('currentPR')->nullable();
            $table->integer('isX')->nullable();
            $table->integer('requiredPR')->nullable();
            $table->integer('total')->nullable();
            $table->string('time')->nullable();
            $table->string('createdBy')->nullable();
            $table->string('updatedBy')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scorecards');
    }
};
