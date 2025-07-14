<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function timeslots() {
        return $this->hasMany(Timeslot::class);
    }


    protected $fillable = [
        'location_id',
        'date',
    ];
}
