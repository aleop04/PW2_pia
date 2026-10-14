<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;

#[Fillable([
    'first_name',
    'paternal_last_name',
    'maternal_last_name',
    'birth_date',
    'phone',
    'email',
    'password',
    'role',
    'company_name',
    'rfc',
    'sector',
    'custom_sector',
    'state',
    'city',
    'description',
    'cv_path',
    'cv_name',
    'avatar_path',
    'logo_path',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';

    protected $table = 'users';

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
