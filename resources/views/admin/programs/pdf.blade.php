<!DOCTYPE html>
<html>
<head>
<style>
@page { size: landscape; }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>{{ $program->name }} Details</h2>
<p>Lokasi : {{ $program->location }}</p>
<p>Tarikh : {{ $program->date }}</p>
<p>Deskripsi : {{ $program->description }}</p>
@if ($participants->count() > 0)
    <h2>Senarai Peserta</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Kad Pengenalan</th>
            <th>No. Phone</th>
            <th>Organization</th>
            <th>Address</th>
        </tr>
        @foreach ($participants as $participant)
        <tr>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->ic }}</td>
            <td>{{ $participant->phone }}</td>
            <td>{{ $participant->organization }}</td>
            <td>{{ $participant->address }}</td>
        </tr>
        @endforeach
    </table>
@else
    <span>No Participant Found.</span>
@endif
@if ($participantCount->count() > 0)
    <h2>Senarai Hadir</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Kad Pengenalan</th>
            <th>No. Phone</th>
            <th>Organization</th>
            <th>Address</th>
        </tr>
        @foreach ($participantCount as $participant)
        <tr>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->ic }}</td>
            <td>{{ $participant->phone }}</td>
            <td>{{ $participant->organization }}</td>
            <td>{{ $participant->address }}</td>
        </tr>
        @endforeach
    </table>
@else
    <span>No Participant Found.</span>
@endif

@if ($guests->count() > 0)
    <h2>Senarai Tetamu</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Phone</th>
            <!-- Add other guest fields as needed -->
        </tr>
        @foreach ($guests as $guest)
            <tr>
                <td>{{ $guest->name }}</td>
                <td>{{ $guest->email }}</td>
                <td>{{ $guest->phone }}</td>
                <!-- Add other guest fields as needed -->
            </tr>
        @endforeach
    </table>
@else
    <span>No Guests Found.</span>
@endif

</body>
</html>
