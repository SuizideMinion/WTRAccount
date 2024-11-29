@extends('layouts.main')

@section('styles')

@endsection

@section('module')
    <div class="container">
        <h2>Time Tracking</h2>

        <!-- Conditionally show Clock In or Clock Out button -->
        @if($isClockedIn)
            <button id="clockOutBtn">Clock Out</button>
        @else
            <button id="clockInBtn">Clock In</button>
        @endif
        <button type="button" class="btn btn-warning" id="pauseButton">Pause</button>
        <button type="button" class="btn btn-success" id="resumeButton" style="display: none;">Resume</button>

        <h3>Request Leave</h3>
        <form id="leaveForm">
            <label>Type:</label>
            <select name="type">
                <option value="vacation">Vacation</option>
                <option value="sick">Sick</option>
            </select>
            <label>Start Date:</label>
            <input type="date" name="start_date">
            <label>End Date:</label>
            <input type="date" name="end_date">
            <button type="submit">Request Leave</button>
        </form>

        <h3>Time Entries</h3>
        <table id="timeEntriesTable">
            <thead>
            <tr>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Total Duration</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($timeEntries as $entry)
                <tr>
                    <td>{{ $entry->clock_in }}</td>
                    <td>{{ $entry->clock_out ?? 'N/A' }}</td>
                    <td>{{ $entry->total_duration ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-danger delete-entry" data-id="{{ $entry->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function() {
            const table = $('#timeEntriesTable').DataTable();

            document.getElementById('clockInBtn')?.addEventListener('click', () => {
                fetch('/clock-in', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            // Replace Clock In button with Clock Out button
                            document.getElementById('clockInBtn').style.display = 'none';
                            const clockOutBtn = document.createElement('button');
                            clockOutBtn.id = 'clockOutBtn';
                            clockOutBtn.textContent = 'Clock Out';
                            document.querySelector('.container').prepend(clockOutBtn);
                            clockOutBtn.addEventListener('click', clockOut);
                        }
                    });
            });

            function clockOut() {
                fetch('/clock-out', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);

                            // Parse dates using JavaScript Date object
                            const clockIn = new Date(data.entry.clock_in);
                            const clockOut = new Date(data.entry.clock_out);

                            // Calculate duration in milliseconds, then convert to hours, minutes, and seconds
                            const durationMs = clockOut - clockIn;
                            const hours = Math.floor(durationMs / (1000 * 60 * 60));
                            const minutes = Math.floor((durationMs % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((durationMs % (1000 * 60)) / 1000);

                            // Format duration as "HH:MM:SS"
                            const duration = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                            // Add new row to DataTable
                            table.row.add([
                                clockIn.toISOString().slice(0, 19).replace("T", " "),
                                clockOut.toISOString().slice(0, 19).replace("T", " "),
                                duration // Show duration as HH:MM:SS
                            ]).draw(false);

                            // Replace Clock Out button with Clock In button
                            document.getElementById('clockOutBtn').remove();
                            const clockInBtn = document.createElement('button');
                            clockInBtn.id = 'clockInBtn';
                            clockInBtn.textContent = 'Clock In';
                            document.querySelector('.container').prepend(clockInBtn);
                            clockInBtn.addEventListener('click', clockIn);
                        }
                    });
            }

            function clockIn() {
                fetch('/clock-in', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            document.getElementById('clockInBtn').style.display = 'none';
                            const clockOutBtn = document.createElement('button');
                            clockOutBtn.id = 'clockOutBtn';
                            clockOutBtn.textContent = 'Clock Out';
                            document.querySelector('.container').prepend(clockOutBtn);
                            clockOutBtn.addEventListener('click', clockOut);
                        }
                    });
            }
            $('#pauseButton').on('click', function() {
                $.ajax({
                    url: '/api/user/pause',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        alert(data.message);
                        $('#pauseButton').hide();
                        $('#resumeButton').show();
                    },
                    error: function(err) {
                        alert(err.responseJSON.message);
                    }
                });
            });

            $('#resumeButton').on('click', function() {
                $.ajax({
                    url: '/api/user/resume',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        alert(data.message);
                        $('#resumeButton').hide();
                        $('#pauseButton').show();
                    },
                    error: function(err) {
                        alert(err.responseJSON.message);
                    }
                });
            });

            document.getElementById('clockOutBtn')?.addEventListener('click', clockOut);
        });
    </script>
@endsection
