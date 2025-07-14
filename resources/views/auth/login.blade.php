@extends('layouts.auth')

@section('title', 'Prijava')

@section('content')
<div class="max-w-md bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Prijava</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" required class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700">Lozinka</label>
            <input type="password" name="password" id="password" required class="w-full mt-1 p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700">Prijavi se</button>
    </form>
</div>
@endsection
