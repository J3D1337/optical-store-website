<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Location;

class ReserveController extends Controller
{
    public function reserveRijeka(){

        // Get Rijeka location from DB
        $location = Location::where('name', 'Rijeka')->firstOrFail();

        // Fetch all dates with timeslots
        $days = $location->days()->with(['timeslots' => function ($query) {
            $query->orderBy('time');
        }])->orderBy('date')->get();


        return view('reserveRijeka', compact('days'));
    }

    public function reserveCrikvenica(){

        // Get Crikvenica location from DB
        $location = Location::where('name', 'Crikvenica')->firstOrFail();

        // Fetch all dates with timeslots
        $days = $location->days()->with(['timeslots' => function ($query) {
            $query->orderBy('time');
        }])->orderBy('date')->get();


        return view('reserveCrikvenica', compact('days'));
    }

}
