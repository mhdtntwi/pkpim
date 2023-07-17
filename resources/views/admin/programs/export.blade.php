<p>Informasi Program</p>
<table>
    <thead>
        <tr>
            <th>Program Name</th>
            <th>Location</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $program->name }}</td>
            <td>{{ $program->location }}</td>
            <td>{{ $program->date }}</td>
        </tr>
    </tbody>
</table>

<br>

@if ($participants->count() > 0)
    <p>Semua Peserta ({{ $totalParticipantsCount }})</p>
    <table>
        <thead>
            <tr>
                <th>Participant Name</th>
                <th>Email</th>
                <th>IC</th>
                <th>Phone</th>
                <th>Organization</th>
                <th>address</th>
                <th>Notes</th>
                <!-- Add other participant fields as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($participants as $participant)
                <tr>
                    <td>{{ $participant->name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->ic }}</td>
                    <td>{{ $participant->phone }}</td>
                    <td>{{ $participant->organization }}</td>
                    <td>{{ $participant->address }}</td>
                    <td>{{ $participant->notes }}</td>
                    <!-- Add other participant fields as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No participants found for this program.</p>
@endif

@if ($participantCount->count() > 0)
    <p>Peserta Hadir ({{ $submittedParticipantsCount }})</p>
    <table>
        <thead>
            <tr>
                <th>Participant Name</th>
                <th>Email</th>
                <th>IC</th>
                <th>Phone</th>
                <th>Organization</th>
                <th>address</th>
                <th>Notes</th>
                <!-- Add other participant fields as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($participantCount as $participant)
                <tr>
                    <td>{{ $participant->name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->ic }}</td>
                    <td>{{ $participant->phone }}</td>
                    <td>{{ $participant->organization }}</td>
                    <td>{{ $participant->address }}</td>
                    <td>{{ $participant->notes }}</td>
                    <!-- Add other participant fields as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
