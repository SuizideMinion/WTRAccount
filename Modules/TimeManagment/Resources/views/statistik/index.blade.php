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


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Zeiterfassung {{ ( isset($id) ? 'von '. $user->name:'' ) }}</h5>
            <div id="reportsChart" style="min-height: 365px;">
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#reportsChart"), {
                            "annotations": {},
                            "chart": {
                                "animations": {
                                    "enabled": false,
                                    "easing": "swing"
                                },
                                "background": "",
                                "foreColor": "#333",
                                "fontFamily": "Roboto",
                                "height": 250,
                                "id": "ahu89",
                                "toolbar": {
                                    "show": false
                                },
                                "type": "bar",
                            },
                            "plotOptions": {
                                "bar": {
                                    "borderRadius": 10,
                                    "borderRadiusApplication": "end",
                                    "borderRadiusWhenStacked": "last",
                                    "hideZeroBarsWhenGrouped": false,
                                    "isDumbbell": false,
                                    "isFunnel": false,
                                    "isFunnel3d": true,
                                    "dataLabels": {
                                        "total": {
                                            "enabled": false,
                                            "offsetX": 0,
                                            "offsetY": 0,
                                            "style": {
                                                "color": "#373d3f",
                                                "fontSize": "12px",
                                                "fontWeight": 600
                                            }
                                        }
                                    }
                                },
                                "bubble": {
                                    "zScaling": true
                                },
                                "treemap": {
                                    "dataLabels": {
                                        "format": "scale"
                                    }
                                },
                                "radialBar": {
                                    "hollow": {
                                        "background": "#fff"
                                    },
                                    "dataLabels": {
                                        "name": {},
                                        "value": {},
                                        "total": {}
                                    }
                                },
                                "pie": {
                                    "donut": {
                                        "labels": {
                                            "name": {},
                                            "value": {},
                                            "total": {}
                                        }
                                    }
                                }
                            },
                            "dataLabels": {
                                "enabled": false,
                                "style": {
                                    "fontWeight": 700
                                }
                            },
                            "grid": {
                                "padding": {
                                    "right": 25,
                                    "left": 15
                                }
                            },
                            "legend": {
                                "fontSize": 14,
                                "offsetY": 0,
                                "markers": {
                                    "shape": "square",
                                    "size": 8
                                },
                                "itemMargin": {
                                    "vertical": 0
                                }
                            },
                            "series": [
                                {
                                    "name": "Diese Woche",
                                    "data": [
                                        {
                                            "x": "Montag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday" ), strtotime( "previous monday + 1 day")) }}
                                        },
                                        {
                                            "x": "Dienstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 1 day" ), strtotime( "previous monday + 2 day")) }}
                                        },
                                        {
                                            "x": "Mittwoch",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 2 day" ), strtotime( "previous monday + 3 day")) }}
                                        },
                                        {
                                            "x": "Donnerstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 3 day" ), strtotime( "previous monday + 4 day")) }}
                                        },
                                        {
                                            "x": "Freitag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 4 day" ), strtotime( "previous monday + 5 day")) }}
                                        },
                                        {
                                            "x": "Samstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 5 day" ), strtotime( "previous monday + 6 day")) }}
                                        },
                                        {
                                            "x": "Sonntag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 6 day" ), strtotime( "previous monday + 7 day")) }}
                                        }
                                    ]
                                },
                                {
                                    "name": "Letzte Woche",
                                    "data": [
                                        {
                                            "x": "Montag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday - 1 week" ), strtotime( "previous monday + 1 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Dienstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 1 day - 1 week" ), strtotime( "previous monday + 2 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Mittwoch",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 2 day - 1 week" ), strtotime( "previous monday + 3 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Donnerstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 3 day - 1 week" ), strtotime( "previous monday + 4 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Freitag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 4 day - 1 week" ), strtotime( "previous monday + 5 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Samstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 5 day - 1 week" ), strtotime( "previous monday + 6 day - 1 week")) }}
                                        },
                                        {
                                            "x": "Sonntag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 6 day - 1 week" ), strtotime( "previous monday + 7 day - 1 week")) }}
                                        }
                                    ]
                                },
                                {
                                    "name": "vorletzte Woche",
                                    "data": [
                                        {
                                            "x": "Montag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday - 2 week" ), strtotime( "previous monday + 1 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Dienstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 1 day - 2 week" ), strtotime( "previous monday + 2 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Mittwoch",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 2 day - 2 week" ), strtotime( "previous monday + 3 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Donnerstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 3 day - 2 week" ), strtotime( "previous monday + 4 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Freitag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 4 day - 2 week" ), strtotime( "previous monday + 5 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Samstag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 5 day - 2 week" ), strtotime( "previous monday + 6 day - 2 week")) }}
                                        },
                                        {
                                            "x": "Sonntag",
                                            "y": {{ getTimeForStatistik(($id ?? auth()->user()->id), strtotime( "previous monday + 6 day - 2 week" ), strtotime( "previous monday + 7 day - 2 week")) }}
                                        }
                                    ]
                                }
                            ],
                            "stroke": {
                                "fill": {
                                    "type": "solid",
                                    "opacity": 0.85,
                                    "gradient": {
                                        "shade": "dark",
                                        "type": "horizontal",
                                        "shadeIntensity": 0.5,
                                        "inverseColors": true,
                                        "opacityFrom": 1,
                                        "opacityTo": 1,
                                        "stops": [
                                            0,
                                            50,
                                            100
                                        ],
                                        "colorStops": []
                                    }
                                }
                            },
                            "tooltip": {
                                "shared": false,
                                "intersect": true
                            },
                            "xaxis": {
                                "labels": {
                                    "trim": true,
                                    "style": {}
                                },
                                "group": {
                                    "groups": [],
                                    "style": {
                                        "colors": [],
                                        "fontSize": "12px",
                                        "fontWeight": 400,
                                        "cssClass": ""
                                    }
                                },
                                "tickPlacement": "between",
                                "title": {
                                    "style": {
                                        "fontWeight": 700
                                    }
                                },
                                "tooltip": {
                                    "enabled": false
                                }
                            },
                            "yaxis": {
                                "tickAmount": 5,
                                "max": 24,
                                "min": 0,
                                "labels": {
                                    "style": {}
                                },
                                "title": {
                                    "style": {
                                        "fontWeight": 700
                                    }
                                }
                            },
                            "theme": {
                                "palette": "palette4"
                            }
                        }).render();
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @for($i = 0; $i <= 60; $i++)
{{--                {{ strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00') }} -> {{ strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 24:00:00') }}--}}
                <div>{{ date('d.m.Y', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')) }}</div>
                <div class="progress m-1">
                    @foreach($Times->where('stamped', '<', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 24:00:00'))->where('stamped_out', '>', strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')) as $Time)
                        @php isset($count) ? ($count == 6 ? $count = 0 : $count++):$count = 0 @endphp
                        <div class="progress-bar progress-bar-striped bg-{{ getBootstrapColor($count) }}" role="progressbar" style="width: {{ ($Time->time_worked / 86400) * 100 }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            {{ getZeit($Time->time_worked) }}
                        </div>
                    @endforeach
                </div>
            @endfor

        </div>
    </div>

@endsection
