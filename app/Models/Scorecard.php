<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scorecard extends Model
{
    //
    protected $fillable = [

        'event_id',
        'archer_id',
        'round',
        'arrow',
        'archergrading_id',
        'roundtotal',
        'cumtotal',
        'total',
        'currentPR',
        'requiredPR',
        'time',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
