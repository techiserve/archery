<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MinScores extends Model
{
    //
    use HasFactory;

    protected $fillable = [

        'scoredId',
        'name',
        'level',
        'distance',
        'cub',
        'junior',
        'adult',
        'stripeColor',
        'createdBy',
        'updatedBy',
        'status'
       
    ];

}
