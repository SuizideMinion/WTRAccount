@extends('orders::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Aufträge</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Aufträge</a></li>
                <li class="breadcrumb-item active">Auftrag Erstellen</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('styles')

    <style>

        .form-check {
            padding-left: 2.5em;
        }

    </style>

@endsection

@section('content')
    @can('showOrders')

        <div class="card">
            <div class="card-body">

                @isset($edit)
                    <form method="post" enctype="multipart/form-data" action="{{ route('orders.update', $Order->link) }}">
                        @method('PUT')
                        @else
                            <form method="post" enctype="multipart/form-data" action="{{ route('orders.store') }}">
                                @endisset
                                @csrf
                                <div class="d-flex justify-content-center mt-3" style="height: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tkw"
                                               id="tkw" {{ isset($OrderDatas['tkw']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="tkw">
                                            TKW
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="lkw"
                                               id="lkw" {{ isset($OrderDatas['lkw']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="lkw">
                                            LKW
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="zaa"
                                               id="zaa" {{ isset($OrderDatas['zaa']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="zaa">
                                            ZAA
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="szm"
                                               id="szm" {{ isset($OrderDatas['szm']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="szm">
                                            SZM
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sal"
                                               id="sal" {{ isset($OrderDatas['sal']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="sal">
                                            SAL
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bus"
                                               id="bus" {{ isset($OrderDatas['bus']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="bus">
                                            BUS
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pkw"
                                               id="pkw" {{ isset($OrderDatas['pkw']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="pkw">
                                            PKW
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="auf"
                                               id="auf" {{ isset($OrderDatas['auf']) ? 'checked':'' }}>
                                        <label class="form-check-label" for="auf">
                                            Aufkleber
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Details</h5>
                                                <div class="row mb-3">
                                                {{--                                        <input type="hidden" name="firma" value="{{ auth()->user()->firma }}">--}}
                                                <!-- Floating Labels Form -->
                                                    <div class="col-sm-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Firma" name="firma"
                                                                   value="{{ $OrderDatas['firma'] ?? auth()->user()->firma }}"
                                                                   required>
                                                            <label for="floatingName">Firma</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Auftraggeber" name="auftraggeber"
                                                                   value="{{ $OrderDatas['auftraggeber'] ?? auth()->user()->name }}"
                                                                   required>
                                                            <label for="floatingName">Auftraggeber</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Kundenname" name="name"
                                                                   value="{{ $OrderDatas['name'] ?? '' }}" required>
                                                            <label for="floatingName">Kundenname</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Gesprächspartner" name="ansprechpartner"
                                                                   value="{{ $OrderDatas['ansprechpartner'] ?? '' }}">
                                                            <label for="floatingName">Abweichender
                                                                Gesprächspartner</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Auftragsnummer" name="number"
                                                                   value="{{ $OrderDatas['number'] ?? '' }}">
                                                            <label for="floatingName">Auftragsnummer</label>
                                                        </div>
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   placeholder="Kennzeichen" name="kennzeichen"
                                                                   value="{{ $OrderDatas['kennzeichen'] ?? '' }}">
                                                            <label for="floatingName">Kennzeichen</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type="date" class="form-control"
                                                                       id="floatingName"
                                                                       placeholder="Ausführdatum von" name="datum_von"
                                                                       value="{{ $OrderDatas['datum_von'] ?? '' }}">
                                                                <label for="floatingName">Ausführdatum von</label>
                                                            </div>
                                                            <div class="form-floating">
                                                                <input type="date" class="form-control"
                                                                       id="floatingName"
                                                                       placeholder="Ausführdatum bis" name="datum_bis"
                                                                       value="{{ $OrderDatas['datum_bis'] ?? '' }}">
                                                                <label for="floatingName">Ausführdatum bis</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Beschriftung</h5>

                                                <!-- Floating Labels Form -->
                                                <div class="row mb-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="bes_vom_kunden" {{ isset($OrderDatas['bes_vom_kunden']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Vom Kunden Gestellt
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="bes_von_uns" {{ isset($OrderDatas['bes_von_uns']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Von Beschrifter Gestellt
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="bes_unklar" {{ isset($OrderDatas['bes_unklar']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                In Klärung
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="bes_stirnwand" {{ isset($OrderDatas['bes_stirnwand']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Stirnwand
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="bes_heck" {{ isset($OrderDatas['bes_heck']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Heck
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       id="floatingName"
                                                                       name="einsatznummer"
                                                                       value="{{ $OrdersData['einsatznummer'] ?? '' }}"
                                                                       placeholder="Hof/Einsatz Nummer">
                                                                <label for="floatingName">Hof/Einsatz Nummer</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control"
                                                                       id="floatingName"
                                                                       name="beschTafeln"
                                                                       value="{{ $OrdersData['beschTafeln'] ?? '' }}"
                                                                       placeholder="Beschriftungstafeln">
                                                                <label for="floatingName">Beschriftungstafeln</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Sonstiges</h5>

                                                <h6 class="card-title">Steinschlagschutzfolie</h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="steinschlag" {{ isset($OrderDatas['steinschlag']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Steinschlagschutzfolie anbringen
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="floatingName"
                                                                   name="steinschlag_desc"
                                                                   value="{{ $OrdersData['steinschlag_desc'] ?? '' }}"
                                                                   placeholder="Steinschlagschutz zusatz">
                                                            <label for="floatingName">Anmerkungen</label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <h6 class="card-title">Gefahrguttafeln</h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="gef_tf" {{ isset($OrderDatas['gef_tf']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gefahrgut 'Toter Fisch' anbringen
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="gef_flame" {{ isset($OrderDatas['gef_flame']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gefahrgut 'Flammensymbol' anbringen
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="gef_atzend" {{ isset($OrderDatas['gef_atzend']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gefahrgut 'Ätzend' anbringen
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="gef_klarsicht" {{ isset($OrderDatas['gef_klarsicht']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gefahrgut Beklebung mit Klarsichtfolie überkleben
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="gef_neutral" {{ isset($OrderDatas['gef_neutral']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gefahrgut Beklebung mit Neutralisierungsfolie überkleben
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Konturmarkierung</h5>

                                                <h6 class="card-title">Seitlich</h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_voll" {{ isset($OrderDatas['kontur_voll']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Vollkontur
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_teil" {{ isset($OrderDatas['kontur_teil']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Teilkontur
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_line" {{ isset($OrderDatas['kontur_line']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Linienkontur
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_seitenblende" {{ isset($OrderDatas['kontur_seitenblende']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Auf Seitenblende
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_over_seitenblende" {{ isset($OrderDatas['kontur_over_seitenblende']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                über Seitenblende
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_domwanne" {{ isset($OrderDatas['kontur_domwanne']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Auf Domwanne
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_tank" {{ isset($OrderDatas['kontur_tank']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Auf Tank
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_segmente" {{ isset($OrderDatas['kontur_segmente']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Segmentiert
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_s_weiss" {{ isset($OrderDatas['kontur_s_weiss']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Weiss
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_s_gelb" {{ isset($OrderDatas['kontur_s_gelb']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gelb
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6 class="card-title">Heck</h6>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_h_w" {{ isset($OrderDatas['kontur_h_w']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Weiss
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_h_g" {{ isset($OrderDatas['kontur_h_g']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Gelb
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="kontur_h_r" {{ isset($OrderDatas['kontur_h_r']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Rot
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="card-title">Baustellenkontur</h6>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="baust_front" {{ isset($OrderDatas['baust_front']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Front
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="baust_heck" {{ isset($OrderDatas['baust_heck']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Heck
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="gridCheck1"
                                                                   name="baust_seite" {{ isset($OrderDatas['baust_seite']) ? 'checked':'' }}>
                                                            <label class="form-check-label" for="gridCheck1">
                                                                Seitlich
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Zugmaschine</h5>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1"
                                                           name="zug_besch" {{ isset($OrderDatas['zug_besch']) ? 'checked':'' }}>
                                                    <label class="form-check-label" for="gridCheck1">
                                                        Beschriftung
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1"
                                                           name="zug_kontur" {{ isset($OrderDatas['zug_kontur']) ? 'checked':'' }}>
                                                    <label class="form-check-label" for="gridCheck1">
                                                        Konturmakierung
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Bemerkungen</h5>

                                                <div class="col-12">
                                                    <div class="form-floating">
                                    <textarea class="form-control" placeholder="Bemerkungen" id="floatingTextarea"
                                              name="desc"
                                              style="height: 300px;">{{ $OrdersData['desc'] ?? '' }}</textarea>
                                                        <label for="floatingTextarea">Bemerkungen</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <input id="file" type="file" class="form-control"
                                                               name="images[]"
                                                               placeholder="Image" multiple>
                                                        <label for="file">Image</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" value="submit">Speichern</button>
                            </form>
            </div>
        </div>

    @endcan
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("form")
                .find(".step2").hide().end()
                .find("#auswahl").change(function () {
                $("form").find(".step2").toggle().end();
            }).end()
                .find(":input:first").focus().end()
                .submit(function () {
                    step3();
                    return false;
                });
        });
    </script>
@endsection
