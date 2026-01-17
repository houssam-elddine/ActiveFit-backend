<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    protected $fillable = ['nom','prix','discipline_id'];

    public function discipline() {
        return $this->belongsTo(Discipline::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
}