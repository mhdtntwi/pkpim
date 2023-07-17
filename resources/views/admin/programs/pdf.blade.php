{{-- <h1>Program: {{ $program->name }}</h1>
<p>Location: {{ $program->location }}</p>
<p>Date: {{ $program->date }}</p>
<p>Description: {{ $program->description }}</p>

@if ($participants->count() > 0)
    <table>
        <thead>
            <tr>
                <th>
                    Nama
                </th>
                <th>
                    Email
                </th>
                <th>
                    No. Kad Pengenalan
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Organization
                </th>
                <th>
                    Address
                </th>
                <th>
                    Notes
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participants as $participant)
            <tr >
                <th>
                    {{ $participant->name }}
                </th>
                <td>
                    {{ $participant->email }}
                </td>
                <td>
                    {{ $participant->ic }}
                </td>
                <td>
                    {{ $participant->phone }}
                </td>
                <td>
                    {{ $participant->organization }}
                </td>
                <td>
                    {{ $participant->address }}
                </td>
                <td>
                    {{ $participant->notes }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No participants found for this program.</p>
@endif --}}

<!DOCTYPE html>
<html>
<head>
<style>
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
    <h2>Semua Peserta</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Kad Pengenalan</th>
            <th>No. Phone</th>
            <th>Organization</th>
            <th>Address</th>
            <th>Notes</th>
        </tr>
        @foreach ($participants as $participant)
        <tr>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->ic }}</td>
            <td>{{ $participant->phone }}</td>
            <td>{{ $participant->organization }}</td>
            <td>{{ $participant->address }}</td>
            <td>{{ $participant->notes }}</td>
        </tr>
        @endforeach
    </table>
@else
    <span>No Participant Found.</span>
@endif
@if ($participantCount->count() > 0)
    <h2>Peserta Hadir</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Kad Pengenalan</th>
            <th>No. Phone</th>
            <th>Organization</th>
            <th>Address</th>
            <th>Notes</th>
        </tr>
        @foreach ($participantCount as $participant)
        <tr>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->ic }}</td>
            <td>{{ $participant->phone }}</td>
            <td>{{ $participant->organization }}</td>
            <td>{{ $participant->address }}</td>
            <td>{{ $participant->notes }}</td>
        </tr>
        @endforeach
    </table>
@else
    <span>No Participant Found.</span>
@endif

</body>
</html>
