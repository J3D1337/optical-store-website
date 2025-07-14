<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    // ----------REGISTER----------
    public function register(){
        return view('auth.register');
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|min:3|unique:users,name|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => ($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Your account has been created successfully!');
    }



    // ----------LOGIN----------
    public function login(){
        return view('auth.login');
    }


    public function authenticate()
    {
        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'You have been logged in successfully!');
        }

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('dashboard')->with('success', 'You have been logged out successfully!');
    }
}
