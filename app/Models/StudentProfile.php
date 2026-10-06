<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use MongoDB\Laravel\Eloquent\Model;

#[Fillable([
    'user_id',
    'kardex_path',
    'kardex_original_name',
])]
class StudentProfile extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'student_profiles';
}