<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id', 'birth_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ClientSubscription::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
