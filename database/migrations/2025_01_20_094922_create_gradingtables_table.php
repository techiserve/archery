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
        Schema::create('gradingtables', function (Blueprint $table) {
            $table->id();
            $table->integer('achergrading_id')->nullable();
            $table->string('round')->nullable();
            $table->string('arrow1')->nullable();
            $table->string('arrow2')->nullable();
            $table->string('arrow3')->nullable();
            $table->string('arrow4')->nullable();
            $table->string('arrow6')->nullable();
            $table->string('roundTotal')->nullable();
            $table->string('cumTotal')->nullable();
            $table->string('time')->nullable();
            $table->string('totalScore')->nullable();
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
        Schema::dropIfExists('gradingtables');
    }
};
