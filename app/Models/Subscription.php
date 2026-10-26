<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'subscriptions';

    protected $fillable = [
        'company_user_id', 'membership_id', 'status', 'started_at', 'ended_at',
        'amount', 'currency', 'billing_email', 'payment_status', 'reference',
        'membership_name', 'membership_code', 'membership_benefits',
        'membership_vacancy_limit', 'membership_priority', 'payment_method', 'paid_at',
    ];

    protected $casts = [
        'started_at' => 'datetime', 'ended_at' => 'datetime', 'paid_at' => 'datetime',
        'amount' => 'float', 'membership_benefits' => 'array',
        'membership_vacancy_limit' => 'integer', 'membership_priority' => 'integer',
    ];

    public function summary(?User $company = null): array
    {
        return [
            'id' => (string) $this->getKey(),
            'company_user_id' => $this->company_user_id,
            'company_name' => $company?->company_name ?? 'Empresa no disponible',
            'membership_id' => $this->membership_id,
            'membership_name' => $this->membership_name ?? 'Plan sin nombre histórico',
            'amount' => $this->amount,
            'currency' => $this->currency ?? 'Sin registrar',
            'payment_status' => $this->payment_status ?? 'Sin registrar',
            'status' => $this->status,
            'reference' => $this->reference,
            'billing_email' => $this->billing_email,
            'payment_method' => $this->payment_method ?? 'Sin registrar',
            'created_at' => $this->created_at?->toIso8601String(),
            'paid_at' => $this->paid_at?->toIso8601String(),
            'started_at' => $this->started_at?->toIso8601String(),
            'ended_at' => $this->ended_at?->toIso8601String(),
        ];
    }
}
