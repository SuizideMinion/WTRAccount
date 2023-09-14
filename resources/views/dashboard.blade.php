@extends('layouts.app')

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

    @can('dashboard.see.Times')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Letzte 50 Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastWorkings as $last)
                        <tr onclick="location.href='{{ route('request.show', $last->id) }}'">
                            <th>{{ $last->user->name }}</th>
                            <th>{{ date("H:i:s",$last->stamped + strtotime("1970/1/1")) }}</th>
                            <td>{{ date("H:i:s",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td>{{ date("H:i:s",$last->time_worked + strtotime("1970/1/1")) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan

@endsection

