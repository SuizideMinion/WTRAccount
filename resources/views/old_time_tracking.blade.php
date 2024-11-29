@extends('layouts.main')

@section('styles')

@endsection

@section('module')
    <div class="container mt-5">
        <h1>User Time Tracking</h1>

        <form id="userForm" class="mb-4">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="form-group">
                <label for="month">Month:</label>
                <input type="number" class="form-control" id="month" name="month" min="1" max="12" required>
            </div>
            <div class="form-group">
                <label for="year">Year:</label>
                <input type="number" class="form-control" id="year" name="year" min="2000" max="{{ date('Y') }}" required>
            </div>
            <button type="button" class="btn btn-primary" id="getSummary">Get Summary</button>
            <button type="button" class="btn btn-secondary" id="getEntries">Get Entries</button>
        </form>

        <h2>Summary for <span id="summaryDate"></span></h2>
        <p id="summaryTotalHours"></p>
        <p id="summaryTotalDays"></p>

        <h2>Time Entries</h2>
        <table id="entriesTable" class="table table-striped">
            <thead>
            <tr>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="entriesBody"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#entriesTable').DataTable();

            $('#getSummary').on('click', function() {
                const userId = $('#user_id').val();
                const month = $('#month').val();
                const year = $('#year').val();

                $.ajax({
                    url: '/api/user/' + userId + '/summary?month=' + month + '&year=' + year,
                    method: 'GET',
                    success: function(data) {
                        $('#summaryDate').text(month + '/' + year);
                        $('#summaryTotalHours').text('Total Hours: ' + data.total_hours);
                        $('#summaryTotalDays').text('Total Days Worked: ' + data.total_days);
                    },
                    error: function(err) {
                        alert('Error fetching summary!');
                    }
                });
            });

            $('#getEntries').on('click', function() {
                const userId = $('#user_id').val();
                const month = $('#month').val();
                const year = $('#year').val();

                $.ajax({
                    url: '/api/user/' + userId + '/entries?month=' + month + '&year=' + year,
                    method: 'GET',
                    success: function(data) {
                        $('#entriesBody').empty();
                        data.forEach(entry => {
                            $('#entriesBody').append(`
                            <tr>
                                <td>${entry.clock_in}</td>
                                <td>${entry.clock_out || 'N/A'}</td>
                                <td>${entry.duration}</td>
                                <td><button class="btn btn-danger delete-entry" data-id="${entry.id}">Delete</button></td>
                            </tr>
                        `);
                        });
                    },
                    error: function(err) {
                        alert('Error fetching entries!');
                    }
                });
            });

            $(document).on('click', '.delete-entry', function() {
                const entryId = $(this).data('id');

                $.ajax({
                    url: '/api/entries/' + entryId,
                    method: 'DELETE',
                    success: function() {
                        alert('Entry deleted successfully!');
                        location.reload();
                    },
                    error: function(err) {
                        alert('Error deleting entry!');
                    }
                });
            });
        });
    </script>
@endsection
