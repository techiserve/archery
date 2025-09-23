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
            $table->string('generatedId')->nullable();
            $table->string('nId')->nullable();
            $table->string('gender')->nullable();
            $table->string('knownAs')->nullable();
            $table->string('institute')->nullable();
            $table->string('ageCategory')->nullable();
            $table->string('currentGradingDominant')->nullable();
            $table->string('currentGradingWeak')->nullable();
            $table->string('currentProficiency')->nullable();
            $table->string('agegroupProficiency')->nullable();
            $table->string('clubMember')->nullable();
            $table->string('email')->nullable();
            $table->string('hand')->nullable();
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
