<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventscores', function (Blueprint $table) {
            $table->string('certificate_email_status', 20)->nullable()->after('status');
            $table->string('certificate_email_address')->nullable()->after('certificate_email_status');
            $table->unsignedInteger('certificate_email_attempts')->default(0)->after('certificate_email_address');
            $table->timestamp('certificate_email_last_attempted_at')->nullable()->after('certificate_email_attempts');
            $table->timestamp('certificate_email_sent_at')->nullable()->after('certificate_email_last_attempted_at');
            $table->text('certificate_email_error')->nullable()->after('certificate_email_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('eventscores', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_email_status',
                'certificate_email_address',
                'certificate_email_attempts',
                'certificate_email_last_attempted_at',
                'certificate_email_sent_at',
                'certificate_email_error',
            ]);
        });
    }
};
