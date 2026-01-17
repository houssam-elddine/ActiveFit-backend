<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = ['name','img','description','discipline_id'];

    public function discipline() {
        return $this->belongsTo(Discipline::class);
    }
}