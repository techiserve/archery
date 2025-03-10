<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round7 extends Model
{
    //
    protected $fillable = [

        'event_id',
        'archer_id',
        'arrow1',
        'arrow2',
        'arrow3',
        'arrow4',
        'arrow5',
        'arrow6',
        'roundtotal',
        'cumtotal',
        'time',

        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
