@extends('orders::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Aufträge</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Aufträge</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.create') }}">Auftrag Erstellen</a></li>
                <li class="breadcrumb-item active">TKW Auftrag Erstellen</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('styles')

    <style>
        h6 {
            padding: 5px 0px 5px 0px !important;
            font-size: 14px !important;
        }
    </style>

@endsection

@section('content')
    @can('showOrders')

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Auftrag für einen TKW Erstellen</h5>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="art" value="TKW">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Details</h5>
                            <div class="row mb-3">

                            <!-- Floating Labels Form -->
                                <div class="col-sm-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Auftraggeber" name="auftraggeber" value="{{ auth()->user()->name }}" required>
                                        <label for="floatingName">Auftraggeber</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Kundenname" name="name" required>
                                        <label for="floatingName">Kundenname</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Gesprächspartner" name="ansprechpartner">
                                        <label for="floatingName">Gesprächspartner</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Auftragsnummer" name="number">
                                        <label for="floatingName">Auftragsnummer</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Kennzeichen" name="kennzeichen">
                                        <label for="floatingName">Kennzeichen</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Ausführdatum von" name="datum_von">
                                        <label for="floatingName">Ausführdatum von</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName"
                                               placeholder="Ausführdatum bis" name="datum_bis">
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
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="bes_vom_kunden">
                                        <label class="form-check-label" for="gridCheck1">
                                            Vom Kunden Gestellt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="bes_von_uns">
                                        <label class="form-check-label" for="gridCheck1">
                                            Von Beschrifter Gestellt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="bes_unklar">
                                        <label class="form-check-label" for="gridCheck1">
                                            In Klärung
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingName" name="einsatznummer"
                                                   placeholder="Hof/Einsatz Nummer">
                                            <label for="floatingName">Hof/Einsatz Nummer</label>
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
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="steinschlag">
                                        <label class="form-check-label" for="gridCheck1">
                                            Steinschlagschutzfolie anbringen
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" name="steinschlag_desc"
                                               placeholder="Steinschlagschutz zusatz">
                                        <label for="floatingName">Steinschlagschutz zusatz</label>
                                    </div>
                                </div>
                            </div>


                            <h6 class="card-title">Gefahrguttafeln</h6>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="gef_tf">
                                        <label class="form-check-label" for="gridCheck1">
                                            Gefahrgut 'Toter Fisch' anbringen
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="gef_flame">
                                        <label class="form-check-label" for="gridCheck1">
                                            Gefahrgut 'Flammensymbol' anbringen
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="gef_atzend">
                                        <label class="form-check-label" for="gridCheck1">
                                            Gefahrgut 'Ätzend' anbringen
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
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_voll">
                                        <label class="form-check-label" for="gridCheck1">
                                            Vollkontur
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_teil">
                                        <label class="form-check-label" for="gridCheck1">
                                            Teilkontur
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_line">
                                        <label class="form-check-label" for="gridCheck1">
                                            Linienkontur
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_seitenblende">
                                        <label class="form-check-label" for="gridCheck1">
                                            Auf Seitenblende
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_over_seitenblende">
                                        <label class="form-check-label" for="gridCheck1">
                                            über Seitenblende
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_domwanne">
                                        <label class="form-check-label" for="gridCheck1">
                                            Auf Domwanne
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_tank">
                                        <label class="form-check-label" for="gridCheck1">
                                            Auf Tank
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_s_weiss">
                                        <label class="form-check-label" for="gridCheck1">
                                            Weiss
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_s_gelb">
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
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_h_w">
                                        <label class="form-check-label" for="gridCheck1">
                                            Weiss
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_h_g">
                                        <label class="form-check-label" for="gridCheck1">
                                            Gelb
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="kontur_h_r">
                                        <label class="form-check-label" for="gridCheck1">
                                            Rot
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="card-title">Baustellenkontur</h6>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="baust_front">
                                        <label class="form-check-label" for="gridCheck1">
                                            Front
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="baust_heck">
                                        <label class="form-check-label" for="gridCheck1">
                                            Heck
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="baust_seite">
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
                            <h5 class="card-title">Bemerkungen</h5>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Bemerkungen" id="floatingTextarea" name="desc"
                                              style="height: 300px;"></textarea>
                                    <label for="floatingTextarea">Bemerkungen</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="file" type="file" class="form-control" name="images[]" placeholder="Image" multiple>
                                    <label for="file">Image</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" value="submit">Hi There</button>
        </form>

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
