<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Day;
use App\Models\Timeslot;
use Illuminate\Support\Facades\Log;

class CreateDayController extends Controller
{
    public function dayAdminView()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $locations = Location::with(['days.timeslots' => fn($q) => $q->orderBy('time')])
            ->orderBy('name')
            ->get();
        return view('admin.dayAdminView', compact('locations'));
    }


    //Store new date and time
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date',
            'timeslots' => 'required|array|min:1',
            'timeslots.*' => 'required|date_format:H:i',
        ]);

        $day = Day::create([
            'location_id' => $request->location_id,
            'date' => $request->date,
        ]);

        foreach ($request->timeslots as $time) {
            Timeslot::create([
                'day_id' => $day->id,
                'time' => $time,
            ]);
        }

        return response()->json(['message' => 'Dan dodan']);
    }


    //Fetch edit form
    public function edit($id)
    {
        $day = Day::with('timeslots')->findOrFail($id);
        $locations = Location::all();

        return view('admin.editDayView', compact('day', 'locations',));
    }


    //Update existing dates and timeslots
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'date' => 'required|date',
            'timeslots_ids' => 'array',
            'timeslots_values' => 'array',
        ]);

        $day = Day::findOrFail($id);
        $day->update([
            'date' => $request->date,
        ]);

        // Sync timeslots
        $ids = $request->timeslots_ids ?? [];
        $values = $request->timeslots_values ?? [];

foreach ($ids as $i => $slotId) {
    if (!isset($values[$i])) {
        Log::warning("Missing time for timeslot at index $i (slotId: $slotId)");
        continue;
    }

    $time = $values[$i];
    $formattedTime = \Carbon\Carbon::parse($time)->format('H:i:s');

    if (!is_numeric($slotId)) {
        $created = $day->timeslots()->create(['time' => $formattedTime]);

    } else {
        $slot = Timeslot::find($slotId);
        if ($slot && $slot->day_id == $day->id) {
            $slot->update(['time' => $formattedTime]);

        }
    }
}

        // Optional: delete removed timeslots
        $existingIds = $day->timeslots->pluck('id')->toArray();
        $submittedIds = array_filter($ids, fn($id) => $id !== 'new');
        $toDelete = array_diff($existingIds, $submittedIds);
        Timeslot::destroy($toDelete);

        return redirect()->route('admin.day.create')->with('success', 'Dan i termini ažurirani.');
    }


    //Delete date and time
    public function delete($id)
    {
        $day = Day::findOrFail($id);
        $day->delete();

        return redirect()->route('admin.day.create')->with('success', 'Dan obrisan.');
    }
}
