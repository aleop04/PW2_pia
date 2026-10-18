<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Bookmark extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'bookmarks';
    protected $fillable = ['student_user_id', 'vacancy_id'];
}
