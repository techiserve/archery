<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventcategory extends Model
{
    //
    protected $fillable = [

        'name',
        'desc',
        'rounds',
        'arrows',
       
        'score3',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
