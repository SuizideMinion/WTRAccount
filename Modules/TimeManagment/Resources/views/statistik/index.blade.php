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
                    <h5 class="card-title">Zeiterfassung {{ isset($id) ? 'von ' . $user->name : '' }}</h5>
                    Diesen Monat gearbeitet:
                    {{ getZeit($user->getWorktime(strtotime(date('Y-m-01')), strtotime(date('Y-m-t')) + 24 * 60 * 60)) }}<br>
                    Letzten Monat gearbeitet:
                    {{ getZeit($user->getWorktime(strtotime(date('Y-m-01') . ' -1 month'), strtotime(date('Y-m-t') . ' -1 month') + 24 * 60 * 60)) }}<br>
                    Vorletzten Monat gearbeitet:
                    {{ getZeit($user->getWorktime(strtotime(date('Y-m-01') . ' -2 month'), strtotime(date('Y-m-t') . ' -2 month') + 24 * 60 * 60)) }}<br>
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
                    <th scope="col">Datum</th>
                    <th scope="col">Stunden gearbeitet</th>
                    <th scope="col">Sollstunden</th>
                    <th scope="col">Überstunden</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < 99; $i++)
                    @php
                        $startOfMonth = strtotime(date('Y-m-01') . " -$i month");
                        $endOfMonth = strtotime(date('Y-m-t') . " -$i month") + 24 * 60 * 60;
                    @endphp

                    @if($Times->where('stamped_out', '<', $endOfMonth)->where('stamped', '>', $startOfMonth - 4000)->sum('time_worked') == 0)
                        @break
                    @endif

                    <tr>
                        <th scope="row">{{ date('m.Y', $startOfMonth) }}</th>
                        <td>
                            {{ getZeit($Times->where('stamped_out', '<', $endOfMonth)->where('stamped', '>', $startOfMonth - 4000)->sum('time_worked')) }}
                        </td>
                        <td>
                            {{ $userData['sollstunden.' . date('m.Y', $startOfMonth)] ?? ($userData['sollstunden'] ?? 'Fehler -> Code: SollstundenNachtragen') }}
                        </td>
                        <td>
                            {{
                                getZeit($Times->where('stamped_out', '<', $endOfMonth)
                                            ->where('stamped', '>', $startOfMonth - 4000)
                                            ->sum('time_worked')
                                          - ($userData['sollstunden.' . date('m.Y', $startOfMonth)]
                                            ?? ($userData['sollstunden'] ?? 0)) * 60 * 60)
                            }}
                        </td>
                    </tr>
                @endfor
                @isset($userData['ueberStunden'])
                    <tr>
                        <td></td>
                        <td>Übertrag:</td>
                        <td></td>
                        <td>{{ getZeit($userData['ueberStunden']) }}</td>
                    </tr>
                @endisset
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @for($i = 0; $i <= $Times->count(); $i++)
                @php
                    $startOfDay = strtotime(date('Y-m-d', time() - (86400 * $i)) . ' 00:00:00');
                    $endOfDay = strtotime(date('Y-m-d', time() - (86400 * $i)) . ' 24:00:00');
                @endphp
                <div class="d-flex">
                    <div>{{ date('d.m.Y', $startOfDay) }}</div>
                    @can('timetracking_setany')
                        <div style="margin-left: auto">
                            <form class="d-flex" method="POST" action="{{ route('statistik.store') }}">
                                @csrf
                                <input type="hidden" name="day" value="{{ $startOfDay }}">
                                <input type="hidden" name="user_id" value="{{ $id ?? auth()->user()->id }}">
                                <select class="form-select form-select-sm" name="status" style="height: 24px; font-size: 10px;">
                                    <option selected>Status</option>
                                    <option value="2">Feiertag</option>
                                    <option value="3">Urlaub</option>
                                    <option value="4">Krank</option>
                                </select>
                                <select class="form-select form-select-sm" name="time" style="height: 24px; font-size: 10px;">
                                    <option selected>Zeit</option>
                                    <option value="18000">5std</option>
                                    <option value="28800">8std</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm" style="height: 24px; font-size: 10px;">Send</button>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="progress m-1">
                    @foreach($Times->where('stamped', '<', $endOfDay - 3600)->where('stamped_out', '>', $startOfDay + 3600) as $Time)
                        @php
                            $statusClassMap = [
                                2 => 'bg-info',
                                3 => 'bg-warning',
                                4 => 'bg-danger',
                                'default' => 'bg-primary'
                            ];
                            $statusTextMap = [
                                2 => 'FEIERTAG',
                                3 => 'URLAUB',
                                4 => 'KRANK'
                            ];
                            $statusClass = $statusClassMap[$Time->status] ?? $statusClassMap['default'];
                            $statusText = $statusTextMap[$Time->status] ?? '';
                        @endphp

                        <div class="progress-bar progress-bar-striped {{ $statusClass }}" role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" title="{{ date('H:i', $Time->stamped - 3600) }} - {{ date('H:i', $Time->stamped_out - 3600) }}">
                            {{ $statusText ? $statusText . ': ' : '' }}{{ getZeit($Time->time_worked) }}
                        </div>
                        <div class="progress-bar progress-bar-striped bg-light" role="progressbar" style="width: 1%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calculateTotalOvertime() {
                const rows = document.querySelectorAll('#timeTable tbody tr');
                let totalMinutes = 0;

                rows.forEach((row, index) => {
                    if (index === 0) return; // Erste Zeile überspringen

                    const overtimeText = row.cells[3].textContent.trim();
                    if (!overtimeText) return; // Wenn kein Text vorhanden ist, überspringen

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
        });
    </script>
@endsection
