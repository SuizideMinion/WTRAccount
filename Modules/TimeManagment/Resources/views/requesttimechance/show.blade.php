@extends('timemanagment::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitarbeiter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Zeitänderung</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Zeiterfassung vom {{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}</h5>

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
                <tr>
                    <form method="post" action="{{ route('request.update', $time->id)}}">
                        @csrf
                        @method('PUT')

                        <th>{{ $time->user->name }}</th>
                        <td>{{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}
                            <input type="hidden" name="stamped_date"
                                   value="{{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}">
                            <input type="time" name="stamped"
                                   value="{{ date("H:i:s",$time->stamped + strtotime("1970/1/1")) }}">
                        </td>
                        <td>{{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}
                            <input type="hidden" name="stamped_out_date"
                                   value="{{ date("d.m.Y",$time->stamped_out + strtotime("1970/1/1")) }}">
                            <input type="time" name="stamped_out"
                                   value="{{ date("H:i:s",$time->stamped_out + strtotime("1970/1/1")) }}">
                        </td>
                        <td>{{ date("H:i:s",$time->time_worked + strtotime("1970/1/1")) }}</td>
                        <td>
                            <input type="hidden" name="user_id" value="{{ $time->user_id }}">
                            <button type="submit" class="btn btn-primary">Senden</button>
                        </td>
                    </form>
                </tr>
                </tbody>
            </table>

            @can('timeChanceAccept')
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
                    @foreach($timeChances as $timeC)
                        <form method="post" action="{{ route('request.store', $timeC->id)}}">
                            @csrf
                            <tr>
                                <th>{{ $time->user->name }}</th>
                                <td>{{ date("d.m.Y",$timeC->stamped + strtotime("1970/1/1")) }}
                                    <input type="hidden" name="stamped" value="{{ $timeC->stamped }}">
                                    {{ date("H:i:s",$timeC->stamped + strtotime("1970/1/1")) }}
                                </td>
                                <td>{{ date("d.m.Y",$timeC->stamped + strtotime("1970/1/1")) }}
                                    <input type="hidden" name="stamped_out" value="{{$timeC->stamped_out}}">
                                    {{ date("H:i:s",$timeC->stamped_out + strtotime("1970/1/1")) }}
                                </td>
                                <td>{{ date("H:i:s",$timeC->stamped_out - $timeC->stamped + strtotime("1970/1/1")) }}</td>
                                <td>
                                    <input type="hidden" name="user_id" value="{{ $timeC->user_id }}">
                                    <input type="hidden" name="time_id" value="{{ $timeC->time_id }}">
                                    <button type="submit" class="btn btn-primary">Senden</button>
                                </td>
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
            @endcan

        </div>
    </div>

@endsection
