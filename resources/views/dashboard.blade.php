@extends('layouts.app')
@section('styles')
@endsection

@section('module')

    <div class="col-xxl-12 col-xl-12">

        <div class="card info-card customers-card">

            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Willkommen in der WTRegenbogen Verwaltung</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6>Zugriffsrechte</h6>
                        <span class="text-muted small pt-2 ps-1">bitte bei Daniel Helmbrecht erfragen!</span>

                    </div>
                </div>

                @can('show.timemanagment')

                    <a href="/timemanagment">zum Stempeln</a>

                @endcan

            </div>
        </div>

    </div>

    @can('timeChanceAccept')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Änderungswünsche</h5>

                <!-- Dark Table -->
                <table class="table datatable datatable-table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requestChance as $last)
                        <tr onclick="location.href='{{ route('request.show', $last->time_id) }}'">
                            <th>{{ $last->user->name }}</th>
                            <th>{{ date("d.m H:i",$last->stamped + strtotime("1970/1/1")) }}</th>
                            <td>{{ date("d.m H:i",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td>{{ getZeit($last->stamped_out - $last->stamped) }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan

    @can('dashboard.see.Times')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Letzte Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table id="table" class="table datatable datatable-table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                        <th>*</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastWorkings as $last)
                        <tr data-id="{{ $last->id }}">
                            <th>{{ $last->user->name }}</th>
                            <td data-sort="{{ $last->stamped }}">{{ date("d.m H:i",$last->stamped + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->stamped_out }}">{{ date("d.m H:i",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->time_worked }}">{{ getZeit($last->time_worked) }}</td>
                            <td>
                                <button type="button" class="btn btn-danger delete-button">Löschen</button>
                                <button onclick="location.href='{{ route('request.show', $last->id) }}'" type="button" class="btn btn-danger">Editieren</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan

@endsection

@section('scripts')
    <!-- jQuery UI -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Datatables Js-->
    <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialisieren Sie DataTables
            var table = $('#table').DataTable({
                pageLength : 25,
                lengthMenu: [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                order: [[1, 'desc']]
            });

            // Verwenden Sie Event-Delegation für das "Löschen"-Button-Event
            $('#table tbody').on('click', '.delete-button', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var url = '{{ route("timemanagment.destroy", ":id") }}'.replace(':id', id);

                // if (confirm('Sind Sie sicher, dass Sie diesen Eintrag löschen möchten?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Zeile aus der DataTable entfernen
                            table.row(row).remove().draw();
                        },
                        error: function(xhr) {
                            alert('Ein Fehler ist aufgetreten! Bitte versuchen Sie es erneut.');
                        }
                    });
                // }
            });
        });
    </script>
@endsection
