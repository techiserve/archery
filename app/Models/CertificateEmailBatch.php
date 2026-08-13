<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateEmailBatch extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'total',
        'sent',
        'failed',
        'event_score_ids',
        'errors',
        'started_at',
        'completed_at',
        'dismissed_at',
    ];

    protected $casts = [
        'event_score_ids' => 'array',
        'errors' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'dismissed_at' => 'datetime',
    ];
}
