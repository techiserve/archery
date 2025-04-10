<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingCard extends Model
{
    
    protected $fillable = [

        'level',
        'distance',
        'score',
        'scoredBy',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
