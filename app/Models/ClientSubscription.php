<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSubscription extends Model
{
    protected $fillable = [
        'client_id',
        'subscription_id',
        'start_date',
        'end_date',
        'paid_amount',
        'payment_method'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
