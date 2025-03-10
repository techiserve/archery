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
        Schema::create('min_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('scoredId')->nullable();
            $table->string('name')->nullable();
            $table->string('level')->nullable();
            $table->string('distance')->nullable();
            $table->string('cub')->nullable();
            $table->string('junior')->nullable();
            $table->string('adult')->nullable();
            $table->string('stripeColor')->nullable();
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
        Schema::dropIfExists('min_scores');
    }
};
