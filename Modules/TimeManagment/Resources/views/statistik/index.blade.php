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
    @php
        if (!function_exists('monthBoundary')) {
            function monthBoundary($monthsAgo = 0, $type = 'start') {
                $format = $type === 'end' ? 'Y-m-t' : 'Y-m-01';
                return strtotime(date($format) . ' - ' . $monthsAgo . ' month');
            }
        }
    @endphp

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Zeiterfassung {{ isset($id) ? 'von '. $user->name : '' }}</h5>
                    @foreach([0 => 'Diesen Monat', 1 => 'Letzten Monat', 2 => 'Vorletzten Monat'] as $offset => $label)
                        {{ $label }} gearbeitet: {{ getZeit($user->getWorktime(monthBoundary($offset), monthBoundary($offset, 'end') + 24 * 60 * 60)) }}<br>
                    @endforeach
                    <p id="totalOvertime">Gesamte Überstunden: <span>0:00</span></p>
                    (das aktuelle Monat wird nicht eingerechnet)
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jahresstatistik</h5>
                    Urlaubstage genommen: {{ $Times->where('status', '3')->count() }} von {{ $userDatasUrlaubstage }}<br>
                    Krankentage: {{ $Times->where('status', '4')->count() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-dark table-sm" id="timeTable">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Stunden Gearbeitet</th>
                    <th scope="col">Sollstunden</th>
                    <th scope="col">Überstunden</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < 99; $i++)
                    @php
                        $workTime = $Times->where('stamped_out', '<', monthBoundary($i, 'end'))
                                          ->where('stamped', '>', monthBoundary($i) - 4000)
                                          ->sum('time_worked');
                        $sollstunden = $user->userData()['sollstunden.' . date('m.Y', monthBoundary($i))] ?? ($user->userData()['sollstunden'] ?? 160);
                    @endphp

                    @if($workTime == 0) @break @endif

                    <tr>
                        <th scope="row">{{ date('m.Y', monthBoundary($i)) }}</th>
                        <td>{{ getZeit($workTime) }}</td>
                        <td>{{ $sollstunden }}</td>
                        <td>{{ getZeit($workTime - $sollstunden * 60 * 60) }}</td>
                    </tr>
                @endfor
                @if(isset($user->userData()['ueberStunden']))
                    <tr>
                        <td></td>
                        <td>Übertrag:</td>
                        <td></td>
                        <td>{{ getZeit($user->userData()['ueberStunden']) }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @php

                $cssClasses = [
                0 => 'bg-info',
                1 => 'bg-info',
                2 => 'bg-info',
                3 => 'bg-warning',
                4 => 'bg-danger',
                ];

                $labels = [
                0 => '',
                1 => '',
                2 => 'FEIERTAG',
                3 => 'URLAUB',
                4 => 'KRANK',
                ];
            @endphp

            @for($i = 0; $i <= $Times->count(); $i++)
                <div class="d-flex">
                    <div>{{ date('d.m.Y', strtotime("-{$i} days")) }}</div>
                    @can('timetracking_setany')
                        <div style="margin-left: auto">
                            <form class="d-flex" method="POST" action="{{ route('statistik.store') }}">
                                @csrf
                                <input type="hidden" name="day" value="{{ strtotime("-{$i} days 00:00:00") }}">
                                <input type="hidden" name="user_id" value="{{($id ?? auth()->user()->id)}}">
                                <select class="form-select form-select-sm" name="status">
                                    <option selected>Status</option>
                                    <option value="2">Feiertag</option>
                                    <option value="3">Urlaub</option>
                                    <option value="4">Krank</option>
                                </select>
                                <select class="form-select form-select-sm" name="time">
                                    <option selected>Zeit</option>
                                    <option value="18000">5std</option>
                                    <option value="28800">8std</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Send</button>
                            </form>
                        </div>
                    @endcan
                </div>

                <div class="progress m-1">
                    @foreach($Times->where('stamped', '<', strtotime("-{$i} days 24:00:00"))
                                    ->where('stamped_out', '>', strtotime("-{$i} days 00:00:00")) as $Time)
                        <div class="progress-bar progress-bar-striped {{ $cssClasses[$Time->status] ?? 'bg-primary' }}"
                             role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%"
                             aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"
                             title="{{ $labels[$Time->status] ?? date('H:i', $Time->stamped) . ' - ' . date('H:i', $Time->stamped_out) }}">
                            {{ ($labels[$Time->status] ?? '') . ($labels[$Time->status] ? ': ' : '') . getZeit($Time->time_worked) }}
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>

    <script>
        function calculateTotalOvertime() {
            const rows = document.querySelectorAll('#timeTable tbody tr');
            let totalMinutes = 0;

            rows.forEach((row, index) => {
                if (index === 0) return;

                const overtimeText = row.cells[3].textContent.trim();
                const isNegative = overtimeText.startsWith('-');
                const [hours, minutes] = overtimeText.replace('-', '').split(':').map(Number);
                const totalOvertimeMinutes = (hours * 60) + minutes;

                totalMinutes += isNegative ? -totalOvertimeMinutes : totalOvertimeMinutes;
            });

            const finalHours = Math.floor(Math.abs(totalMinutes) / 60);
            const finalMinutes = Math.abs(totalMinutes) % 60;
            const formattedTime = `${totalMinutes < 0 ? '-' : ''}${finalHours}:${String(finalMinutes).padStart(2, '0')}`;

            document.getElementById('totalOvertime').querySelector('span').textContent = formattedTime;
        }

        calculateTotalOvertime();
    </script>
@endsection
