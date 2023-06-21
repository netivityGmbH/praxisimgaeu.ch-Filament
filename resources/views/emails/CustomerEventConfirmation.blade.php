<h1>Bestellbestätigung Sensopro Termine</h1>
<p>Liebe Kund*in</p>

<p>Es wurden gerade folgende Termine für sie in unserem Kalender eingetragen. 🗓</p>

<table>
    <tr>
        <th>Termin</th>
        <th>Datum</th>
        <th>Start</th>
        <th>Ende</th>
    </tr>

    @foreach ($events as $event)
    <tr>
        <td>{{$loop->index + 1}}</td>
        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event['start'])->format('d.m.Y')}}</td>
        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event['start'])->format('H:i')}}</td>
        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event['end'])->format('H:i')}}</td>
    </tr>
    @endforeach
</table>

<p>Sie haben {{ $subscription->events_count }} von {{ $subscription->total_events }} Terminen eingelöst.</p>

<p>
    Wir wünschen Ihnen viel Spass & Erfolg auf diesem sensationellen Trainingsgerät
    <a href="https://sensopro.swiss/">SENSOPRO</a>
</p>

<p>
    Für alle weiteren Fragen stehen wir Ihnen gern jederzeit zur Verfügung.
</p>

<p>
    Praxis im Gäu GmbH<br />
    4624 Härkingen
</p>