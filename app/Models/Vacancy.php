<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vacancy extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'vacancies';

    protected $fillable = [
        'company_user_id', 'title', 'modality', 'location',
        'stay_duration', 'salary_fixed', 'periodicity',
        'description', 'benefits', 'status',
    ];

    protected $casts = [
        'benefits' => 'array',
        'salary_fixed' => 'integer',
    ];

    public function card(User $company): array
    {
        return [
            'id' => (string) $this->getKey(),
            'companyId' => (string) $company->getKey(),
            'title' => $this->title,
            'company' => $company->company_name,
            'location' => $this->location,
            'salary' => '$'.number_format((int) $this->salary_fixed).' - '.$this->periodicity,
            'salaryFixed' => (int) $this->salary_fixed,
            'periodicity' => $this->periodicity,
            'sector' => $company->sector,
            'createdAt' => $this->created_at?->toIso8601String(),
            'modality' => $this->modality,
            'stayDuration' => $this->stay_duration,
            'jobType' => 'Práctica',
            'benefits' => $this->benefits ?? [],
            'description' => $this->description,
        ];
    }
}
