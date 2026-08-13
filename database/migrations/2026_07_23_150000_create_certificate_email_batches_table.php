<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_email_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('event_id');
            $table->string('status')->default('queued');
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('sent')->default(0);
            $table->unsignedInteger('failed')->default(0);
            $table->json('event_score_ids')->nullable();
            $table->json('errors')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('dismissed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_email_batches');
    }
};
