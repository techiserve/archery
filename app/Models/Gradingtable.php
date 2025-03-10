<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gradingtable extends Model
{
    //
    use HasFactory;

    protected $fillable = [

        'achergrading_id',
        'round',
        'arrow1',
        'arrow2',
        'arrow3',
        'arrow4',
        'arrow5',
        'arrow6',
        'roundTotal',
        'cumTotal',
        'time',
        'totalScore',
        'scoredBy',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
