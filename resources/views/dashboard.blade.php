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
                <form action="{{ route('holiday.store') }}" method="post">
                    @csrf
                    <div class="form-row align-items-center d-flex">
                        <label for="date" class="col-form-label w-100">Feiertag für alle Eintragen:</label>
                        <input type="date" name="date" class="form-control"
                               value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
        @if($requestChance)
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
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requestChance as $last)
                            <tr onclick="location.href='{{ route('request.show', $last->time_id) }}'">
                                <th>{{ $last->user->name }}</th>
                                <th>{{ date("d.m H:i",$last->stamped + strtotime("1970/1/1")) }}</th>
                                <td>{{ date("d.m H:i",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                                <td>{{ getZeit($last->stamped_out - $last->stamped) }}</td>
                                <td>{{ $labels[$last->time->status] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- End Dark Table -->

                </div>
            </div>
        @endif
    @endcan

    @can('dashboard.see.Times')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Letzte Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table id="table" class="table datatable datatable-table">
                    <thead>
                    <tr>
                        <th><input type="text" placeholder="Suche Name"/></th>
                        <th><input type="text" placeholder="Suche von"/></th>
                        <th><input type="text" placeholder="Suche bis"/></th>
                        <th><input type="text" placeholder="Suche Zeit"/></th>
                        <th><input type="text" placeholder="Suche Status"/></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastWorkings as $last)
                        <tr data-id="{{ $last->id }}">
                            <th>{{ $last->user->name }}</th>
                            <td data-sort="{{ $last->stamped }}">{{ date("d.m.y H:i", $last->stamped + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->stamped_out }}">{{ date("d.m.y H:i", $last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->time_worked }}">{{ getZeit($last->time_worked) }}</td>
                            <td>{{ $labels[$last->status] }}</td>
                            <td>
                                <button type="button" class="btn btn-danger delete-button">Löschen</button>
                                <button onclick="location.href='{{ route('request.show', $last->id) }}'" type="button"
                                        class="btn btn-warning">Editieren
                                </button>
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
        $(document).ready(function () {
            var table = $('#table').DataTable({
                autoWidth: false,
                paging: true,
                pageLength: 100,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                searching: true,
                ordering: true,
                order: [[1, 'desc']],
                info: true,
                responsive: true,
                language: {
                    search: "Suche:",
                    lengthMenu: "Zeige _MENU_ Einträge",
                    info: "Zeige Einträge _START_ bis _END_ von _TOTAL_",
                    paginate: {
                        first: "Erste",
                        last: "Letzte",
                        next: "Nächste",
                        previous: "Vorherige"
                    }
                }
            });

            // Erstellung der Spaltensuche
            $('#table thead tr:eq(1) th').each(function (i) {
                $('input', this).on('keyup change', function () {
                    if ($('#table').DataTable().column(i).search() !== this.value) {
                        $('#table').DataTable().column(i).search(this.value).draw();
                    }
                });
            });

            // Verwenden Sie Event-Delegation für das "Löschen"-Button-Event
            $('#table tbody').on('click', '.delete-button', function () {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var url = '{{ route("timemanagment.destroy", ":id") }}'.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Zeile aus der DataTable entfernen
                        table.row(row).remove().draw();
                    },
                    error: function (xhr) {
                        alert('Ein Fehler ist aufgetreten! Bitte versuchen Sie es erneut.');
                    }
                });
            });
        });
    </script>
@endsection
