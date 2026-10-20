<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CompanyProfileView extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'company_profile_views';

    protected $fillable = [
        'company_user_id',
        'student_user_id',
        'viewed_on',
    ];
}