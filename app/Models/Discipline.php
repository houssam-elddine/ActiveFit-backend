<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = ['nom','img','prix','user_id'];

    public function abonnements() {
        return $this->hasMany(Abonnement::class);
    }

    public function coachs() {
        return $this->hasMany(Coach::class);
    }
}
