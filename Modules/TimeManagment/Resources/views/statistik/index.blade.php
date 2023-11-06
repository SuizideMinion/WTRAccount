@extends('timemanagment::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitarbeiter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Statistik</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Zeiterfassung {{ ( isset($id) ? 'von '. $user->name:'' ) }}</h5>
                    Diesen Monat
                    gearbeitet: {{ getZeit($user->getWorktime(strtotime(date('Y-m-01')), strtotime(date('Y-m-t')) + 24 * 60 * 60)) }}
                    <br>
                    Letzten Monat
                    gearbeitet: {{ getZeit($user->getWorktime(strtotime(date('Y-m-01') . '- 1 month'), strtotime(date('Y-m-t') . '- 1 month') + 24 * 60 * 60)) }}
                    <br>
                    Vorletzten Monat
                    gearbeitet: {{ getZeit($user->getWorktime(strtotime(date('Y-m-01') . '- 2 month'), strtotime(date('Y-m-t') . '- 2 month') + 24 * 60 * 60)) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jahresstatistik</h5>
                    Urlaubstage genommen: {{ $Times->where('status', '3')->count() }}
                    <br>
                    Krankentage: {{ $Times->where('status', '4')->count() }}
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            @for($i = 0; $i <= $Times->count(); $i++)
                {{--                {{ strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00') }} -> {{ strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 24:00:00') }}--}}
                <div class="d-flex">
                    <div>{{ date('d.m.Y', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')) }}</div>
                    @can('timetracking_setany')
                        <div style="margin-left: auto">

                            <form class="d-flex" method="POST" action="{{ route('statistik.store') }}">
                                @csrf
                                <input type="hidden" name="day"
                                       value="{{strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')}}">
                                <input type="hidden" name="user_id" value="{{($id ?? auth()->user()->id)}}">
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        name="status" style="height: 24px;font-size: 10px;">
                                    <option selected>Status</option>
                                    <option value="2">Feiertag</option>
                                    <option value="3">Urlaub</option>
                                    <option value="4">Krank</option>
                                </select>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        name="time" style="height: 24px;font-size: 10px;">
                                    <option selected>Zeit</option>
                                    <option value="18000">5std</option>
                                    <option value="28800">8std</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="height: 24px;font-size: 10px;">Send
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="progress m-1">
                    @set($count, 0)
                    @set($last, 0)
                    @foreach($Times->where('stamped', '<', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 24:00:00') - 3600)->where('stamped_out', '>', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00') + 3600) as $Time)
                        {{--                        @php isset($count) ? ($count == 6 ? $count = 0 : $count++):$count = 0 @endphp--}}
                        @php

                            if(date('d.m.Y',$Time->stamped) == '23.10.2023') dd($Time);

                        @endphp
                        @if($Time->status == 2)
                            <div class="progress-bar progress-bar-striped bg-info"
                                 role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%"
                                 aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                {{ 'FEIERTAG: '. getZeit($Time->time_worked) }}
                            </div>
                        @elseif($Time->status == 3)
                            <div class="progress-bar progress-bar-striped bg-warning"
                                 role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%"
                                 aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                {{ 'URLAUB: '. getZeit($Time->time_worked) }}
                            </div>
                        @elseif($Time->status == 4)
                            <div class="progress-bar progress-bar-striped bg-danger"
                                 role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%"
                                 aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                {{ 'KRANK: '. getZeit($Time->time_worked) }}
                            </div>
                        @else
                            {{--                            // TODO:: rechne die zwischenzeiten aus und lasse sie frei für bessere ansicht --}}
                            {{--                            @if($count == 0)--}}
                            {{--                                <div class="progress-bar progress-bar-striped bg-light"--}}
                            {{--                                     role="progressbar"--}}
                            {{--                                     style="color: #1a1d20;width: {{ (( $Time->stamped - strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00') - 3600) / 86400) * 100 }}%"--}}
                            {{--                                     aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">--}}
                            {{--                                    {{date('H:i', strtotime(date('Y-m-d', time() - 3600 - ( 86400 * $i )) . ' 00:00:00')) }}-{{date('H:i', $Time->stamped - 3600)}}--}}
                            {{--                                    --}}{{--                                    {{ getZeit((( $Time->stamped - strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')) - 3600 ))  }}--}}
                            {{--                                    --}}{{--                                {{ getZeit($Time->time_worked) }} {{ ( $Time->status != 1 ? ($Time->status == 2 ? 'Feiertag':($Time->status == 3 ? 'Urlaub':($Time->status == 4 ? 'Krank':'Nicht Gesetzt'))):'') }}--}}
                            {{--                                </div>--}}
                            {{--                                @set($count, $count + 1)--}}
                            {{--                            @endif--}}
                            <div
                                title="{{date('H:i', $Time->stamped - 3600)}} - {{date('H:i', $Time->stamped_out - 3600)}}"
                                class="progress-bar progress-bar-striped bg-primary"
                                role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%"
                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                {{ getZeit($Time->time_worked) }}
                            </div>
                            <div class="progress-bar progress-bar-striped bg-light"
                                 role="progressbar" style="width: 1%"
                                 aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            </div>
                            @set($last, $last + $Time->time_worked)
                        @endif
                    @endforeach
                </div>
            @endfor

        </div>
    </div>

@endsection
