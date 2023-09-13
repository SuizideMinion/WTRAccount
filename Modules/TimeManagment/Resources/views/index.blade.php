@extends('timemanagment::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitarbeiter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Stempeln</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.timemanagment')
        @if(!$activeTime)
            <form method="POST" action="{{ route('timemanagment.store') }}">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2 mt-3">
                            <input type="hidden" name="stamped_in" value="1">
                            <button class="btn btn-primary" type="submit">Einstempeln</button>
                        </div>
                    </div>
                </div>

            </form>
        @else

            <form method="POST" action="{{ route('timemanagment.store') }}">
                @csrf
                <h5 class="card-title">Eingestempelt um {{ date("H:i:s",$activeTime->stamped + strtotime("1970/1/1")) }}</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2 mt-3">
                            <input type="hidden" name="stamped_in" value="0">
                            <button class="btn btn-primary" type="submit">Ausstempeln</button>
                        </div>
                    </div>
                </div>

            </form>
        @endif


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Letzte 20 Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastWorkings as $last)
                        <tr>
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
