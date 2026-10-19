<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CompanyReview extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'company_reviews';

    protected $fillable = [
        'company_user_id',
        'student_user_id',
        'job_title',
        'job_location',
        'rating',
        'review_title',
        'review_description',
        'employment_start_date',
        'employment_end_date',
    ];
}