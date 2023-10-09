@extends('orders::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Aufträge</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item active">Aufträge</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('styles')
    {{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>--}}
@endsection

@section('content')
    @can('showOrders')
        {{--{{dd($OrderDatas)}}--}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Details</h5>
                <p class="small fst-italic">Auftrag wurde von Herrn/Frau {{ $Order->user->name }} der
                    Firma {{ ($Order->user->firma ?? '(keine Firma Angegeben)') }}
                    am {{ $Order->created_at->format('d.m.Y H:i') }} erstellt</p>
                <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                    @isset( $OrderDatas['art'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Fahrzeug</div>
                            <div class="col-lg-9 col-md-8">{{$OrderDatas['art']}}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['firma'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Firma</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['firma'] }}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['name'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Kunde</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['name'] }}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['auftraggeber'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Auftraggeber</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['auftraggeber'] }}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['ansprechpartner'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">abweichender Ansprechpartner</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['ansprechpartner'] }}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['number'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Auftragsnummer</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['number'] }}</div>
                        </div>
                    @endisset

                    @isset( $OrderDatas['kennzeichen'])
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Kennzeichen</div>
                            <div class="col-lg-9 col-md-8">{{ $OrderDatas['kennzeichen'] }}</div>
                        </div>
                    @endisset

                    @if( isset($OrderDatas['datum_von']) OR isset($OrderDatas['datum_bis']) )
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Datum</div>
                            <div
                                class="col-lg-9 col-md-8">{{ (date('d.m.Y',strtotime($OrderDatas['datum_von'])) ?? '') }} {{ (date('d.m.Y',strtotime($OrderDatas['datum_bis']))) }}</div>
                        </div>
                    @endif

                    @if( isset($OrderDatas['desc']) )
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Anmerkungen</div>
                            <div
                                class="col-lg-9 col-md-8">{{ $OrderDatas['desc'] }}</div>
                        </div>
                    @endif

                </div>
                <h5 class="card-title">Beschriftung</h5>

                <div class="row">
                    @if(isset($OrderDatas['bes_vom_kunden']))
                        <div class="col-lg-12 col-md-8">Beschriftung wird vom Kunden Beigestellt</div> @endif
                    @if(isset($OrderDatas['bes_unklar']))
                        <div class="col-lg-12 col-md-8">Beschriftung ist noch in Klärung</div> @endif
                    @if(isset($OrderDatas['bes_von_uns']))
                        <div class="col-lg-12 col-md-8">Beschriftung wird von uns Gestellt</div> @endif
                    @if(isset($OrderDatas['bes_stirnwand']))
                        <div class="col-lg-12 col-md-8">Die Stirnwand muss beschriftet werden</div> @endif
                    @if(isset($OrderDatas['bes_heck']))
                        <div class="col-lg-12 col-md-8">Das Heck muss beschriftet werden</div> @endif
                    @if(isset($OrderDatas['zug_besch']))
                        <div class="col-lg-12 col-md-8">Die Zugmaschine muss beschriftet werden</div> @endif
                    @if(isset($OrderDatas['einsatznummer']))
                        <div class="col-lg-12 col-md-8">Hofnummer: {{ $OrderDatas['einsatznummer'] }}</div> @endif
                    @if(isset($OrderDatas['beschTafeln']))
                        <div class="col-lg-12 col-md-8">
                            Beschriftungstafeln: {{ $OrderDatas['beschTafeln'] }}</div> @endif
                </div>

                <h5 class="card-title">Konturmarkierung</h5>

                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        @if(isset($OrderDatas['kontur_voll']))
                            Vollkonturmarkierung: Obere Linie {{
                            ( isset($OrderDatas['kontur_domwanne']) ? 'auf die Domwanne':
                                ( isset($OrderDatas['kontur_tank']) ? 'auf den Tank':'(Nicht Angegeben)'
                            ) ) }}
                            untere Kontur
                        @elseif ( isset($OrderDatas['kontur_teil']) OR isset($OrderDatas['kontur_line']) )
                            Untere Kontur
                        @endif
                        {{
                        ( isset($OrderDatas['kontur_seitenblende']) ? 'auf die Seitenblende/Schlauchrohr':
                            ( isset($OrderDatas['kontur_over_seitenblende']) ? 'über die Seitenblende/Schlauchrohr':'(Nicht Angegeben)'
                        ) ) }} in der Farbe {{
                            ( isset($OrderDatas['kontur_s_weiss']) ? 'Weiss':
                                ( isset($OrderDatas['kontur_s_gelb']) ? 'Gelb':'(Nicht Angegeben)'
                            ) ) }} {{
                            ( isset($OrderDatas['kontur_segment']) ? 'Segmentierte Kontur verwenden':''
                            )
                            }}
                    </div>
                    <div class="col-lg-12 col-md-8">
                        {{
                        ( isset($OrderDatas['kontur_h_g']) ? 'Heckkontur in Gelb':
                            ( isset($OrderDatas['kontur_h_r']) ? 'Heckkontur in Rot':
                                ( isset($OrderDatas['kontur_h_w']) ? 'Heckkontur in Weiss':'(Nicht Angegeben)'
                        ) ) )
                        }}
                    </div>
                    @if ( isset($OrderDatas['baust_front']) OR isset($OrderDatas['baust_heck']) OR isset($OrderDatas['baust_seite']))
                        <div class="col-lg-12 col-md-8"> Baustellenkontur
                            {{
                            ( isset($OrderDatas['baust_front']) ? 'Front, ':'') .
                            ( isset($OrderDatas['baust_heck']) ? 'Heck, ':'') .
                            ( isset($OrderDatas['baust_seite']) ? 'Seitlich':'')
                            }}
                        </div>
                    @endif
                    @if ( isset($OrderDatas['zug_kontur']) )
                        <div class="col-lg-12 col-md-8"> Zugmaschine Kontur aufkleben!</div>
                    @endif
                </div>

                @if(isset($OrderDatas['steinschlag']))
                    <h5 class="card-title">Steinschlagschutzfolie</h5>

                    <div class="row">
                        @if ( isset($OrderDatas['steinschlag_desc']) )
                            <div class="col-lg-12 col-md-8"> Anmerkungen:
                                {{ $OrderDatas['steinschlag_desc'] }}
                            </div>
                        @endif
                    </div>
                @endif

                @if(isset($OrderDatas['gef_tf']) OR isset($OrderDatas['gef_flame']) OR isset($OrderDatas['gef_atzend']) OR isset($OrderDatas['gef_klarsicht']) OR isset($OrderDatas['gef_neutral']))
                    <h5 class="card-title">Gefahrschutzzeichen</h5>

                    <div class="row">
                        @if ( isset($OrderDatas['gef_tf']) )
                            <div class="col-lg-12 col-md-8"> Toter Fisch aufkleben</div>
                        @endif
                        @if ( isset($OrderDatas['gef_flame']) )
                            <div class="col-lg-12 col-md-8"> Flammensymbol aufkleben</div>
                        @endif
                        @if ( isset($OrderDatas['gef_atzend']) )
                            <div class="col-lg-12 col-md-8"> Ätzend aufkleben</div>
                        @endif
                        @if ( isset($OrderDatas['gef_klarsicht']) )
                            <div class="col-lg-12 col-md-8"> Klarsichtfolie über Gefahrgutzeichen anbringen</div>
                        @endif
                        @if ( isset($OrderDatas['gef_neutral']) )
                            <div class="col-lg-12 col-md-8"> Gefahrgutzeichen Neutralisieren</div>
                        @endif
                    </div>
                @endif

            </div>

        </div>

        <div class="card">
            <div class="card-body">

                @foreach($files as $file)
                    @if( getIsImage($file) )
                        <img src="/image/{{ $Order->link }}/{{ pathinfo($file, PATHINFO_BASENAME) }}" width="200">
                    @elseif( pathinfo($file, PATHINFO_EXTENSION) == 'pdf')
                        <embed src="/image/{{ $Order->link }}/{{ pathinfo($file, PATHINFO_FILENAME) }}.pdf" width="600" height="500" alt="pdf" />
                    @else
                        <a href="{{ $file }}">{{ pathinfo($file, PATHINFO_FILENAME) }}</a> <br>
                    @endif
                @endforeach

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <a href="{{ route('orders.edit', $Order->link) }}">Bearbeiten</a>

            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="..." class="rounded me-2" alt="...">
                    <strong class="me-auto">Bootstrap</strong>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Hello, world! This is a toast message.
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    {{--    <script>--}}
    {{--        var toastElList = [].slice.call(document.querySelectorAll('.toast'))--}}
    {{--        var toastList = toastElList.map(function (toastEl) {--}}
    {{--            return new bootstrap.Toast(toastEl, option)--}}
    {{--        })--}}
    {{--        toast.show();--}}
    {{--    </script>--}}

@endsection
