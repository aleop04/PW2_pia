<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'subscriptions';

    protected $fillable = [
        'company_user_id',
        'membership_id',
        'status',
        'started_at',
        'ended_at',
        'amount',
        'billing_email',
        'card_brand',
        'card_last_four',
        'cardholder_name',
        'billing_country',
        'billing_postal_code',
        'payment_status',
    ];
}