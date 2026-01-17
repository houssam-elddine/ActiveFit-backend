<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'abonnement_id',
        'client_id',
        'numer_telephone',
        'prix',
        'status'
    ];

    public function abonnement() {
        return $this->belongsTo(Abonnement::class);
    }

    public function client() {
        return $this->belongsTo(User::class,'client_id');
    }
}

