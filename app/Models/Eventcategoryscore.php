<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventcategoryscore extends Model
{
    protected $fillable = [

        'eventcategory_id',
        'score',
         'isX',
        'createdBy',
        'updatedBy',
        'status'
       
    ];
}
