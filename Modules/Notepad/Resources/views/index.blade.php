@extends('notepad::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Notizblock</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item active">Notizblock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.notepad')

        <div class="col-lg-12">
            <div class="card-body">

                <!-- Default Accordion -->
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Neue Notiz Speichern
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <form method="post" action="{{ route('notepad.store')}}">
                                    {{ csrf_field() }}

                                    <label for="inputText"></label>
                                    <input type="text" class="form-control"
                                           id="inputText" name="title"
                                           placeholder="Titel">
                                    <textarea name="text" style="width: 100%;height: 400px"
                                              placeholder="Text"></textarea>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div><!-- End Default Accordion Example -->

            </div>

        </div>




        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Notizen</h5>

                @foreach($Notes as $Note)



                    <span class="badge bg-light text-dark">
                        <form method="POST" action="{{ route('notepad.destroy', $Note->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                title="Löschen"
                                type="submit"><i class="bi bi-x"></i>
                            </button>
                        <a href="{{ route('notepad.show', $Note->id) }}">{{ $Note->title }}</a> vom {{ $Note->updated_at->format('d.m.Y h:i:s') }}
                        </form>
                    </span><br>
                @endforeach

            </div>
        </div>

    @endcan
@endsection
