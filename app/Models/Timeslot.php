<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    public function day() {
        return $this->belongsTo(Day::class);
    }

    protected $fillable = [
    'day_id',
    'time',
    ];
}
