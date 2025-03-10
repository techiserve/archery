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
        'status'
       
    ];


    public function archers()
    {
        return $this->hasMany(Archer::class);
    }
}
