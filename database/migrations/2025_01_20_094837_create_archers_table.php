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
        Schema::create('archers', function (Blueprint $table) {
            $table->id();
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('ageCategory')->nullable();
            $table->string('currentGrading')->nullable();
            $table->string('style')->nullable();
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
        Schema::dropIfExists('archers');
    }
};
