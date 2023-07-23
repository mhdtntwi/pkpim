<p>Program Information</p>
<table>
    <thead>
        <tr>
            <th>Program Name</th>
            <th>Location</th>
            <th>Descripttion</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $program->name }}</td>
            <td>{{ $program->location }}</td>
            <td>{{ $program->description }}</td>
            <td>{{ $program->date }}</td>
        </tr>
    </tbody>
</table>

<br>

@if ($guests->count() > 0)
    <p>Guests ({{ $guests->count() }})</p>
    <table>
        <!-- Table header and body for guests -->
        <thead>
            <tr>
                <th>Guest Name</th>
                <th>Email</th>
                <th>Phone</th>
                <!-- Add other guest fields as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($guests as $guest)
                <tr>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->phone }}</td>
                    <!-- Add other guest fields as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if ($participants->count() > 0)
    <p>Semua Peserta ({{ $participants->count() }})</p>
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
    <p>Peserta Hadir ({{ $participantCount->count() }})</p>
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
