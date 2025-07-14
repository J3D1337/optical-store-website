<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function days() {
        return $this->hasMany(Day::class);
    }
}
