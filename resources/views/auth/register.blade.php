@extends('layouts.auth')

@section('title', 'Registracija')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-12 mb-16">
    <h2 class="text-2xl font-bold mb-4 text-center">Registracija</h2>


{{-- ----------REGISTER FAILED MESSAGE---------- --}}
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Ime</label>
            <input type="text" name="name" id="name" required class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" required class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Lozinka</label>
            <input type="password" name="password" id="password" required class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700">Potvrdi lozinku</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full mt-1 p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700">Registriraj se</button>
    </form>
</div>
@endsection
