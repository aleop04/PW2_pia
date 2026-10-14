<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Application extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'applications';

    protected $fillable = [
        'vacancy_id', 'company_user_id', 'student_user_id',
        'full_name', 'email', 'phone', 'location',
        'cv_path', 'cv_name', 'status',
    ];
}
