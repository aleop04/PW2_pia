<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Membership extends Model
{
    protected $connection = 'mongodb';
    
    protected $fillable = [
        'code',
        'name',
        'price',
        'vacancy_limit',
        'priority',
        'benefits',
        'active'
    ];
}