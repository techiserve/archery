<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archergrading extends Model
{
    //
    //use HasFactory;

    protected $fillable = [

        'name',
        'archer_id',
        'date',
        'bowUsed',
        'arrowsUsed',
        'ageCategory',
        'currentGrading',
        'gradingfor',
        'totalScore',
        
        'withKhatrah',
        'arrowinhand',
        'timed',
        'thumbring',

        'scoredBy',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
