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
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <form method="post" action="{{ route('request.update', $time->id)}}">
                    <tr>
                        @csrf
                        @method('PUT')
                        <td>von</td>
                        <td>
{{--                            {{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}--}}
                            <input type="text" name="stamped_date"
                                   value="{{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}">
                            <input type="time" name="stamped"
                                   value="{{ date("H:i:s",$time->stamped + strtotime("1970/1/1")) }}">
                        </td>
                    </tr>
                    <tr>
                        <td>bis</td>
                        <td>
{{--                            {{ date("d.m.Y",$time->stamped_out + strtotime("1970/1/1")) }}--}}
                            <input type="text" name="stamped_out_date"
                                   value="{{ date("d.m.Y",$time->stamped_out + strtotime("1970/1/1")) }}">
                            <input type="time" name="stamped_out"
                                   value="{{ date("H:i:s",$time->stamped_out + strtotime("1970/1/1")) }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Stunden</td>
                        <td>{{ getZeit($time->time_worked) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="user_id" value="{{ $time->user_id }}">
                            <button type="submit" class="btn btn-primary">Senden</button>
                        </td>
                    </tr>
                </form>
                </tbody>
            </table>

            @if( $timeChances->isNotEmpty() )
                <h5 class="card-title">Zeiterfassung vom {{ date("d.m.Y",$time->stamped + strtotime("1970/1/1")) }}</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timeChances as $timeC)
                        <form method="post" action="{{ route('request.store', $timeC->id)}}">
                            <tr>
                                {{--                                <th>{{ $time->user->name }}</th>--}}
                                <td>{{ date("d.m",$timeC->stamped + strtotime("1970/1/1")) }}
                                    <input type="hidden" name="stamped" value="{{ $timeC->stamped }}">
                                    {{ date("H:i",$timeC->stamped + strtotime("1970/1/1")) }}
                                </td>
                                <td>{{ date("d.m",$timeC->stamped_out + strtotime("1970/1/1")) }}
                                    <input type="hidden" name="stamped_out" value="{{$timeC->stamped_out}}">
                                    {{ date("H:i",$timeC->stamped_out + strtotime("1970/1/1")) }}
                                </td>
                                <td>{{ getZeit($timeC->stamped_out - $timeC->stamped) }}</td>
                                <td>
                                    @can('timeChanceAccept')
                                        <input type="hidden" name="user_id" value="{{ $timeC->user_id }}">
                                        <input type="hidden" name="time_id" value="{{ $timeC->time_id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Senden</button>
                                    @endcan
                                </td>
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
