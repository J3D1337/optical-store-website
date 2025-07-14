@extends('layouts.admin')

@section('title', 'Dodaj Novi Dan')

@section('content')

    <style>
        .fade-scale-enter {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.2s ease-out;
        }

        .fade-scale-enter-active {
            opacity: 1;
            transform: scale(1);
        }

        .fade-scale-leave {
            opacity: 1;
            transform: scale(1);
            transition: all 0.15s ease-in;
        }

        .fade-scale-leave-active {
            opacity: 0;
            transform: scale(0.95);
        }
    </style>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-12 mb-16">
        <h2 class="text-2xl font-bold mb-4 text-center">Dodaj Novi Dan</h2>

        <form id = "create-day-form">
            @csrf

            {{-- Location Dropdown --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Lokacija</label>
                <select name="location_id" class="w-full border p-2 rounded" required>
                    <option value="">Odaberi lokaciju</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Date Input --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Datum</label>
                <input type="date" name="date" class="w-full border p-2 rounded" required>
            </div>

            {{-- Time Slots --}}
            <div class="mb-4">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Dodaj Raspon Vremena (30min razmaci)</label>
                    <div class="flex gap-2 mb-2">
                        <input type="time" id="from-time" class="border p-2 rounded w-full" placeholder="Od">
                        <input type="time" id="to-time" class="border p-2 rounded w-full" placeholder="Do">
                        <button type="button" onclick="generateTimeslots()"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded">Generiraj</button>
                    </div>
                </div>
                <div id="timeslot-container">


                </div>

            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mt-4">Spremi
                Dan</button>
        </form>
    </div>



    <hr class="my-8 border-t-2">

    <h2 class="text-2xl font-bold mb-4 text-center">Postojeći Dani</h2>

    <div id="day-list">
        @foreach ($locations as $location)
            <div class="mb-8 ml-12 mr-12">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $location->name }}</h3>

                @forelse ($location->days as $day)
                    <div class="border rounded p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <strong>
                                    {{ \Carbon\Carbon::parse($day->date)->format('d.m.Y') }}
                                    ({{ mb_convert_case(\Carbon\Carbon::parse($day->date)->translatedFormat('l'), MB_CASE_TITLE, 'UTF-8') }})
                                </strong>
                                <div class="text-sm text-gray-600 mt-1">
                                    <span class="font-medium">Termini:</span>
                                    @foreach ($day->timeslots as $slot)
                                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded mr-2">
                                            {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="toggleEdit({{ $day->id }})"
                                    class="text-blue-500 hover:underline">Uredi</button>

                                <form method="POST" action="{{ route('admin.day.delete', $day->id) }}"
                                    onsubmit="return confirm('Jeste li sigurni da želite obrisati ovaj dan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Obriši</button>
                                </form>
                            </div>
                        </div>

                        <div id="edit-form-{{ $day->id }}" class="mt-4 hidden fade-scale-enter">
                            <div class="bg-white p-4 rounded shadow max-w-xl mx-auto text-sm">
                                <form method="POST" action="{{ route('admin.day.update', $day->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="flex flex-wrap gap-4 mb-4">
                                        <div class="flex flex-col">
                                            <label class="block font-semibold mb-1">Datum</label>
                                            <input type="date" name="date" value="{{ $day->date }}"
                                                class="border p-1 text-sm rounded w-44" required>
                                        </div>

                                        <div class="flex-1">
                                            <label class="block font-semibold mb-1">Termini</label>
                                            <div id="timeslot-edit-container-{{ $day->id }}">
                                                @foreach ($day->timeslots as $slot)
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <input type="hidden" name="timeslots_ids[]"
                                                            value="{{ $slot->id }}">
                                                        <input type="time" name="timeslots_values[]"
                                                            value="{{ $slot->time }}"
                                                            class="border p-1 text-sm rounded w-32" required>
                                                        <button type="button" onclick="this.parentElement.remove()"
                                                            class="text-red-500 hover:text-red-700 text-lg">✖</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" onclick="addEditTimeslot({{ $day->id }})"
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">
                                                + Dodaj Termin
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex gap-2 justify-end mt-2">
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                                            Spremi promjene
                                        </button>
                                        <button type="button" onclick="toggleEdit({{ $day->id }})"
                                            class="text-gray-500 underline text-sm">
                                            Odustani
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 italic">Nema unesenih dana za ovu lokaciju.</p>
                @endforelse
            </div>
        @endforeach
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        document.getElementById('create-day-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            try {
                const res = await fetch('{{ route('admin.day.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                if (res.ok) {
                    showNotification('Dan uspješno dodan!', 'success');
                    document.getElementById('timeslot-container').innerHTML = '';
                    form.reset();


                    // 🔄 Reload just the #day-list section
                    const response = await fetch(window.location.href);
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newDayList = doc.getElementById('day-list');
                    if (newDayList) {
                        document.getElementById('day-list').innerHTML = newDayList.innerHTML;
                    }
                } else {
                    showNotification('Greška pri dodavanju dana', 'error');
                }
            } catch (err) {
                console.error(err);
                showNotification('Greška pri dodavanju dana', 'error');
            }
        });



        function addTimeslot(value = '') {
            const container = document.getElementById('timeslot-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
            <input type="time" name="timeslots[]" value="${value}" class="border p-2 rounded w-full" required>
            <button type="button" onclick="removeTimeslot(this)" class="text-red-500">✖</button>
        `;
            container.appendChild(div);
        }

        function removeTimeslot(button) {
            button.parentElement.remove();
        }

        function generateTimeslots() {
            const from = document.getElementById('from-time').value;
            const to = document.getElementById('to-time').value;
            const container = document.getElementById('timeslot-container');

            if (!from || !to) return alert('Unesite oba vremena.');

            const [fromHours, fromMinutes] = from.split(':').map(Number);
            const [toHours, toMinutes] = to.split(':').map(Number);

            let start = new Date();
            start.setHours(fromHours, fromMinutes, 0, 0);

            const end = new Date();
            end.setHours(toHours, toMinutes, 0, 0);

            if (start >= end) return alert('Vrijeme "od" mora biti prije vremena "do".');

            container.innerHTML = ''; // Clear previous timeslots

            while (start <= end) {
                const hh = String(start.getHours()).padStart(2, '0');
                const mm = String(start.getMinutes()).padStart(2, '0');
                addTimeslot(`${hh}:${mm}`);
                start.setMinutes(start.getMinutes() + 30);
            }
        }

        function removeTimeslot(button) {
            button.parentElement.remove();
        }


        function toggleEdit(dayId) {
            const form = document.getElementById(`edit-form-${dayId}`);
            form.classList.toggle('hidden');
        }

        function addEditTimeslot(dayId) {
            const container = document.getElementById(`timeslot-edit-container-${dayId}`);
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 mb-2';
            div.innerHTML = `
            <input type="hidden" name="timeslots_ids[]" value="new">
            <input type="time" name="timeslots_values[]" class="border p-1 text-sm rounded w-32" required>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-lg">✖</button>
        `;
            container.appendChild(div);
        }



        function toggleEdit(dayId) {
            const form = document.getElementById(`edit-form-${dayId}`);
            const isHidden = form.classList.contains('hidden');

            if (isHidden) {
                form.classList.remove('hidden', 'fade-scale-leave', 'fade-scale-leave-active');
                form.classList.add('fade-scale-enter');
                setTimeout(() => {
                    form.classList.add('fade-scale-enter-active');
                }, 10);
            } else {
                form.classList.remove('fade-scale-enter', 'fade-scale-enter-active');
                form.classList.add('fade-scale-leave');
                setTimeout(() => {
                    form.classList.add('fade-scale-leave-active');
                    setTimeout(() => {
                        form.classList.add('hidden');
                        form.classList.remove('fade-scale-leave', 'fade-scale-leave-active');
                    }, 150);
                }, 10);
            }
        }


        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
            notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
        ${message}
    `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-full', 'transition', 'duration-300');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showNotification("{{ session('success') }}", 'success');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showNotification("{{ session('error') }}", 'error');
            });
        </script>
    @endif
@endsection
