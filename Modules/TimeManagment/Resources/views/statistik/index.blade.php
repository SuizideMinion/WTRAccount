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
        function monthBoundary($monthsAgo = 0, $type = 'start') {
            $format = $type === 'end' ? 'Y-m-t' : 'Y-m-01';
            return strtotime(date($format) . ' - ' . $monthsAgo . ' month');
        }
    @endphp

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Zeiterfassung {{ isset($id) ? 'von '. $user->name : '' }}</h5>
                    @foreach([0 => 'Diesen Monat', 1 => 'Letzten Monat', 2 => 'Vorletzten Monat'] as $offset => $label)
                        @php
                            $start = monthBoundary($offset);
                            $end = monthBoundary($offset, 'end') + 24 * 60 * 60;
                            $arbeitZeit = $Times->where('stamped', '>=', $start)->where('stamped_out', '<', $end)->sum('time_worked');
                        @endphp
                        {{ $label }} gearbeitet: {{ getZeit($arbeitZeit) }}<br>
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
                    Urlaubstage genommen: {{ $Times->where('status', '3')->count() }} von {{ $userDatasUrlaubstage }}
                    <br>
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
                        $start = monthBoundary($i);
                        $end = monthBoundary($i, 'end') + 24 * 60 * 60;
                        $workTime = $Times->where('stamped', '>=', $start)
                                          ->where('stamped_out', '<', $end)
                                          ->sum('time_worked');
                        $sollstunden = $user->userData()['sollstunden.' . date('m.Y', $start)] ?? ($user->userData()['sollstunden'] ?? 160);
                    @endphp

                    @if($workTime == 0)
                        @break
                    @endif

                    <tr>
                        <th scope="row">{{ date('m.Y', $start) }}</th>
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
                $currentDate = new DateTime();
                $monthsData = [];

                // Setze das Datum auf den letzten Tag des aktuellen Monats, um die Rückwärtsberechnung zu erleichtern
                $currentDate->setDate((int) $currentDate->format('Y'), (int) $currentDate->format('m'), 1);

                for ($i = 0; $i < 12; $i++) {
                    // In jedem Schleifenlauf gehen wir einen Monat zurück
                    $adjustedDate = (clone $currentDate)->modify('-' . $i . ' months');
                    $monthNameYear = $adjustedDate->format('M y');

                    $startOfMonth = (clone $adjustedDate)->modify('first day of this month')->setTime(0, 0, 0);
                    $endOfMonth = (clone $adjustedDate)->modify('last day of this month')->setTime(23, 59, 59);

                    $monthTimestamps = new DatePeriod(
                        $startOfMonth,
                        new DateInterval('P1D'),
                        $endOfMonth->modify('+1 day')
                    );

                    $days = [];
                    foreach ($monthTimestamps as $date) {
                        $timestamp = $date->getTimestamp();
                        $days[$timestamp] = $Times->filter(function ($time) use ($timestamp) {
                            return date('Y-m-d', $time->stamped) == date('Y-m-d', $timestamp);
                        });
                    }

                    $monthsData[$monthNameYear] = $days;
                }
            @endphp

            <ul class="nav nav-tabs" id="monthTabs" role="tablist">
                @foreach($monthsData as $monthYear => $days)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                id="tab-{{ str_replace(' ', '-', $monthYear) }}"
                                data-bs-toggle="tab" data-bs-target="#{{ str_replace(' ', '-', $monthYear) }}"
                                type="button"
                                role="tab" aria-controls="{{ str_replace(' ', '-', $monthYear) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $monthYear }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="myTabContent">
                @foreach($monthsData as $monthYear => $days)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="{{ str_replace(' ', '-', $monthYear) }}"
                             role="tabpanel" aria-labelledby="tab-{{ str_replace(' ', '-', $monthYear) }}">

                            @foreach($days as $timestamp => $times)
                                <div class="d-flex">
                                    <div>{{ date('d.m.Y', $timestamp) }}</div>
                                    @can('timetracking_setany')
                                        <div style="margin-left: auto">
                                            <form class="d-flex" method="POST" action="{{ route('statistik.store') }}"
                                                  onsubmit="submitForm(event, this)">
                                                @csrf
                                                <input type="hidden" name="day" value="{{ $timestamp }}">
                                                <input type="hidden" name="user_id"
                                                       value="{{ ($id ?? auth()->user()->id) }}">
                                                <select class="form-select form-select-sm" name="status" required>
                                                    <option selected disabled>Status</option>
                                                    <option value="1">Normal</option>
                                                    <option value="2">Feiertag</option>
                                                    <option value="3">Urlaub</option>
                                                    <option value="4">Krank</option>
                                                    <option value="5">ÜB ABBAU</option>
                                                </select>
                                                <select class="form-select form-select-sm" name="time" required>
                                                    <option selected disabled>Zeit</option>
                                                    @for ($hours = 0; $hours <= 24; $hours++)
                                                        @php $seconds = $hours * 3600; @endphp
                                                        <option value="{{ $seconds }}">{{ $hours }}std</option>
                                                    @endfor
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Send</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>

                                <div class="progress m-1" id="progress-{{ $timestamp }}">
                                    @forelse($times as $Time)
                                        <div
                                            class="progress-bar progress-bar-striped {{ $cssClasses[$Time->status] ?? 'bg-primary' }}"
                                            style="width: {{ ($Time->time_worked / 86400) * 100 }}%;" aria-valuenow="15"
                                            aria-valuemin="0" aria-valuemax="100"
                                            title="{{ $labels[$Time->status] ?? '' }}: {{ getZeit($Time->time_worked) }}">
                                            <a href="{{ route('request.show', $Time->id) }}">{{ $labels[$Time->status] ?? '' }} {{ getZeit($Time->time_worked) }}</a>
                                        </div>
                                        <div class="progress-bar progress-bar-striped bg-light" role="progressbar"
                                             style="width: 1%" aria-valuenow="15" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    @empty
                                        <div class="progress-bar bg-light" style="width: 100%" aria-valuenow="0"
                                             aria-valuemin="0" aria-valuemax="100">
                                            Keine Einträge
                                        </div>
                                    @endforelse
                                </div>
                            @endforeach

                        </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Tab(document.querySelector('.nav-link.active')).show();
        });
    </script>

    <script>
        function submitForm(event, form) {
            event.preventDefault();
            const formData = new FormData(form);
            const url = form.action;

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const dayValue = form.querySelector('input[name="day"]').value;
                    const progressContainer = document.getElementById('progress-' + dayValue);

                    if (progressContainer) {
                        // Löschen bestehender Fortschritt
                        progressContainer.innerHTML = '';

                        // Bestimmen der passenden CSS-Klasse basierend auf dem Status
                        const statusClasses = {
                            1: 'bg-info',     // Beispiel: Normal
                            2: 'bg-info',     // Beispiel: Feiertag
                            3: 'bg-warning',  // Beispiel: Urlaub
                            4: 'bg-danger',    // Beispiel: Krank
                            5: 'bg-info'    // Beispiel: ÜB Abbabu
                            // Weitere Klassenzuordnungen können hier hinzugefügt werden
                        };
                        const cssClass = statusClasses[data.status] || 'bg-primary';

                        // Progressbar erstellen
                        const progressBar = document.createElement('div');
                        progressBar.className = `progress-bar ${cssClass}`;
                        progressBar.style.width = `${(data.time_worked / 86400) * 100}%`;
                        progressBar.textContent = `${data.time_worked / 3600} Stunden`;
                        progressContainer.appendChild(progressBar);
                    } else {
                        console.error(`No progress container found for day value: ${dayValue}`);
                    }

                    calculateTotalOvertime(); // Überstunden neu berechnen
                })
                .catch(error => console.error('Error:', error));
        }

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
