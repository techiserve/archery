<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventcategory extends Model
{
    //
    protected $fillable = [

        'name',
        'desc',
        'score1',
        'score2',
        'score3',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
