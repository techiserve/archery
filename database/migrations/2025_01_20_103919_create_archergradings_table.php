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
        Schema::create('archergradings', function (Blueprint $table) {
            $table->id();
            $table->integer('archer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('date')->nullable();
            $table->string('bowUsed')->nullable();
            $table->string('arrowsUsed')->nullable();
            $table->string('ageCategory')->nullable();
            $table->string('currentGrading')->nullable();
            $table->string('gradingfor')->nullable();
            $table->string('totalScore')->nullable();
            $table->string('withKhatrah')->nullable();
            $table->string('arrowinhand')->nullable();
            $table->string('timed')->nullable();
            $table->string('thumbring')->nullable();
            $table->string('scoredBy')->nullable();
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
        Schema::dropIfExists('archergradings');
    }
};
