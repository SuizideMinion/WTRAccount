<!DOCTYPE html>
<html>
<head>
    <title>User Time Entries</title>
</head>
<body>
<h1>User {{ $userId }} has worked {{ $totalHours }} hours in March 2024</h1>
<h2>Time Entries:</h2>
<table>
    <thead>
    <tr>
        <th>Clock In</th>
        <th>Clock Out</th>
        <th>Duration</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($timeEntries as $entry)
        <tr>
            <td>{{ $entry['clock_in'] }}</td>
            <td>{{ $entry['clock_out'] ?? 'N/A' }}</td>
            <td>{{ $entry['duration'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
