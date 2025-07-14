@extends('layouts.app')

@section('title', 'Rezervacije Crikvenica')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-12 mb-16">
        <h2 class="text-2xl font-bold mb-4 text-center">Rezervacije Crikvenica</h2>

        @forelse ($days as $day)
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm opacity-0 animate-fade-in">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        {{ \Carbon\Carbon::parse($day->date)->format('d.m.Y') }}
                    </span>
                    <span class="ml-2 text-sm text-gray-500">
                        {{ mb_convert_case(\Carbon\Carbon::parse($day->date)->translatedFormat('l'), MB_CASE_TITLE, 'UTF-8') }}
                    </span>
                </h3>
                <div class="flex flex-wrap gap-4 mt-2">
                    @foreach ($day->timeslots as $slot)
                        <button onclick="openForm('{{ $day->date }}', '{{ $slot->time }}')"
                            class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium px-4 py-2 rounded-full border border-blue-300 transition">
                            🕒 {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }}
                        </button>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-6 py-5 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-bold mb-2">Trenutno nema dostupnih termina</h3>
                <p class="text-sm">Provjerite ponudu uskoro ili nas kontaktirajte za više informacija.</p>
            </div>
        @endforelse

        {{-- Modal Form --}}
        <div id="contactForm"
            class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md relative">
                <button onclick="closeForm()"
                    class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                <h3 class="text-2xl font-bold mb-4 text-center text-gray-800">Pošaljite upit</h3>
                <form method="POST" action="{{ route('reservation.send') }}">
                    @csrf
                    <input type="hidden" name="location" value="Crikvenica">
                    <input type="hidden" name="date" id="formDate">
                    <input type="hidden" name="time" id="formTime">

                    <div class="mb-3">
                        <label class="block font-medium">Ime i prezime</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-3">
                        <label class="block font-medium">Email</label>
                        <input type="email" name="email" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-3">
                        <label class="block font-medium">Poruka (opcionalno)</label>
                        <textarea name="message" class="w-full border p-2 rounded"></textarea>
                    </div>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg w-full font-semibold transition shadow">
                        📩 Pošalji upit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
