<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventscore extends Model
{
    //
    protected $fillable = [

        'event_id',
        'archer_id',
        'bowUsed',
        'arrowUsed',
        'ageCategory',
        'currentGrading',
        'gradingfor',

        'khatrah',
        'timed',
        'arrowinhand',
        'thumbring',
        'totalScore',
        'createdBy',
        'updatedBy',
        'status',
        'certificate_email_status',
        'certificate_email_address',
        'certificate_email_attempts',
        'certificate_email_last_attempted_at',
        'certificate_email_sent_at',
        'certificate_email_error',
       
    ];

    protected $casts = [
        'certificate_email_attempts' => 'integer',
        'certificate_email_last_attempted_at' => 'datetime',
        'certificate_email_sent_at' => 'datetime',
    ];


    public function archers()
    {
        return $this->hasMany(Archer::class);
    }
}
