<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationRequestMail;

class ReservationMailController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        Mail::to('vuxii.kezo@gmail.com')->send(new ReservationRequestMail($validated));

        return back()->with('success', 'Vaš zahtjev je poslan. Hvala!');
    }
}
