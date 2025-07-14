<h2>Nova rezervacija</h2>

<p><strong>Lokacija:</strong> {{ $data['location'] }}</p>
<p><strong>Datum:</strong> {{ \Carbon\Carbon::parse($data['date'])->translatedFormat('d.m.Y (l)') }}</p>
<p><strong>Vrijeme:</strong> {{ \Carbon\Carbon::parse($data['time'])->format('H:i') }}</p>

<hr>

<p><strong>Ime i prezime:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>

@if(!empty($data['message']))
    <p><strong>Poruka:</strong></p>
    <p>{{ $data['message'] }}</p>
@endif
