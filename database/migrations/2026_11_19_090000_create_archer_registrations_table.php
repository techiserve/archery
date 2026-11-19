<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archer_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('knownAs')->nullable();
            $table->date('dob');
            $table->string('nId', 50);
            $table->string('gender', 20);
            $table->string('hand', 10);
            $table->string('email');
            $table->string('institute')->nullable();
            $table->string('ageCategory', 20)->nullable();
            $table->string('agegroupProficiency', 20)->nullable();
            $table->string('currentGradingDominant', 10)->nullable();
            $table->string('currentGradingWeak', 10)->nullable();
            $table->string('currentProficiency', 10)->nullable();
            $table->boolean('clubMember')->default(false);
            $table->string('status', 20)->default('pending')->index();
            $table->string('active_identity', 64)->nullable()->unique();
            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('archer_id')->nullable()->unique()->constrained('archers')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archer_registrations');
    }
};
